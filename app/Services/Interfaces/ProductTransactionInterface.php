<?php

namespace App\Services\Interfaces;

interface ProductTransactionInterface
{
    public function getProductTransactionsByTransactionId(int $transactionId);
    public function deleteProductTransaction($product_id, $transaction_id);
}
