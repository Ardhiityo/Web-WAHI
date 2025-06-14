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

        $totalTransactionCancel = $transactions->toQuery()
            ->where('transaction_status', 'cancel')
            ->count();

        $profitRealization = 0;
        $profitUnrealization = 0;
        $profitUnrealizationCancel = 0;

        foreach ($transactions as $transaction) {
            if ($transaction->transaction_status === 'paid') {
                $profitRealization += $transaction->profit_amount;
            } else if ($transaction->transaction_status === 'pending') {
                $profitUnrealization += $transaction->profit_amount;
            } else if ($transaction->transaction_status === 'cancel') {
                $profitUnrealizationCancel += $transaction->profit_amount;
            }
        }

        return view(
            'exports.report.index',
            compact(
                'transactions',
                'start_date',
                'end_date',
                'totalTransactionSuccess',
                'totalTransactionPending',
                'totalTransactionCancel',
                'profitRealization',
                'profitUnrealization',
                'profitUnrealizationCancel'
            )
        );
    }
}
