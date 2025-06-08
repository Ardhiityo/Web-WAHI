<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\ProductTransaction;
use App\Http\Requests\ProductTransaction\UpdateProductTransactionRequest;
use App\Services\Interfaces\TransactionInterface;

class ProductTransactionController extends Controller
{
    public function __construct(private TransactionInterface $transactionRepository) {}

    public function update(UpdateProductTransactionRequest $request)
    {
        $data = $request->validated();

        try {
            $this->transactionRepository->updateTransaction($data);

            return redirect()->route('transactions.show', ['transaction' => $data['transaction_id']])
                ->withSuccess('Berhasil diubah');
        } catch (Exception $exception) {
            return redirect()->route('transactions.show', ['transaction' => $data['transaction_id']])
                ->with('error', $exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction, Request $request)
    {
        ProductTransaction::where('product_id', $request->product_id)
            ->where('transaction_id', $request->transaction_id)->delete();
        return redirect()->route('transactions.show', ['transaction' => $request->transaction_id])->withSuccess('Berhasil dihapus');
    }
}
