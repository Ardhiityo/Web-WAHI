<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\ProductTransaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Services\Interfaces\TransactionInterface;
use App\Http\Requests\Transaction\StoreTransactionRequest;
use App\Http\Requests\Transaction\UpdateTransactionRequest;

class TransactionController extends Controller
{
    public function __construct(private TransactionInterface $transactionRepository) {}

    public function index(Request $request)
    {
        $user = Auth::user();

        if ($request->query('category') && $request->query('keyword')) {
            $category = $request->query('category');
            $keyword = $request->query('keyword');
            if ($category == 'transaction_code') {
                if ($user->hasRole('customer')) {
                    $transactions = Transaction::where('transaction_code', $keyword)
                        ->where('user_id', $user->id)
                        ->latest()
                        ->paginate(perPage: 5);
                } else {
                    $transactions = Transaction::where('transaction_code', $keyword)
                        ->latest()->paginate(perPage: 5);
                }
            } else if ($category === 'customer') {
                if ($user->hasRole('customer')) {
                    return abort(403, 'Unauthorized action.');
                }
                $transactions = Transaction::whereHas('user', function ($query) use ($keyword) {
                    $query->where('name', 'like', '%' . $keyword . '%');
                })->latest()->paginate(perPage: 5);
            } else if ($category === 'transaction_type') {
                if ($user->hasRole('customer')) {
                    $transactions = Transaction::where('transaction_type', $keyword)
                        ->where('user_id', $user->id)
                        ->latest()->paginate(perPage: 5);
                } else {
                    $transactions = Transaction::where('transaction_type', $keyword)
                        ->latest()->paginate(perPage: 5);
                }
            } else if ($category == 'transaction_status') {
                if ($user->hasRole('customer')) {
                    $transactions = Transaction::where('transaction_status', $keyword)->where('user_id', $user->id)
                        ->latest()->paginate(perPage: 5);
                } else {
                    $transactions = Transaction::where('transaction_status', $keyword)
                        ->latest()->paginate(perPage: 5);
                }
            }
        } else {
            if ($user->hasRole('customer')) {
                $transactions = Transaction::where('user_id', $user->id)->latest()->paginate(perPage: 5);
            } else {
                $transactions = Transaction::latest()->paginate(perPage: 5);
            }
        }

        return view('pages.transaction.index', compact('transactions'));
    }

    public function store(StoreTransactionRequest $request)
    {
        try {
            $data = $request->validated();

            if ($transactionCode = Session::get('transaction_code')) {
                $transaction = $this->transactionRepository->getTransactionByCode($transactionCode);

                return redirect()->route('transactions.show', ['transaction' => $transaction->id]);
            }
            $transaction = $this->transactionRepository->createTransaction($data);

            return view('pages.checkout.detail', compact('transaction'));
        } catch (Exception $exception) {
            return redirect()->route('carts.index')->with('error', $exception->getMessage());
        }
    }

    public function show(Transaction $transaction)
    {
        Session::forget('transaction_code');

        return view('pages.transaction.show', compact('transaction'));
    }

    public function update(UpdateTransactionRequest $request, Transaction $transaction)
    {
        try {
            DB::beginTransaction();
            $data = $request->validated();
            $productTransactions = ProductTransaction::where('transaction_id', $transaction->id)->get();
            foreach ($productTransactions as $key => $productTransaction) {
                if ($productTransaction->quantity > $productTransaction->product->stock) {
                    throw new Exception('Produk yang dibeli melebihi stok produk');
                } else {
                    $productTransaction->product()->update([
                        'stock' => $productTransaction->product->stock - $productTransaction->quantity
                    ]);
                }
            }
            $transaction->update($data);
            DB::commit();
            return redirect()->route('transactions.show', ['transaction' => $transaction->id])
                ->withSuccess('Berhasil diubah');
        } catch (Exception $exception) {
            DB::rollBack();
            return redirect()->route('transactions.show', ['transaction' => $transaction->id])
                ->with('error', $exception->getMessage());
        }
    }

    public function destroy(Transaction $transaction)
    {
        $transaction->delete();

        return redirect()->route('transactions.index')->withSuccess('Berhasil dihapus');
    }
}
