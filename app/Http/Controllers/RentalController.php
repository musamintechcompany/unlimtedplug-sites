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
        // Ensure user can only view their own rentals
        if ($rental->user_id !== auth()->id()) {
            abort(403);
        }
        
        $rental->load('rentableProject');
        return view('rentals.show', compact('rental'));
    }

    public function store(Request $request)
    {
        if (!auth()->check()) {
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
                \Log::warning('Rental creation returned null', [
                    'user_id' => auth()->id(),
                    'project_id' => $validated['project_id'],
                    'duration_type' => $validated['duration_type'],
                    'duration_value' => $validated['duration_value']
                ]);
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
            return response()->json([
                'success' => false,
                'error' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Rental creation failed: ' . $e->getMessage(), [
                'user_id' => auth()->id(),
                'request' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'error' => 'An error occurred while creating the rental. Please try again.'
            ], 500);
        }
    }

    public function renew(Request $request, Rental $rental)
    {
        if ($rental->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'error' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
            'duration_type' => 'required|in:days,weeks,months,years'
        ]);

        try {
            DB::beginTransaction();

            $project = RentableProject::find($rental->rentable_project_id);
            if (!$project) {
                return response()->json(['success' => false, 'error' => 'Project no longer exists'], 404);
            }

            // Calculate cost based on duration type
            $priceMap = [
                'days' => $project->pricing_24h,
                'weeks' => $project->pricing_7d,
                'months' => $project->pricing_30d,
                'years' => $project->pricing_365d
            ];

            $pricePerUnit = $priceMap[$validated['duration_type']];
            $totalCost = $pricePerUnit * $validated['quantity'];

            // Check user balance
            $wallet = auth()->user()->wallet;
            if ($wallet->balance < $totalCost) {
                return response()->json(['success' => false, 'error' => 'Insufficient credits'], 400);
            }

            // Deduct credits
            $wallet->decrement('balance', $totalCost);

            // Calculate days to add
            $daysMap = ['days' => 1, 'weeks' => 7, 'months' => 30, 'years' => 365];
            $daysToAdd = $daysMap[$validated['duration_type']] * $validated['quantity'];

            // Extend rental
            $newExpiry = $rental->rental_expires_at->addDays($daysToAdd);
            $rental->update([
                'rental_expires_at' => $newExpiry,
                'status' => 'active',
                'duration_days' => $rental->duration_days + $daysToAdd
            ]);

            // Create transaction record
            \App\Models\Transaction::create([
                'user_id' => auth()->id(),
                'type' => 'debit',
                'amount' => $totalCost,
                'description' => "Rental renewal: {$project->name} (+{$validated['quantity']} {$validated['duration_type']})",
                'status' => 'completed'
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Rental renewed successfully',
                'new_expiry' => $newExpiry->format('M d, Y')
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Rental renewal failed: ' . $e->getMessage());
            return response()->json(['success' => false, 'error' => 'Failed to renew rental'], 500);
        }
    }
}
