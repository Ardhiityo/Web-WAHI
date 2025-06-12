<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ProductTransaction extends Pivot
{
    protected $fillable = [
        'product_id',
        'transaction_id',
        'quantity',
        'purchase_price',
        'price',
        'discount'
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
