<?php

namespace App\Services\Interfaces;

use App\Models\Transaction;

interface TransactionInterface
{
    public function createTransaction(array $data): Transaction;
    public function getTransactionByCode(string $code);
}
