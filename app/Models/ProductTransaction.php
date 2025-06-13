<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ProductTransaction extends Pivot
{
    protected $fillable = [
        'product_id',
        'transaction_id',
        'unit_purchase_price',
        'grandtotal_purchase_amount',
        'unit_selling_price',
        'subtotal_selling_amount',
        'total_discount',
        'grandtotal_selling_amount',
        'profit_amount',
        'quantity'
    ];

    protected $table = 'product_transactions';

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
