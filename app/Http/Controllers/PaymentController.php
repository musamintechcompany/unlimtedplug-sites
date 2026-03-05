<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function verifyPayment(Request $request)
    {
        $request->validate([
            'transaction_id' => 'required|string',
            'credits' => 'required|integer|min:1'
        ]);

        $transactionId = $request->transaction_id;
        $credits = $request->credits;
        $user = auth()->user();

        // Verify payment with Flutterwave
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . config('services.flutterwave.secret_key'),
            'Content-Type' => 'application/json'
        ])->get("https://api.flutterwave.com/v3/transactions/{$transactionId}/verify");

        if (!$response->successful()) {
            return response()->json(['success' => false, 'message' => 'Payment verification failed'], 400);
        }

        $data = $response->json();

        if ($data['status'] !== 'success' || $data['data']['status'] !== 'successful') {
            return response()->json(['success' => false, 'message' => 'Payment not successful'], 400);
        }

        // Check if transaction already processed
        $existingTransaction = Transaction::where('description', 'LIKE', "%{$transactionId}%")->first();
        if ($existingTransaction) {
            return response()->json(['success' => false, 'message' => 'Transaction already processed'], 400);
        }

        // Add credits to wallet
        $wallet = $user->wallet;
        $wallet->increment('credits_balance', $credits);

        // Create transaction record
        Transaction::create([
            'id' => Str::uuid(),
            'user_id' => $user->id,
            'amount' => $credits,
            'type' => 'purchase',
            'description' => "Credit purchase: {$credits} credits (Flutterwave: {$transactionId})"
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Credits added successfully',
            'new_balance' => $wallet->fresh()->credits_balance
        ]);
    }
}
