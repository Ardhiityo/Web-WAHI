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
            ->withPivot('quantity', 'profit_amount', 'grandtotal_selling_amount', 'total_discount', 'subtotal_selling_amount', 'unit_selling_price', 'grandtotal_purchase_amount', 'unit_purchase_price')
            ->withTimestamps();
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function discount()
    {
        return $this->hasOne(Discount::class);
    }
}
