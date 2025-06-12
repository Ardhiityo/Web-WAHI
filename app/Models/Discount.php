<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $fillable = [
        'code',
        'product_id',
        'untill_date',
        'discount',
    ];

    public function products()
    {
        return $this->belongsTo(Product::class);
    }
}
