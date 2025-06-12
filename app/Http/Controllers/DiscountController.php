<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Services\Interfaces\VoucherInterface;
use App\Http\Requests\Voucher\StoreVoucherRequest;
use App\Http\Requests\Voucher\UpdateVoucherRequest;
use App\Models\Discount;

class DiscountController extends Controller
{
    public function __construct(private VoucherInterface $voucherRepository) {}

    public function index()
    {
        $vouchers = $this->voucherRepository->getAllVouchers();

        return view('pages.discount.index', compact('vouchers'));
    }

    public function create()
    {
        if (!Auth::user()->hasRole('owner')) {
            return abort(403, 'Unauthorized action.');
        }

        return view('pages.discount.create');
    }

    public function store(StoreVoucherRequest $request)
    {
        $this->voucherRepository->createVoucher($request->validated());

        return redirect()->route('vouchers.index')->withSuccess('Berhasil ditambahkan');
    }

    public function edit(Discount $voucher)
    {
        if (!Auth::user()->hasRole('owner')) {
            return abort(403, 'Unauthorized action.');
        }

        return view('pages.discount.edit', compact('voucher'));
    }

    public function update(UpdateVoucherRequest $request, Discount $voucher)
    {
        $voucher->update($request->validated());

        return redirect()->route('vouchers.index')->withSuccess('Berhasil diubah');
    }

    public function destroy(Discount $voucher)
    {
        $voucher->delete();

        return redirect()->route('discount.index')->withSuccess('Berhasil dihapus');
    }
}
