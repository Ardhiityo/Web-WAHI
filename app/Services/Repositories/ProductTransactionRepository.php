<?php

namespace App\Services\Repositories;

use App\Models\ProductTransaction;
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

    public function deleteProductTransaction($product_id, $transaction_id)
    {
        return ProductTransaction::where('product_id', $product_id)
            ->where('transaction_id', $transaction_id)->delete();
    }
}
