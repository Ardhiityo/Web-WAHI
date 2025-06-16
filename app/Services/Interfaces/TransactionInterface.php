<?php

namespace App\Services\Interfaces;

use App\Models\Transaction;

interface TransactionInterface
{
    public function createTransaction(array $data): Transaction;
    public function getTransactionByCode(string $code);
    public function getTransactionDates();
    public function getTransactionPaidDates();
    public function getTransactionProfitByDateRange(string $startDate, string $endDate);
    public function getTotalTransactionProfit();
    public function getTotalTransactionsByUser($status): int;
    public function getTotalTransactionsByStatus($status): int;
    public function updateTransactionStatus(int $id, array $data);
    public function updateTransaction(array $data);
    public function getTransactionById(int $id);
    public function getTransactionsByCode($keyword);
    public function getTransactionsByName($keyword);
    public function getTransactionsByType($keyword);
    public function getTransactionsByStatus($keyword);
    public function getAllTransactions();
}
