<?php

namespace App\Services\Repositories;

use App\Models\Discount;
use App\Services\Interfaces\VoucherInterface;

class VoucherRepository implements VoucherInterface
{
    public function getAllVouchers()
    {
        return Discount::select('id', 'code', 'discount')->paginate(10);
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
