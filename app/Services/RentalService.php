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
    public function createRental(User $user, $projectId, string $durationType, int $durationValue): ?Rental
    {
        $project = RentableProject::findOrFail($projectId);
        
        // Use the correct pricing based on duration type
        $priceMap = [
            'daily' => $project->pricing_24h,
            'weekly' => $project->pricing_7d,
            'monthly' => $project->pricing_30d,
            'yearly' => $project->pricing_365d
        ];
        
        $daysMap = [
            'daily' => 1,
            'weekly' => 7,
            'monthly' => 30,
            'yearly' => 365
        ];
        
        $pricePerUnit = $priceMap[$durationType];
        $daysPerUnit = $daysMap[$durationType];
        $creditsCost = $pricePerUnit * $durationValue;
        $totalDays = $daysPerUnit * $durationValue;
        
        $wallet = $user->wallet;

        \Log::info('Rental creation attempt', [
            'user_id' => $user->id,
            'project_id' => $projectId,
            'duration_type' => $durationType,
            'duration_value' => $durationValue,
            'credits_needed' => $creditsCost,
            'wallet_balance' => $wallet ? $wallet->credits_balance : 'no wallet'
        ]);

        if (!$wallet || $wallet->credits_balance < $creditsCost) {
            \Log::warning('Insufficient credits', [
                'user_id' => $user->id,
                'credits_needed' => $creditsCost,
                'wallet_balance' => $wallet ? $wallet->credits_balance : 'no wallet'
            ]);
            return null;
        }

        $wallet->decrement('credits_balance', $creditsCost);

        Transaction::create([
            'id' => Str::uuid(),
            'user_id' => $user->id,
            'amount' => $creditsCost,
            'type' => 'rental',
            'description' => "Rental: {$project->name} for {$durationValue} {$durationType}"
        ]);

        $response = $this->createTenantOnShipping($project, $user);

        if (!$response || !$response['success']) {
            \Log::error('Tenant creation failed, refunding credits', [
                'user_id' => $user->id,
                'project_id' => $projectId,
                'api_response' => $response
            ]);
            $wallet->increment('credits_balance', $creditsCost);
            Transaction::create([
                'id' => Str::uuid(),
                'user_id' => $user->id,
                'amount' => $creditsCost,
                'type' => 'refund',
                'description' => "Refund: Failed to create rental for {$project->name}"
            ]);
            return null;
        }

        $rental = Rental::create([
            'id' => Str::uuid(),
            'user_id' => $user->id,
            'rentable_project_id' => $project->id,
            'duration_days' => $totalDays,
            'credits_cost' => $creditsCost,
            'rental_starts_at' => now(),
            'rental_expires_at' => now()->addDays($totalDays),
            'admin_id' => $response['data']['admin_id'] ?? null,
            'admin_email' => $response['data']['email'],
            'admin_password' => $response['data']['password'],
            'status' => 'active'
        ]);

        return $rental;
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
            'id' => Str::uuid(),
            'user_id' => $user->id,
            'amount' => $creditsCost,
            'type' => 'rental',
            'description' => "Renewal: {$project->name} for {$additionalHours} hours"
        ]);

        $newExpiryDate = $rental->rental_expires_at->addHours($additionalHours);

        if ($rental->status === 'on_hold' && $rental->admin_id) {
            $this->activateTenantOnShipping($project, $rental->admin_id);
        }

        $rental->update([
            'rental_expires_at' => $newExpiryDate,
            'status' => 'active'
        ]);

        return $rental;
    }

    private function createTenantOnShipping(RentableProject $project, User $user): ?array
    {
        try {
            // Send minimal data - let the project auto-generate credentials
            $response = Http::acceptJson()->post("{$project->api_url}/api/tenant/create", [
                'rental_id' => Str::uuid(), // Unique identifier for this rental
                'platform_user_id' => $user->id // Reference to the renting user
            ]);

            if ($response->successful()) {
                $data = $response->json();
                if ($data['success'] ?? false) {
                    return $data;
                }
            }
            
            \Log::error("Failed to create tenant on {$project->name}: Status {$response->status()}", ['response' => $response->body()]);
        } catch (\Exception $e) {
            \Log::error("Failed to create tenant on {$project->name}: " . $e->getMessage());
        }

        return null;
    }

    private function activateTenantOnShipping(RentableProject $project, string $adminId): bool
    {
        try {
            $response = Http::post("{$project->api_url}/api/tenant/activate/{$adminId}");
            return $response->successful();
        } catch (\Exception $e) {
            \Log::error("Failed to activate tenant on {$project->name}: " . $e->getMessage());
        }

        return false;
    }

    public function suspendExpiredRentals(): int
    {
        $expiredRentals = Rental::where('status', 'active')
            ->where('rental_expires_at', '<', now())
            ->get();

        $count = 0;
        foreach ($expiredRentals as $rental) {
            $project = $rental->rentableProject;
            
            if ($rental->admin_id) {
                try {
                    Http::post("{$project->api_url}/api/tenant/hold/{$rental->admin_id}");
                } catch (\Exception $e) {
                    \Log::error("Failed to hold tenant: " . $e->getMessage());
                }
            }

            $rental->update(['status' => 'on_hold']);
            $count++;
        }

        return $count;
    }
}
