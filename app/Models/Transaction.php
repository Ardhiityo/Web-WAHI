<?php

namespace App\Models;

use Illuminate\Support\Number;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'discount_percentage',
        'transaction_code',
        'voucher_id',
        'transaction_type',
        'total_amount',
        'transaction_status',
        'user_id',
        'subtotal_amount',
        'discount',
    ];

    public static function getTotalAmount($value)
    {
        return Number::format($value, locale: 'id-ID');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'transaction_products', 'transaction_id', 'product_id')
            ->withPivot('qty', 'total_amount')->withTimestamps();
    }

    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }
}
