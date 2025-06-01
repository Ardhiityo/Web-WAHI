<?php

namespace App\Models;

use Illuminate\Support\Number;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'product_id',
        'user_id',
        'qty',
        'total_amount',
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
