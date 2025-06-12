<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $fillable = [
        'product_id',
        'untill_date',
        'discount',
    ];

    protected $casts = [
        'untill_date' => 'date'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
