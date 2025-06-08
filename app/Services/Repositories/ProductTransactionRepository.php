<?php

namespace App\Services\Repositories;

use App\Models\ProductTransaction;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Services\Interfaces\ProductTransactionInterface;

class ProductTransactionRepository implements ProductTransactionInterface
{
    public function getProductTransactionsByTransactionId(int $transactionId)
    {
        return ProductTransaction::with('product:id,stock')
            ->select('product_id', 'transaction_id', 'quantity')
            ->where('transaction_id', $transactionId)
            ->get();
    }

    public function updateProductTransaction(int $id, array $data)
    {
        try {
            DB::beginTransaction();

            $productTransactions = $this->getProductTransactionsByTransactionId($id);

            foreach ($productTransactions as $productTransaction) {
                $productTransaction->product()->update([
                    'stock' => $productTransaction->product->stock - $productTransaction->quantity
                ]);
            }

            $productTransaction->transaction()->update($data);

            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();

            throw new Exception($exception->getMessage());
        }
    }
}
