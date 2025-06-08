<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use Illuminate\Support\Facades\Auth;
use App\Services\Interfaces\VoucherInterface;
use App\Http\Requests\Voucher\StoreVoucherRequest;
use App\Http\Requests\Voucher\UpdateVoucherRequest;

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
        if (!Auth::user()->hasRole('owner')) {
            return abort(403, 'Unauthorized action.');
        }

        return view('pages.voucher.create');
    }

    public function store(StoreVoucherRequest $request)
    {
        $this->voucherRepository->createVoucher($request->validated());

        return redirect()->route('vouchers.index')->withSuccess('Berhasil ditambahkan');
    }

    public function edit(Voucher $voucher)
    {
        if (!Auth::user()->hasRole('owner')) {
            return abort(403, 'Unauthorized action.');
        }

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
