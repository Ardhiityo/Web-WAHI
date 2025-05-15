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
    ];

    public function getPriceAttribute($value)
    {
        return Number::format($value, locale: 'id-ID');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
