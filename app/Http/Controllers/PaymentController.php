<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Wallet;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function verifyPayment(Request $request)
    {
        try {
            $request->validate([
                'transaction_id' => 'required',
                'credits' => 'required|integer|min:1',
                'base_credits' => 'nullable|integer|min:1',
                'currency' => 'required|string',
                'price' => 'required|numeric|min:0'
            ]);

            $transactionId = (string) $request->transaction_id;
            $credits = $request->credits;
            $baseCredits = $request->base_credits ?? $credits;
            $currency = $request->currency;
            $price = (float) $request->price;
            $user = auth()->user();

            // Get the correct secret key based on environment
            $secretKey = config('payment.flutterwave.secret_key') ?? config('services.flutterwave.secret_key');
            
            if (!$secretKey) {
                Log::error('Flutterwave secret key not configured');
                return response()->json(['success' => false, 'message' => 'Payment gateway not configured'], 500);
            }

            Log::info('Verifying payment', ['transaction_id' => $transactionId, 'credits' => $credits]);

            // Verify payment with Flutterwave
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $secretKey,
                'Content-Type' => 'application/json'
            ])->get("https://api.flutterwave.com/v3/transactions/{$transactionId}/verify");

            Log::info('Flutterwave verification response', [
                'status' => $response->status(),
                'body' => $response->json()
            ]);

            if (!$response->successful()) {
                Log::error('Payment verification failed', ['status' => $response->status()]);
                return response()->json(['success' => false, 'message' => 'Payment verification failed: ' . $response->status()], 400);
            }

            $data = $response->json();

            // Check multiple possible success conditions
            $isSuccess = (
                ($data['status'] === 'success' && isset($data['data']['status']) && $data['data']['status'] === 'successful') ||
                ($data['status'] === 'success' && isset($data['data']['status']) && $data['data']['status'] === 'success')
            );

            if (!$isSuccess) {
                Log::error('Payment not successful', ['api_status' => $data['status'] ?? 'unknown', 'payment_status' => $data['data']['status'] ?? 'unknown']);
                return response()->json(['success' => false, 'message' => 'Payment not successful'], 400);
            }

            // Check if transaction already processed
            $existingTransaction = Transaction::where('description', 'LIKE', "%{$transactionId}%")->first();
            if ($existingTransaction) {
                Log::warning('Transaction already processed', ['transaction_id' => $transactionId]);
                return response()->json(['success' => false, 'message' => 'Transaction already processed'], 400);
            }

            // Add credits to wallet (total including bonus)
            $wallet = $user->wallet;
            if (!$wallet) {
                Log::error('Wallet not found for user', ['user_id' => $user->id]);
                return response()->json(['success' => false, 'message' => 'Wallet not found'], 500);
            }
            
            $wallet->increment('credits_balance', $credits);

            // Create transaction record (store total credits including bonus)
            Transaction::create([
                'transactable_type' => get_class($user),
                'transactable_id' => $user->id,
                'amount' => $credits,
                'type' => 'purchase',
                'currency' => $currency,
                'price' => $price,
                'description' => "Credit purchase: {$credits} credits (Flutterwave: {$transactionId})"
            ]);

            Log::info('Payment verified and credits added', ['user_id' => $user->id, 'total_credits' => $credits, 'base_credits' => $baseCredits]);

            // Create notification with base and total credits
            NotificationService::paymentSuccess($user, $baseCredits, $price, $currency, $credits);

            return response()->json([
                'success' => true,
                'message' => 'Credits added successfully',
                'new_balance' => $wallet->fresh()->credits_balance,
                'total_credits_added' => $credits,
                'base_credits' => $baseCredits
            ]);
        } catch (\Exception $e) {
            Log::error('Payment verification exception', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json(['success' => false, 'message' => 'An error occurred'], 500);
        }
    }
}
