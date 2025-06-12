<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'transaction_code',
        'total_discount',
        'transaction_type',
        'total_amount',
        'transaction_status',
        'user_id',
        'subtotal_amount',
        'total_discount',
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
            ->withPivot('quantity', 'total_price', 'purchase_price', 'total_discount', 'subtotal_price', 'unit_price')->withTimestamps();
    }
}
