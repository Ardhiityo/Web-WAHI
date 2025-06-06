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
        $transactions = Transaction::where('transaction_status', 'paid')
            ->whereDate('created_at', '>=', $this->start_date)
            ->whereDate('created_at', '<=', $this->end_date)
            ->get();

        return view('export.index', compact('dates'));
    }
}
