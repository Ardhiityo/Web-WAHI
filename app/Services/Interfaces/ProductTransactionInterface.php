<?php

namespace App\Services\Interfaces;

interface ProductTransactionInterface
{
    public function getProductTransactionsByTransactionId(int $transactionId);
    public function updateProductTransaction(int $id, array $data);
}
