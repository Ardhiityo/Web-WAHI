<?php

namespace App\Exports;

use App\Models\Transaction;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class TransactionExport implements FromView
{
    public function __construct(private $start_date, private $end_date) {}

    public function view(): View
    {
        $start_date = $this->start_date;
        $end_date = $this->end_date;

        $transactions = Transaction::whereDate('created_at', '>=', $start_date)
            ->whereDate('created_at', '<=', $end_date)
            ->get();

        $totalTransactionSuccess = $transactions->toQuery()
            ->where('transaction_status', 'paid')
            ->count();

        $totalTransactionPending = $transactions->toQuery()
            ->where('transaction_status', 'pending')
            ->count();

        $profit = 0;

        foreach ($transactions as $transaction) {
            if ($transaction->transaction_status === 'paid') {
                $profit += $transaction->total_amount;
            }
        }

        return view('exports.report.index', compact('transactions', 'start_date', 'end_date', 'totalTransactionSuccess', 'totalTransactionPending', 'profit'));
    }
}
