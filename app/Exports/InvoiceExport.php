<?php

namespace App\Exports;

use App\Models\Transaction;
use Illuminate\Contracts\Database\Eloquent\Builder;
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
        $transaction = $this->transaction->load([
            'products' => fn(Builder $query) => $query->with('brand:id,name')->select('id', 'name', 'brand_id'),
            'user' => fn(Builder $query) => $query->select('id', 'name')
        ]);

        return view('exports.invoice.index', compact('transaction'));
    }
}
