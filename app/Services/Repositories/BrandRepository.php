<?php

namespace App\Services\Repositories;

use App\Models\Brand;
use App\Services\Interfaces\BrandInterface;

class BrandRepository implements BrandInterface
{
    public function getAllBrands()
    {
        return Brand::select('id', 'name')->paginate(10);
    }

    public function createBrand(array $data)
    {
        return Brand::create($data);
    }

    public function getTotalBrands()
    {
        return Brand::count();
    }
}
