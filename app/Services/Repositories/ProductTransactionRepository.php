<?php

namespace App\Services\Repositories;

use App\Models\Transaction;
use App\Models\ProductTransaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Database\Eloquent\Builder;
use App\Services\Interfaces\ProductTransactionInterface;

class ProductTransactionRepository implements ProductTransactionInterface
{
    public function getProductTransactionsByTransactionId(int $transactionId)
    {
        return ProductTransaction::with('product:id,stock')
            ->select('product_id', 'transaction_id', 'quantity')
            ->where('transaction_id', $transactionId)
            ->get();
    }

    public function deleteProductTransaction($product_id, $transaction_id)
    {
        try {
            DB::beginTransaction();

            ProductTransaction::where('product_id', $product_id)
                ->where('transaction_id', $transaction_id)->delete();

            // Update Transaction
            $transaction = Transaction::with([
                'products' => fn(Builder $query) => $query->with('discount:id,discount,untill_date,product_id')
                    ->select('id', 'price', 'purchase_price')
            ])
                ->select(
                    'id',
                    'grandtotal_purchase_amount',
                    'total_discount',
                    'subtotal_selling_amount',
                    'grandtotal_selling_amount',
                    'profit_amount'
                )->find($transaction_id);

            $grandTotalPurchaseAmount = 0;
            $totalDiscount = 0;
            $subTotalSellingAmount = 0;
            $grandTotalSellingAmount = 0;

            foreach ($transaction->products as $productTransaction) {
                $productPrice =  $productTransaction->price;

                if ($productTransaction->discount->discount ?? false) {
                    $discountIsValid = $productTransaction->discount->untill_date >= now();

                    if ($discountIsValid) {
                        $discountPercentage = $productTransaction->discount->discount / 100;
                        $discount = $productPrice * $discountPercentage;
                        $productPrice -= $discount;
                        $totalDiscount += $discount * $productTransaction->pivot->quantity;
                    }
                }

                $grandTotalPurchaseAmount += $productTransaction->purchase_price * $productTransaction->pivot->quantity;
                $subTotalSellingAmount += $productTransaction->price * $productTransaction->pivot->quantity;
                $grandTotalSellingAmount += $productPrice * $productTransaction->pivot->quantity;
            }

            $profitAmount = $grandTotalSellingAmount - $grandTotalPurchaseAmount;

            $transaction->update(
                [
                    'grandtotal_purchase_amount' => $grandTotalPurchaseAmount,
                    'total_discount' => $totalDiscount,
                    'subtotal_selling_amount' => $subTotalSellingAmount,
                    'grandtotal_selling_amount' => $grandTotalSellingAmount,
                    'profit_amount' => $profitAmount,
                ]
            );
            // End Update Transaction;

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
