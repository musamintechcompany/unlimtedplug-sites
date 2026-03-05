<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class CreditController extends Controller
{
    public function index()
    {
        $currency = session('currency', 'USD');
        $currencyData = config('payment.currencies')[$currency];
        $pricePerTen = $currencyData['price_per_10'];
        
        $packages = [];
        foreach (config('payment.packages') as $credits => $data) {
            $packages[] = [
                'credits' => $credits,
                'price' => ($credits / 10) * $pricePerTen,
                'bonus' => $data['bonus'],
                'savings' => $data['savings'],
            ];
        }
        
        return view('credits.index', compact('packages', 'currency', 'currencyData'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'package' => 'required|in:100,500,1000,5000',
            'quantity' => 'required|integer|min:1',
        ]);

        $packages = [
            100 => ['credits' => 100, 'price' => 9.99, 'bonus' => 0],
            500 => ['credits' => 550, 'price' => 39.99, 'bonus' => 50],
            1000 => ['credits' => 1150, 'price' => 69.99, 'bonus' => 150],
            5000 => ['credits' => 6000, 'price' => 299.99, 'bonus' => 1000],
        ];

        $basePackage = $packages[$request->package];
        $quantity = $request->quantity;
        $totalCredits = $basePackage['credits'] * $quantity;
        $totalPrice = $basePackage['price'] * $quantity;
        
        // Add credits to wallet
        auth()->user()->wallet->increment('credits_balance', $totalCredits);

        // Record transaction
        Transaction::create([
            'user_id' => auth()->id(),
            'amount' => $totalCredits,
            'type' => 'purchase',
            'description' => "Purchased {$quantity}x {$basePackage['credits']} credits for \${$totalPrice}",
        ]);

        return redirect()->route('dashboard')->with('success', "Successfully added {$totalCredits} credits to your account!");
    }
}
