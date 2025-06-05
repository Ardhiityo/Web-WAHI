<?php

namespace App\Http\Controllers;

use App\Http\Requests\Transaction\UpdateTransactionRequest;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\ProductTransaction;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        if ($request->query('category') && $request->query('keyword')) {
            $category = $request->query('category');
            $keyword = $request->query('keyword');
            if ($category == 'transaction_code') {
                $transactions = Transaction::where('transaction_code', $keyword)
                    ->latest()->paginate(perPage: 5);
            } else if ($category === 'customer') {
                $transactions = Transaction::whereHas('user', function ($query) use ($keyword) {
                    $query->where('name', 'like', '%' . $keyword . '%');
                })
                    ->latest()->paginate(perPage: 5);
            } else if ($category === 'cash' || $category === 'cashless') {
                $transactions = Transaction::where('transaction_type', $keyword)
                    ->latest()->paginate(perPage: 5);
            } else if ($category == 'transaction_status') {
                $transactions = Transaction::where('transaction_status', $keyword)
                    ->latest()->paginate(perPage: 5);
            }
        } else {
            $transactions = Transaction::latest()->paginate(perPage: 5);
        }

        return view('pages.transaction.index', compact('transactions'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Transaction $transaction)
    {
        return view('pages.transaction.show', compact('transaction'));
    }

    public function update(UpdateTransactionRequest $request, Transaction $transaction)
    {
        try {
            DB::beginTransaction();
            $productTransactions = ProductTransaction::where('transaction_id', $transaction->id)->get();
            foreach ($productTransactions as $key => $productTransaction) {
                $quantity = $productTransaction->quantity;
                $productTransaction->product->stock -= $quantity;
                $productTransaction->product->save();
            }
            $transaction->update($request->all());
            DB::commit();
            return redirect()->route('transactions.index')->withSuccess('Berhasil diubah');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('transactions.index')->with('error', 'Terjadi kesalahan');
        }
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();

        return redirect()->route('transactions.index')->withSuccess('Berhasil dihapus');
    }
}
