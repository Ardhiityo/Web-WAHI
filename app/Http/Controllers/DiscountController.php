<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Discount;
use App\Services\Interfaces\ProductInterface;
use App\Services\Interfaces\DiscountInterface;
use App\Http\Requests\Voucher\StoreVoucherRequest;
use App\Http\Requests\Voucher\UpdateVoucherRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class DiscountController extends Controller
{
    use AuthorizesRequests;

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
        $this->authorize('discount.create');

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
        $this->authorize('discount.edit');

        $products = $this->productRepository->getProducts();

        return view('pages.discount.edit', compact('discount', 'products'));
    }

    public function update(UpdateVoucherRequest $request, Discount $voucher)
    {
        $voucher->update($request->validated());

        return redirect()->route('discounts.index')->withSuccess('Berhasil diubah');
    }

    public function destroy(Discount $voucher)
    {
        $this->authorize('discount.destroy');

        $voucher->delete();

        return redirect()->route('discount.index')->withSuccess('Berhasil dihapus');
    }
}
