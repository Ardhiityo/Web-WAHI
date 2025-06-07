<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Services\Interfaces\BrandInterface;
use App\Services\Interfaces\ProductInterface;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(
        private ProductInterface $productRepository,
        private BrandInterface $brandRepository
    ) {}

    public function index(Request $request)
    {
        if ($request->query('category') && $request->query('keyword')) {
            $category = $request->query('category');
            $keyword = $request->query('keyword');
            if ($category === 'product') {
                $products = $this->productRepository->getProductByName($keyword);
            } elseif ($category === 'brand') {
                $products = $this->productRepository->getALlProductByBrand($keyword);
            }
        } else if ($request->query('start_price') && $request->query('end_price')) {
            $startPrice = $request->query('start_price');
            $endPrice = $request->query('end_price');
            $products = $this->productRepository->getAllProductsByPrice($startPrice, $endPrice);
        } else {
            $products = $this->productRepository->getAllProducts();
        }

        return view('pages.product.index', compact('products'));
    }

    public function create()
    {
        $brands = $this->brandRepository->getAllBrands();

        return view('pages.product.create', compact('brands'));
    }

    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();

        $this->productRepository->createProduct($data);

        return redirect()->route('products.index')->withSuccess('Berhasil ditambahkan');
    }

    public function edit(Product $product)
    {
        $brands = $this->brandRepository->getAllBrands();

        return view('pages.product.edit', compact('product', 'brands'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = $request->validated();

        $this->productRepository->updateProduct($product, $data);

        return redirect()->route('products.index')->withSuccess('Berhasil diubah');
    }

    public function destroy(Product $product)
    {
        $this->productRepository->deleteProduct($product);

        return redirect()->route('products.index')->withSuccess('Berhasil dihapus');
    }
}
