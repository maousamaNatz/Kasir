<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Services\TransactionService;

class TransactionController extends Controller
{
    protected $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    public function index()
    {
        $transactions = Transaction::with('user', 'details.product')->get();
        return Inertia::render('Transactions/Index', ['transactions' => $transactions]);
    }

    public function create()
    {
        $products = \App\Models\Product::all();
        $users = \App\Models\User::all();
        return Inertia::render('Transactions/Create', [
            'products' => $products,
            'users' => $users,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'details' => 'required|array',
            'details.*.product_id' => 'required|exists:products,id',
            'details.*.jumlah' => 'required|integer|min:1',
        ]);

        $this->transactionService->createTransaction($validated);
        return redirect()->route('transactions.index')->with('message', 'Transaction created successfully');
    }
}