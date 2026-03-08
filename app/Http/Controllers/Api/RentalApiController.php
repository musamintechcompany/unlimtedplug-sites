<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ApiKey;
use App\Models\RentableProject;
use App\Models\Rental;
use App\Services\RentalService;
use Illuminate\Http\Request;

class RentalApiController extends Controller
{
    protected $rentalService;

    public function __construct(RentalService $rentalService)
    {
        $this->rentalService = $rentalService;
    }

    public function show(Rental $rental)
    {
        if ($rental->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $project = $rental->rentableProject;
        $pricing = [
            'daily' => $project->pricing_24h,
            'weekly' => $project->pricing_7d,
            'monthly' => $project->pricing_30d,
            'yearly' => $project->pricing_365d
        ];

        return response()->json([
            'success' => true,
            'duration_type' => $rental->duration_type,
            'pricing' => $pricing,
            'user_balance' => auth()->user()->wallet->credits_balance ?? 0
        ]);
    }

    public function create(Request $request)
    {
        // Validate API key
        $apiKey = ApiKey::where('key', $request->header('X-API-Key'))
            ->where('status', 'active')
            ->first();

        if (!$apiKey) {
            return response()->json(['success' => false, 'message' => 'Invalid API key'], 401);
        }

        $request->validate([
            'project_slug' => 'required|string',
            'duration_days' => 'required|integer|min:1|max:365',
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email'
        ]);

        // Find project
        $project = RentableProject::where('slug', $request->project_slug)->first();
        if (!$project) {
            return response()->json(['success' => false, 'message' => 'Project not found'], 404);
        }

        // Get reseller's wallet
        $reseller = $apiKey->user;
        $creditsCost = $project->price_per_day * $request->duration_days;

        if (!$reseller->wallet || $reseller->wallet->credits_balance < $creditsCost) {
            return response()->json(['success' => false, 'message' => 'Insufficient credits'], 402);
        }

        // Create rental for customer (use customer email as identifier)
        $rental = $this->rentalService->createRental(
            $reseller,
            $project,
            $request->duration_days
        );

        if (!$rental) {
            return response()->json(['success' => false, 'message' => 'Rental creation failed'], 500);
        }

        // Update admin email to customer email
        $rental->update(['admin_email' => $request->customer_email]);

        // Increment API key usage
        $apiKey->incrementUsage();

        return response()->json([
            'success' => true,
            'data' => [
                'rental_id' => $rental->id,
                'admin_id' => $rental->admin_id,
                'admin_email' => $rental->admin_email,
                'admin_password' => $rental->admin_password,
                'admin_url' => $project->api_url . '/admin/login',
                'expires_at' => $rental->rental_expires_at
            ]
        ], 201);
    }

    public function updateAdminUrl(Request $request)
    {
        $request->validate([
            'rental_id' => 'required|string',
            'admin_id' => 'required|string',
            'admin_url' => 'required|url'
        ]);

        $rental = Rental::where('id', $request->rental_id)
            ->orWhere('admin_id', $request->admin_id)
            ->first();

        if (!$rental) {
            return response()->json(['success' => false, 'message' => 'Rental not found'], 404);
        }

        $rental->update(['admin_url' => $request->admin_url]);

        return response()->json([
            'success' => true,
            'message' => 'Admin URL updated successfully',
            'data' => ['rental_id' => $rental->id, 'admin_url' => $rental->admin_url]
        ]);
    }
}
