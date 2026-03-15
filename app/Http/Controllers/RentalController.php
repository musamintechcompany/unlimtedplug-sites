<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use App\Models\RentableProject;
use App\Services\RentalService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RentalController extends Controller
{
    protected $rentalService;

    public function __construct(RentalService $rentalService)
    {
        $this->rentalService = $rentalService;
    }

    public function index()
    {
        $rentals = auth()->user()->rentals()->with('rentableProject')->latest()->get();
        return view('rentals.index', compact('rentals'));
    }

    public function show(Rental $rental)
    {
        if ($rental->user_id !== auth()->id()) {
            abort(403);
        }
        
        $rental->load('rentableProject');
        return view('rentals.show', compact('rental'));
    }

    public function store(Request $request)
    {
        \Log::info('Rental store method called', ['user_id' => auth()->id()]);
        
        if (!auth()->check()) {
            \Log::warning('User not authenticated for rental creation');
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
            return redirect()->route('login');
        }

        try {
            $validated = $request->validate([
                'project_id' => 'required|exists:rentable_projects,id',
                'duration_type' => 'required|in:daily,weekly,monthly,yearly',
                'duration_value' => 'required|integer|min:1',
            ]);

            $rental = $this->rentalService->createRental(
                auth()->user(),
                $validated['project_id'],
                $validated['duration_type'],
                $validated['duration_value']
            );

            if (!$rental) {
                \Log::warning('Rental creation returned null', ['user_id' => auth()->id()]);
                return response()->json([
                    'success' => false,
                    'error' => 'Rental creation failed. This could be due to insufficient credits or the target project being unavailable. Please check your credit balance and try again.'
                ], 400);
            }

            return response()->json([
                'success' => true,
                'rental_id' => $rental->id,
                'message' => 'Rental created successfully'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation failed', ['errors' => $e->errors()]);
            return response()->json([
                'success' => false,
                'error' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Rental creation exception: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'An error occurred while creating the rental: ' . $e->getMessage()
            ], 500);
        }
    }

    public function updateCredentials(Rental $rental)
    {
        if ($rental->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'error' => 'Unauthorized'], 403);
        }

        try {
            $project = $rental->rentableProject;
            $url = "{$project->api_url}/api/tenant/status/{$rental->admin_id}";
            
            $response = \Illuminate\Support\Facades\Http::timeout(60)
                ->acceptJson()
                ->withHeaders([
                    'Authorization' => 'Bearer ' . config('app.ups_project_connector_api_key'),
                    'X-Platform-Secret' => config('app.ups_project_connector_api_secret'),
                    'X-User-ID' => auth()->id()
                ])
                ->get($url);

            if ($response->successful() && ($response->json()['success'] ?? false)) {
                $data = $response->json()['data'];
                $rental->update([
                    'admin_email' => $data['email'] ?? $rental->admin_email,
                    'admin_url' => $data['admin_url'] ?? $rental->admin_url,
                    'app_url' => $data['app_url'] ?? $rental->app_url
                ]);
                return response()->json(['success' => true, 'data' => $data]);
            }
            return response()->json(['success' => false, 'error' => 'Failed to fetch credentials'], 400);
        } catch (\Exception $e) {
            \Log::error("Failed to update credentials: " . $e->getMessage());
            return response()->json(['success' => false, 'error' => 'An error occurred'], 500);
        }
    }

    public function renew(Request $request, Rental $rental)
    {
        if ($rental->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'error' => 'Unauthorized'], 403);
        }

        \Log::info('Renewal request received', ['rental_id' => $rental->id]);

        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
            'duration_type' => 'required|in:daily,weekly,monthly,yearly'
        ]);

        try {
            DB::beginTransaction();

            $project = RentableProject::find($rental->rentable_project_id);
            if (!$project) {
                \Log::error('Project not found for renewal', ['rental_id' => $rental->id]);
                return response()->json(['success' => false, 'error' => 'Project no longer exists'], 404);
            }

            $priceMap = [
                'daily' => $project->pricing_24h,
                'weekly' => $project->pricing_7d,
                'monthly' => $project->pricing_30d,
                'yearly' => $project->pricing_365d
            ];

            $pricePerUnit = $priceMap[$validated['duration_type']];
            $totalCost = $pricePerUnit * $validated['quantity'];

            $wallet = auth()->user()->wallet;
            if ($wallet->credits_balance < $totalCost) {
                \Log::warning('Insufficient credits for renewal', ['needed' => $totalCost, 'balance' => $wallet->credits_balance]);
                return response()->json(['success' => false, 'error' => 'Insufficient credits'], 400);
            }

            $wallet->decrement('credits_balance', $totalCost);

            $isLocal = config('app.env') === 'local';
            $secondsMap = $isLocal 
                ? ['daily' => 120, 'weekly' => 300, 'monthly' => 600, 'yearly' => 900]
                : ['daily' => 86400, 'weekly' => 604800, 'monthly' => 2592000, 'yearly' => 31536000];
            $durationSeconds = $secondsMap[$validated['duration_type']] * $validated['quantity'];

            $newExpiry = now()->addSeconds($durationSeconds);
            
            if ($rental->status === 'expired') {
                $this->rentalService->restoreCredentialsOnProject($project, $rental->admin_id);
            }

            $renewalHistory = $rental->renewal_history ?? [];
            $renewalHistory[] = [
                'renewed_at' => now()->toIso8601String(),
                'quantity' => $validated['quantity'],
                'duration_type' => $validated['duration_type'],
                'cost' => $totalCost,
                'new_expiry' => $newExpiry->toIso8601String()
            ];

            $rental->update([
                'duration_value' => $validated['quantity'],
                'duration_type' => $validated['duration_type'],
                'rental_expires_at' => $newExpiry,
                'status' => 'active',
                'renewal_history' => $renewalHistory
            ]);

            \App\Models\Transaction::create([
                'transactable_type' => Rental::class,
                'transactable_id' => $rental->id,
                'amount' => $totalCost,
                'type' => 'rental',
                'description' => "Renewal: {$project->name} for {$validated['quantity']} {$validated['duration_type']}"
            ]);

            \App\Services\NotificationService::rentalRenewed(auth()->user(), $project->name, $totalCost, $validated['quantity'], $validated['duration_type'], $rental->id);
            \App\Services\NotificationService::adminRentalRenewed(auth()->user(), $project->name, $totalCost, $validated['quantity'], $validated['duration_type']);

            DB::commit();

            \Log::info('Renewal successful', ['rental_id' => $rental->id, 'new_expiry' => $newExpiry]);

            return response()->json([
                'success' => true,
                'message' => 'Rental renewed successfully',
                'new_expiry' => $newExpiry->toIso8601String()
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Rental renewal failed: ' . $e->getMessage());
            return response()->json(['success' => false, 'error' => 'Failed to renew rental: ' . $e->getMessage()], 500);
        }
    }
}
