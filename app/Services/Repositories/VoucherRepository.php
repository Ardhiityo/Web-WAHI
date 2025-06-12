<?php

namespace App\Services\Repositories;

use App\Models\Discount;
use App\Services\Interfaces\VoucherInterface;

class VoucherRepository implements VoucherInterface
{
    public function getAllVouchers()
    {
        return Discount::with('product:id,name')->select('id', 'untill_date', 'discount', 'product_id')->paginate(10);
    }

    public function createVoucher(array $data)
    {
        return Discount::create($data);
    }

    public function getTotalVouchers()
    {
        return Discount::count();
    }
}
