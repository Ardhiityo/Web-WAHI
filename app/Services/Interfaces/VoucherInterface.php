<?php

namespace App\Services\Interfaces;

interface VoucherInterface
{
    public function getAllVouchers();
    public function createVoucher(array $data);
}
