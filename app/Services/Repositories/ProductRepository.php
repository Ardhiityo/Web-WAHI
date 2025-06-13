<?php

namespace App\Services\Repositories;

use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use App\Services\Interfaces\ProductInterface;

class ProductRepository implements ProductInterface
{
    public function getProducts()
    {
        return Product::with('brand:id,name')
            ->select('id', 'image', 'name', 'purchase_price', 'price', 'stock', 'brand_id')
            ->paginate(10);
    }

    public function getProductsName()
    {
        return Product::select('id', 'name')->get();
    }

    public function getProductsByPrice($startPrice, $endPrice)
    {
        return Product::with('brand:id,name')
            ->select('id', 'image', 'name', 'price', 'purchase_price', 'stock', 'brand_id')
            ->whereBetween('price', [$startPrice, $endPrice])
            ->paginate(10);
    }

    public function getProductsByBrand($brand)
    {
        return Product::with('brand:id,name')
            ->select('id', 'image', 'name', 'price', 'purchase_price', 'stock', 'brand_id')
            ->whereHas('brand', function ($query) use ($brand) {
                $query->whereLike('name', '%' . $brand . '%');
            })
            ->paginate(10);
    }

    public function getProductsByName($name)
    {
        return Product::with('brand:id,name')
            ->select('id', 'image', 'name', 'price', 'purchase_price', 'stock', 'brand_id')
            ->whereLike('name', '%' . $name . '%')
            ->paginate(10);
    }

    public function createProduct(array $data)
    {
        $data['image'] = $data['image']->store('products', 'public');

        return Product::create($data);
    }

    public function updateProduct(Product $product, array $data)
    {
        if (isset($data['image'])) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $data['image']->store('products', 'public');
        } else {
            $data['image'] = $product->image;
        }

        return $product->update($data);
    }

    public function deleteProduct(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        return $product->delete();
    }

    public function getTotalProducts()
    {
        return Product::count();
    }
}
