<?php

namespace App\Services\Interfaces;

use App\Models\Product;

interface ProductInterface
{
    public function getProducts();
    public function getProductsName();
    public function getProductsByPrice($startPrice, $endPrice);
    public function getProductsByBrand($brand);
    public function getProductsByName($name);
    public function createProduct(array $data);
    public function updateProduct(Product $product, array $data);
    public function deleteProduct(Product $product);
    public function getTotalProducts();
}
