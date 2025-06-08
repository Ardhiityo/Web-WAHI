<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Transaction;
use App\Services\Interfaces\TransactionInterface;
use App\Http\Requests\ProductTransacion\DeleteProductTransactionRequest;
use App\Http\Requests\ProductTransaction\UpdateProductTransactionRequest;
use App\Services\Interfaces\ProductTransactionInterface;

class ProductTransactionController extends Controller
{
    public function __construct(
        private TransactionInterface $transactionRepository,
        private ProductTransactionInterface $productTransactionRepository
    ) {}

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

    public function destroy(Transaction $transaction, DeleteProductTransactionRequest $request)
    {
        $data = $request->validated();

        $productId = $data['product_id'];
        $transactionId = $data['transaction_id'];

        $this->productTransactionRepository->deleteProductTransaction($productId, $transactionId);

        return redirect()->route('transactions.show', ['transaction' => $transactionId])
            ->withSuccess('Berhasil dihapus');
    }
}
