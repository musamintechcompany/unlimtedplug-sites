<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\CrossPlatformAuthController;
use App\Http\Controllers\Api\RentalApiController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Cross-Platform Auth API (for Marketplace users accessing Sites)
Route::post('/check-user', [CrossPlatformAuthController::class, 'checkUser']);
Route::post('/verify-password', [CrossPlatformAuthController::class, 'verifyPassword']);
Route::post('/create-account-from-marketplace', [CrossPlatformAuthController::class, 'createAccountFromMarketplace']);
Route::post('/generate-login-token', [CrossPlatformAuthController::class, 'generateLoginToken']);
Route::post('/login', [CrossPlatformAuthController::class, 'login']);

// Reseller Rental API
Route::post('/rental/create', [RentalApiController::class, 'create']);

/**
 * Get authenticated user's wallet balance
 * Returns current credit balance from database
 * Used by renewal modal for real-time balance checking
 */
Route::get('/user/balance', function () {
    if (!auth()->check()) {
        return response()->json(['balance' => 0]);
    }
    return response()->json(['balance' => auth()->user()->wallet->credits_balance ?? 0]);
});

/**
 * Check if a project exists and get its current pricing
 * Used by renewal modal to verify project availability before renewal
 */
Route::get('/projects/{id}/check', function ($id) {
    $project = \App\Models\RentableProject::find($id);
    
    if (!$project) {
        return response()->json(['exists' => false]);
    }
    
    return response()->json([
        'exists' => true,
        'pricing' => [
            'pricing_24h' => $project->pricing_24h,
            'pricing_7d' => $project->pricing_7d,
            'pricing_30d' => $project->pricing_30d,
            'pricing_365d' => $project->pricing_365d
        ]
    ]);
});
