<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\ProductTransaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\ProductTransaction\UpdateProductTransactionRequest;

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
    public function update(UpdateProductTransactionRequest $request)
    {
        $data = $request->validated();

        try {
            DB::beginTransaction();

            ProductTransaction::where('product_id', $data['product_id'])
                ->where('transaction_id', $data['transaction_id'])
                ->update($data);

            $transaction = Transaction::find($data['transaction_id']);

            $subtotalAmount = 0;
            $discount = 0;

            foreach ($transaction->products as $key => $product) {
                $subtotalAmount += $product->price * $product->pivot->quantity;
            }

            $totalAmount = $subtotalAmount;

            if ($transaction->discount_percentage) {
                $discount = $subtotalAmount * ($transaction->discount_percentage / 100);
                $totalAmount -= $discount;
            }

            $transaction->update([
                'discount' => $discount,
                'subtotal_amount' => $subtotalAmount,
                'total_amount' => $totalAmount
            ]);

            DB::commit();

            return redirect()->route('transactions.show', ['transaction' => $data['transaction_id']])
                ->withSuccess('Berhasil diubah');
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            DB::rollBack();

            return redirect()->route('transactions.show', ['transaction' => $data['transaction_id']])
                ->with('error', $exception->getMessage());
        }
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
