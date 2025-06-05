<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductTransaction\UpdateProductTransactionRequest;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\ProductTransaction;
use Illuminate\Support\Facades\Log;

class ProductTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ProductTransaction $productTransaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductTransaction $productTransaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductTransactionRequest $request, ProductTransaction $productTransaction)
    {
        $data = $request->validated();

        ProductTransaction::where('transaction_id', $data['transaction_id'])
            ->where('product_id', $data['product_id'])
            ->update($data);

        return redirect()->route('transactions.show', ['transaction' => $data['transaction_id']])
            ->withSuccess('Berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction, Request $request)
    {
        ProductTransaction::where('product_id', $request->product_id)
            ->where('transaction_id', $request->transaction_id)->delete();
        return redirect()->route('transactions.show', ['transaction' => $request->transaction_id])->withSuccess('Berhasil dihapus');
    }
}
