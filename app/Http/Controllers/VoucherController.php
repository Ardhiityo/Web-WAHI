<?php

namespace App\Http\Controllers;

use App\Http\Requests\Voucher\StoreVoucherRequest;
use App\Http\Requests\Voucher\UpdateVoucherRequest;
use App\Models\Voucher;
use App\Services\Interfaces\VoucherInterface;

class VoucherController extends Controller
{
    public function __construct(private VoucherInterface $voucherRepository) {}

    public function index()
    {
        $vouchers = $this->voucherRepository->getAllVouchers();

        return view('pages.voucher.index', compact('vouchers'));
    }

    public function create()
    {
        return view('pages.voucher.create');
    }

    public function store(StoreVoucherRequest $request)
    {
        $this->voucherRepository->createVoucher($request->validated());

        return redirect()->route('vouchers.index')->withSuccess('Berhasil ditambahkan');
    }

    public function edit(Voucher $voucher)
    {
        return view('pages.voucher.edit', compact('voucher'));
    }

    public function update(UpdateVoucherRequest $request, Voucher $voucher)
    {
        $voucher->update($request->validated());

        return redirect()->route('vouchers.index')->withSuccess('Berhasil diubah');
    }

    public function destroy(Voucher $voucher)
    {
        $voucher->delete();

        return redirect()->route('vouchers.index')->withSuccess('Berhasil dihapus');
    }
}
