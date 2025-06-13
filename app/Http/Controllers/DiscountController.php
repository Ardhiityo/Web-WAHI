<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Voucher\StoreVoucherRequest;
use App\Http\Requests\Voucher\UpdateVoucherRequest;
use App\Models\Discount;
use App\Models\Product;
use App\Services\Interfaces\DiscountInterface;
use App\Services\Interfaces\ProductInterface;

class DiscountController extends Controller
{
    public function __construct(
        private DiscountInterface $discountRepository,
        private ProductInterface $productRepository
    ) {}

    public function index()
    {
        $discounts = $this->discountRepository->getDiscounts();

        return view('pages.discount.index', compact('discounts'));
    }

    public function create()
    {
        if (!Auth::user()->hasRole('owner')) {
            return abort(403, 'Unauthorized action.');
        }

        $products = $this->productRepository->getProductsName();

        return view('pages.discount.create', compact('products'));
    }

    public function store(StoreVoucherRequest $request)
    {
        $this->discountRepository->createDiscount($request->validated());

        return redirect()->route('discounts.index')->withSuccess('Berhasil ditambahkan');
    }

    public function edit(Discount $discount)
    {
        if (!Auth::user()->hasRole('owner')) {
            return abort(403, 'Unauthorized action.');
        }

        $products = Product::all();
        return view('pages.discount.edit', compact('discount', 'products'));
    }

    public function update(UpdateVoucherRequest $request, Discount $voucher)
    {
        $voucher->update($request->validated());

        return redirect()->route('discounts.index')->withSuccess('Berhasil diubah');
    }

    public function destroy(Discount $voucher)
    {
        $voucher->delete();

        return redirect()->route('discount.index')->withSuccess('Berhasil dihapus');
    }
}
