<?php

namespace App\Models;

use Carbon\Carbon;
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


    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->format('d/m/Y');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_transactions', 'transaction_id', 'product_id')
            ->withPivot('quantity', 'price')->withTimestamps();
    }

    public function voucher()
    {
        return $this->belongsTo(Voucher::class);
    }
}
