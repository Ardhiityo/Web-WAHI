<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::paginate(perPage: 5);

        return view('pages.transaction.index', compact('transactions'));
    }

    public function create()
    {
        $cashiers = User::role('cashier')->get();
        $products = Product::all();

        return view('pages.transaction.create', compact('cashiers', 'products'));
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'product_id' => 'required|exists:products,id',
            'user_id' => 'required|exists:users,id',
            'qty' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($validatedData['product_id']);

        Transaction::create([
            'product_id' => $request->product_id,
            'user_id' => $request->user_id,
            'qty' => $request->qty,
            'total_amount' => $product->price * $request->qty,
        ]);

        return redirect()->route('transactions.index');
    }

    public function show($id)
    {
        //
    }
    public function edit(Transaction $transaction)
    {
        $cashiers = User::role('cashier')->get();
        $products = Product::all();

        return view('pages.transaction.edit', compact('transaction', 'cashiers', 'products'));
    }
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'product_id' => 'required|exists:products,id',
            'user_id' => 'required|exists:users,id',
            'qty' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($validatedData['product_id']);

        $transaction = Transaction::findOrFail($id);

        $transaction->update([
            'product_id' => $request->product_id,
            'user_id' => $request->user_id,
            'qty' => $request->qty,
            'total_amount' => $product->price * $request->qty,
        ]);

        return redirect()->route('transactions.index');
    }
    public function destroy(Transaction $transaction)
    {
        $transaction->delete();

        return redirect()->route('transactions.index');
    }
}
