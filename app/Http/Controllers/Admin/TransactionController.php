<?php

namespace App\Http\Controllers\Admin;

use App\Models\Transaction;
use Illuminate\Routing\Controller;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with('transactable')
            ->latest()
            ->paginate(15);
        return view('admin.transactions.index', compact('transactions'));
    }

    public function show(Transaction $transaction)
    {
        $transaction->load('transactable');
        return view('admin.transactions.show', compact('transaction'));
    }
}
