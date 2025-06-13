<?php

namespace App\Services\Interfaces;

interface DiscountInterface
{
    public function getDiscounts();
    public function createDiscount(array $data);
    public function getTotalDiscount();
}
