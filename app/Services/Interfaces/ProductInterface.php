<?php

namespace App\Services\Interfaces;

use App\Models\Product;

interface ProductInterface
{
    public function getAllProducts();
    public function getAllProductsByPrice($startPrice, $endPrice);
    public function getALlProductByBrand($brand);
    public function getProductByName($name);
    public function createProduct(array $data);
    public function updateProduct(Product $product, array $data);
    public function deleteProduct(Product $product);
}
