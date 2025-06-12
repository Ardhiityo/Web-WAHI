<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'purchase_price',
        'price',
        'stock',
        'brand_id',
        'image'
    ];

    public function transactions()
    {
        return $this->belongsToMany(Transaction::class, 'product_transactions', 'product_id', 'transaction_id')
            ->withPivot('quantity', 'total_amount', 'purchase_price')->withTimestamps();
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function discounts()
    {
        return $this->hasMany(Discount::class);
    }
}
