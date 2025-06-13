<?php

namespace App\Services\Repositories;

use App\Models\Discount;
use App\Services\Interfaces\DiscountInterface;

class DiscountRepository implements DiscountInterface
{
    public function getDiscounts()
    {
        return Discount::with('product:id,name,image')->select('id', 'untill_date', 'discount', 'product_id')->paginate(10);
    }

    public function createDiscount(array $data)
    {
        return Discount::create($data);
    }

    public function getTotalDiscount()
    {
        return Discount::count();
    }
}
