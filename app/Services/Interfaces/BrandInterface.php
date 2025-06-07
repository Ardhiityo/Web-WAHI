<?php

namespace App\Services\Interfaces;

interface BrandInterface
{
    public function getAllBrands();
    public function createBrand(array $data);
}
