<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Services\MidtransService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Services\Interfaces\TransactionInterface;
use App\Services\Interfaces\ProductTransactionInterface;
use App\Http\Requests\Transaction\StoreTransactionRequest;
use App\Http\Requests\Transaction\UpdateTransactionRequest;

class TransactionController extends Controller
{
    public function __construct(
        private TransactionInterface $transactionRepository,
        private ProductTransactionInterface $productTransactionRepository,
        private MidtransService $midtransService
    ) {}

    public function index(Request $request)
    {
        $user = Auth::user();

        if ($request->query('category') && $request->query('keyword')) {
            $category = $request->query('category');
            $keyword = $request->query('keyword');
            if ($category == 'transaction_code') {
                $transactions = $this->transactionRepository->getTransactionsByCode($keyword);
            } else if ($category === 'customer') {
                if ($user->hasRole('customer')) {
                    return abort(403, 'Unauthorized action.');
                }
                $transactions = $this->transactionRepository->getTransactionsByName($keyword);
            } else if ($category === 'transaction_type') {
                $transactions = $this->transactionRepository->getTransactionsByType($keyword);
            } else if ($category == 'transaction_status') {
                $transactions = $this->transactionRepository->getTransactionsByStatus($keyword);
            }
        } else {
            $transactions = $this->transactionRepository->getAllTransactions();
        }

        return view('pages.transaction.index', compact('transactions'));
    }

    public function store(StoreTransactionRequest $request)
    {
        try {
            $data = $request->validated();

            if ($transactionCode = Session::get('transaction_code')) {
                $transaction = $this->transactionRepository->getTransactionByCode($transactionCode);

                if ($transaction) {
                    return redirect()->route('transactions.show', ['transaction' => $transaction->id]);
                }
                Session::forget('transaction_code');
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

        Log::info('Masuk');

        $isPaid = false;

        if ($transaction->transaction_type === 'cashless' && $transaction->transaction_status === 'pending') {
            $checkStatus = $this->midtransService->checkStatus($transaction->transaction_code);
            if ($checkStatus) {
                $this->midtransService->isPaid($checkStatus) ? $isPaid = true : $isPaid = false;
                $transaction->refresh();
            }
        }

        if ($transaction->user_id === Auth::user()->id) {
            if (Auth::user()->hasRole('customer')) {
                return view('pages.transaction.show', compact('transaction', 'isPaid'));
            } else {
                return abort(403, 'Unauthorized action.');
            }
        }

        return view('pages.transaction.show', compact('transaction'));
    }

    public function update(UpdateTransactionRequest $request, Transaction $transaction)
    {
        try {
            $data = $request->validated();

            $this->transactionRepository->updateTransactionStatus($transaction->id, $data);

            return redirect()->route('transactions.show', ['transaction' => $transaction->id])
                ->withSuccess('Berhasil diubah');
        } catch (Exception $exception) {
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
