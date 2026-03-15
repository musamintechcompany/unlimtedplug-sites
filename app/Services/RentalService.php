<?php

namespace App\Services;

use App\Models\Rental;
use App\Models\RentableProject;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class RentalService
{
    private function getDurationSeconds(string $durationType): int
    {
        $isLocal = config('app.env') === 'local';

        if ($isLocal) {
            return match($durationType) {
                'daily' => 120,
                'weekly' => 300,
                'monthly' => 600,
                'yearly' => 900,
                default => 1
            };
        }

        return match($durationType) {
            'daily' => 86400,
            'weekly' => 604800,
            'monthly' => 2592000,
            'yearly' => 31536000,
            default => 1
        };
    }

    public function createRental(User $user, $projectId, string $durationType, int $durationValue): ?Rental
    {
        try {
            $project = RentableProject::findOrFail($projectId);
            
            $priceMap = [
                'daily' => $project->pricing_24h,
                'weekly' => $project->pricing_7d,
                'monthly' => $project->pricing_30d,
                'yearly' => $project->pricing_365d
            ];
            
            $pricePerUnit = $priceMap[$durationType];
            $creditsCost = $pricePerUnit * $durationValue;
            $durationSeconds = $this->getDurationSeconds($durationType) * $durationValue;
            
            $wallet = $user->wallet;

            \Log::info('Rental creation attempt', [
                'user_id' => $user->id,
                'project_id' => $projectId,
                'credits_needed' => $creditsCost,
                'wallet_balance' => $wallet ? $wallet->credits_balance : 'no wallet'
            ]);

            if (!$wallet || $wallet->credits_balance < $creditsCost) {
                \Log::warning('Insufficient credits', ['user_id' => $user->id, 'credits_needed' => $creditsCost]);
                return null;
            }

            $wallet->decrement('credits_balance', $creditsCost);

            $rentalId = Str::uuid();
            $response = $this->createTenantOnProject($project, $user, $rentalId);

            if (!$response || !$response['success']) {
                \Log::error('Tenant creation failed, refunding credits', ['user_id' => $user->id, 'project_id' => $projectId]);
                $wallet->increment('credits_balance', $creditsCost);
                return null;
            }

            $adminUrl = $response['data']['admin_url'] ?? ($project->api_url ? $project->api_url . '/admin' : null);
            $appUrl = $response['data']['app_url'] ?? ($project->api_url ? $project->api_url : null);
            $rental = Rental::create([
                'id' => $rentalId,
                'user_id' => $user->id,
                'rentable_project_id' => $project->id,
                'duration_type' => $durationType,
                'duration_value' => $durationValue,
                'credits_cost' => $creditsCost,
                'initial_details' => [
                    'duration_type' => $durationType,
                    'duration_value' => $durationValue,
                    'credits_cost' => $creditsCost,
                    'rental_starts_at' => now()->toIso8601String(),
                    'admin_url' => $adminUrl,
                    'app_url' => $appUrl
                ],
                'rental_starts_at' => now(),
                'rental_expires_at' => now()->addSeconds($durationSeconds),
                'admin_id' => $response['data']['admin_id'] ?? null,
                'admin_email' => $response['data']['email'] ?? null,
                'admin_password' => $response['data']['password'] ?? null,
                'admin_url' => $adminUrl,
                'app_url' => $appUrl,
                'status' => 'active'
            ]);

            Transaction::create([
                'transactable_type' => Rental::class,
                'transactable_id' => $rental->id,
                'amount' => $creditsCost,
                'type' => 'rental',
                'description' => "Rental: {$project->name} for {$durationValue} {$durationType}"
            ]);

            \Log::info('Rental created successfully', ['rental_id' => $rental->id, 'user_id' => $user->id]);
            \App\Services\NotificationService::rentalCreated($user, $project->name, $creditsCost, $durationValue, $durationType, $rental->id);
            \App\Services\NotificationService::adminNewRental($user, $project->name, $creditsCost, $durationValue, $durationType);

            return $rental;
        } catch (\Exception $e) {
            \Log::error('Rental creation exception: ' . $e->getMessage());
            return null;
        }
    }

    public function renewRental(Rental $rental, int $additionalHours): ?Rental
    {
        $project = $rental->rentableProject;
        $user = $rental->user;
        $pricePerHour = $project->pricing_24h / 24;
        $creditsCost = ceil($pricePerHour * $additionalHours);
        $wallet = $user->wallet;

        if (!$wallet || $wallet->credits_balance < $creditsCost) {
            return null;
        }

        $wallet->decrement('credits_balance', $creditsCost);

        Transaction::create([
            'transactable_type' => Rental::class,
            'transactable_id' => $rental->id,
            'amount' => $creditsCost,
            'type' => 'rental',
            'description' => "Renewal: {$project->name} for {$additionalHours} hours"
        ]);

        $newExpiryDate = $rental->rental_expires_at->addHours($additionalHours);

        if ($rental->status === 'expired' && $rental->admin_id) {
            $this->restoreCredentialsOnProject($project, $rental->admin_id);
        }

        $rental->update([
            'rental_expires_at' => $newExpiryDate,
            'status' => 'active'
        ]);

        return $rental;
    }

    private function createTenantOnProject(RentableProject $project, User $user, string $rentalId = null): ?array
    {
        try {
            if (!$project->api_url) {
                return ['success' => true, 'data' => ['admin_id' => null, 'email' => 'admin@' . $project->slug . '.local', 'password' => Str::random(16), 'admin_url' => null]];
            }

            $response = Http::timeout(120)
                ->acceptJson()
                ->withHeaders([
                    'Authorization' => 'Bearer ' . config('app.ups_project_connector_api_key'),
                    'X-Platform-Secret' => config('app.ups_project_connector_api_secret'),
                    'X-User-ID' => $user->id
                ])
                ->post("{$project->api_url}/api/tenant/create", [
                    'rental_id' => $rentalId ?? Str::uuid(),
                    'platform_user_id' => $user->id
                ]);

            \Log::info('Tenant creation API response', ['status' => $response->status()]);

            if ($response->successful() && ($response->json()['success'] ?? false)) {
                return $response->json();
            }
            
            return ['success' => true, 'data' => ['admin_id' => null, 'email' => 'admin@' . $project->slug . '.local', 'password' => Str::random(16), 'admin_url' => null]];
        } catch (\Exception $e) {
            \Log::error("Tenant creation error: " . $e->getMessage());
            return ['success' => true, 'data' => ['admin_id' => null, 'email' => 'admin@' . $project->slug . '.local', 'password' => Str::random(16), 'admin_url' => null]];
        }
    }

    public function restoreCredentialsOnProject(RentableProject $project, string $adminId): bool
    {
        try {
            $apiKey = config('app.ups_project_connector_api_key');
            $apiSecret = config('app.ups_project_connector_api_secret');
            $userId = auth()->id() ?? 'unknown';
            
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'X-Platform-Secret' => $apiSecret,
                'X-User-ID' => $userId
            ])->post("{$project->api_url}/api/tenant/restore/{$adminId}");
            
            \Log::info('Restore credentials response', ['status' => $response->status()]);
            return $response->successful();
        } catch (\Exception $e) {
            \Log::error("Failed to restore credentials on {$project->name}: " . $e->getMessage());
            return false;
        }
    }

    public function suspendExpiredRentals(): int
    {
        $expiredRentals = Rental::where('status', 'active')
            ->where('rental_expires_at', '<', now())
            ->get();

        \Log::info('Checking for expired rentals', ['count' => $expiredRentals->count()]);

        $count = 0;
        foreach ($expiredRentals as $rental) {
            $project = $rental->rentableProject;
            
            if ($rental->admin_id) {
                try {
                    $apiKey = config('app.ups_project_connector_api_key');
                    $apiSecret = config('app.ups_project_connector_api_secret');
                    
                    Http::withHeaders([
                        'Authorization' => 'Bearer ' . $apiKey,
                        'X-Platform-Secret' => $apiSecret,
                        'X-User-ID' => $rental->user_id
                    ])->delete("{$project->api_url}/api/tenant/{$rental->admin_id}");
                } catch (\Exception $e) {
                    \Log::error("Failed to delete credentials: " . $e->getMessage());
                }
            }

            $rental->update(['status' => 'expired']);
            \Log::info('Rental suspended', ['rental_id' => $rental->id]);
            \App\Services\NotificationService::rentalSuspended($rental->user, $project->name, $rental->id);
            \App\Services\NotificationService::adminRentalExpired($rental->user, $project->name);
            $count++;
        }

        \Log::info('Total rentals suspended', ['count' => $count]);
        return $count;
    }
}
