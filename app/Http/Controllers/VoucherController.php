<?php

namespace App\Http\Controllers;

use App\Http\Requests\Voucher\StoreVoucherRequest;
use App\Http\Requests\Voucher\UpdateVoucherRequest;
use App\Models\Voucher;

class VoucherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vouchers = Voucher::paginate(perPage: 10);

        return view('pages.voucher.index', compact('vouchers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.voucher.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVoucherRequest $request)
    {
        Voucher::create($request->validated());

        return redirect()->route('vouchers.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Voucher $voucher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Voucher $voucher)
    {
        return view('pages.voucher.edit', compact('voucher'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVoucherRequest $request, Voucher $voucher)
    {
        $voucher->update($request->validated());

        return redirect()->route('vouchers.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Voucher $voucher)
    {
        $voucher->delete();

        return redirect()->route('vouchers.index');
    }
}
