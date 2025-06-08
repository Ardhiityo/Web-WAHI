<?php

namespace App\Services\Repositories;

use App\Models\Voucher;
use App\Services\Interfaces\VoucherInterface;

class VoucherRepository implements VoucherInterface
{
    public function getAllVouchers()
    {
        return Voucher::select('id', 'code', 'discount')->paginate(10);
    }

    public function createVoucher(array $data)
    {
        return Voucher::create($data);
    }
}
