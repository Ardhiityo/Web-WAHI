<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Models\Cart;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::paginate(perPage: 10);

        return view('pages.product.index', compact('products'));
    }

    public function create()
    {
        $brands = Brand::all();

        return view('pages.product.create', compact('brands'));
    }

    public function store(StoreProductRequest $request)
    {
        $data = $request->validated();

        $data['image'] = $request->file('image')->store('products', 'public');

        Product::create($data);

        return redirect()->route('products.index')->withSuccess('Berhasil ditambahkan');
    }

    public function edit(Product $product)
    {
        $brands = Brand::all();

        return view('pages.product.edit', compact('product', 'brands'));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($product->image);
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('products.index')->withSuccess('Berhasil diubah');
    }

    public function destroy(Product $product)
    {
        Storage::disk('public')->delete($product->image);

        $product->delete();

        return redirect()->route('products.index')->withSuccess('Berhasil dihapus');
    }
}
