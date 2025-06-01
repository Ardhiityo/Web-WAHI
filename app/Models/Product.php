<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Number;

class Product extends Model
{
    protected $fillable = [
        'name',
        'price',
        'stock',
        'brand_id',
        'image'
    ];

    public function getPriceAttribute($value)
    {
        return Number::format($value, locale: 'id-ID');
    }

    public function transactions()
    {
        return $this->belongsToMany(Transaction::class, 'product_transactions', 'product_id', 'transaction_id')
            ->withPivot('qty', 'total_amount')->withTimestamps();
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }
}
