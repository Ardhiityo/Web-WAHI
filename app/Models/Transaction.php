<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'transaction_code',
        'grandtotal_purchase_amount',
        'total_discount',
        'subtotal_selling_amount',
        'grandtotal_selling_amount',
        'profit_amount',
        'transaction_status',
        'transaction_type',
        'user_id'
    ];

    protected $casts = [
        'created_at' => 'date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_transactions', 'transaction_id', 'product_id')
            ->withPivot('quantity', 'profit_amount', 'grandtotal_selling_amount', 'total_discount', 'subtotal_selling_amount', 'unit_selling_price', 'grandtotal_purchase_amount', 'unit_purchase_price')->withTimestamps();
    }
}
