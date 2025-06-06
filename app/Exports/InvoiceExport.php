<?php

namespace App\Exports;

use App\Models\Transaction;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class InvoiceExport implements FromView
{
    public function __construct(private Transaction $transaction) {}

    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        $transaction = $this->transaction;

        return view('exports.invoice.index', compact('transaction'));
    }
}
