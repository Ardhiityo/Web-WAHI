<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $fillable = [
        'code',
    ];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
