<?php

namespace App\Services\Repositories;

use Exception;
use App\Models\Cart;
use App\Models\Transaction;
use App\Models\ProductTransaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Services\Interfaces\TransactionInterface;
use Illuminate\Contracts\Database\Eloquent\Builder;

class TransactionRepository implements TransactionInterface
{
    public function createTransaction(array $data): Transaction
    {
        try {
            DB::beginTransaction();

            // Create Transaction
            $subTotalSellingAmount = 0;
            $grandTotalSellingAmount = 0;
            $discount = 0;
            $totalDiscount = 0;
            $userId = Auth::user()->id;
            $grandTotalPurchaseAmount = 0;

            $carts = Cart::with([
                'product' => fn(Builder $query) => $query->with('discount:id,discount,untill_date,product_id')
                    ->select('id', 'price', 'purchase_price', 'stock')
            ])
                ->select('id', 'product_id', 'quantity')
                ->where('user_id', $userId)
                ->get();

            foreach ($carts as $key => $cart) {
                $productPrice =  $cart->product->price;

                if ($cart->product->discount->discount ?? false) {
                    $discountIsValid = $cart->product->discount->untill_date >= now();

                    if ($discountIsValid) {
                        $discountPercentage = $cart->product->discount->discount / 100;
                        $discount = $productPrice * $discountPercentage;
                        $productPrice -= $discount;
                        $totalDiscount += $discount * $cart->quantity;
                    }
                }

                $grandTotalPurchaseAmount += $cart->product->purchase_price * $cart->quantity;

                $subTotalSellingAmount += $cart->product->price * $cart->quantity;
                $grandTotalSellingAmount += $productPrice * $cart->quantity;
            }

            $profitAmount = $grandTotalSellingAmount - $grandTotalPurchaseAmount;

            $transaction = Transaction::create(
                [
                    'transaction_code' => $data['transaction_code'],
                    'grandtotal_purchase_amount' => $grandTotalPurchaseAmount,
                    'total_discount' => $totalDiscount,
                    'subtotal_selling_amount' => $subTotalSellingAmount,
                    'grandtotal_selling_amount' => $grandTotalSellingAmount,
                    'profit_amount' => $profitAmount,
                    'transaction_type' => $data['transaction_type'],
                    'transaction_status' => 'pending',
                    'user_id' => $userId,
                ]
            );

            Session::put('transaction_code', $transaction->transaction_code);
            // End Create Transaction

            // Create Product Transaction
            foreach ($carts as $key => $cart) {

                $unitPurchasePriceProductTransaction = $cart->product->purchase_price;
                $grandTotalPurchaseAmountProductTransaction = $cart->product->purchase_price * $cart->quantity;
                $unitSellingPriceProductTransaction = $cart->product->price;
                $totalDiscountProductTransaction = 0;
                $productPriceProductTransaction = $cart->product->price;
                $subTotalSellingAmountProductTransaction = $productPriceProductTransaction * $cart->quantity;

                if ($cart->product->discount->discount ?? false) {
                    $discountIsValidProductTransaction = $cart->product->discount->untill_date >= now();

                    if ($discountIsValidProductTransaction) {
                        $discountPercentage = $cart->product->discount->discount / 100;
                        $discount = $unitSellingPriceProductTransaction * $discountPercentage;
                        $productPriceProductTransaction -= $discount;
                        $totalDiscountProductTransaction += $discount * $cart->quantity;
                    }
                }

                $grandTotalSellingAmountProductTransaction = $subTotalSellingAmountProductTransaction - $totalDiscountProductTransaction;
                $profitAmountProductTransaction = $grandTotalSellingAmountProductTransaction - $grandTotalPurchaseAmountProductTransaction;

                ProductTransaction::create([
                    'product_id' => $cart->product_id,
                    'transaction_id' => $transaction->id,
                    'unit_purchase_price' => $unitPurchasePriceProductTransaction,
                    'grandtotal_purchase_amount' => $grandTotalPurchaseAmountProductTransaction,
                    'unit_selling_price' => $unitSellingPriceProductTransaction,
                    'subtotal_selling_amount' => $subTotalSellingAmountProductTransaction,
                    'total_discount' => $totalDiscountProductTransaction,
                    'grandtotal_selling_amount' => $grandTotalSellingAmountProductTransaction,
                    'profit_amount' => $profitAmountProductTransaction,
                    'quantity' => $cart->quantity
                ]);
            };

            if ($transaction->transaction_type == 'cash') {
                Cart::where('user_id', $userId)->delete();
            }
            // End Create Product Transaction

            DB::commit();

            return $transaction;
        } catch (Exception $exception) {
            DB::rollBack();
            throw new Exception($exception->getMessage());
        }
    }

    public function getTransactionByCode(string $code)
    {
        return Transaction::select('id', 'total_amount', 'transaction_code', 'user_id')
            ->where('transaction_code', $code)->first();
    }

    public function getTransactionDates()
    {
        return Transaction::select('created_at')
            ->where('transaction_status', 'paid')
            ->orderByDesc('id')
            ->get()
            ->unique('created_at');
    }

    public function getTransactionProfitByDateRange(string $startDate, string $endDate)
    {
        return Transaction::where('transaction_status', 'paid')
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->sum('profit_amount');
    }

    public function getTotalTransactionProfit()
    {
        return Transaction::where('transaction_status', 'paid')->sum('profit_amount');
    }

    public function getTotalTransactionsByUser($status): int
    {
        return Transaction::where('user_id', Auth::user()->id)
            ->where('transaction_status', $status)->count();
    }

    public function getTotalTransactionsByStatus($status): int
    {
        return Transaction::where('transaction_status', $status)->count();
    }

    public function updateTransactionStatus(int $id, array $data)
    {
        try {
            DB::beginTransaction();

            $productTransactions = ProductTransaction::with('product:id,stock')
                ->select('product_id', 'transaction_id', 'quantity')
                ->where('transaction_id', $id)
                ->get();

            foreach ($productTransactions as $productTransaction) {
                if ($productTransaction->quantity <= $productTransaction->product->stock && $productTransaction->product->stock > 0) {
                    $productTransaction->product()->update([
                        'stock' => $productTransaction->product->stock - $productTransaction->quantity
                    ]);
                } else {
                    throw new Exception('Produk yang dibeli melebihi stok.');
                }
            }

            $productTransaction->transaction()->update($data);

            DB::commit();
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            DB::rollBack();
            throw $exception;
        }
    }

    public function getTransactionById(int $id)
    {
        return Transaction::with('products:id,stock,price')->select('id', 'discount_percentage')->find($id);
    }

    public function updateTransaction(array $data)
    {
        try {
            DB::beginTransaction();

            // Update Product Transaction
            $productTransaction = ProductTransaction::where('transaction_id', $data['transaction_id'])
                ->where('product_id', $data['product_id'])
                ->first();

            $quantity = $data['quantity'];

            $totalDiscountProductTransaction = 0;
            $productTransactionPrice = $productTransaction->product->price;
            $grandTotalPurchaseAmountProductTransaction = $productTransaction->product->purchase_price * $quantity;
            $subTotalSellingAmountProductTransaction = $productTransaction->product->price * $quantity;

            if ($productTransaction->product->discount->discount ?? false) {
                $productTransactionDiscountPercentage = $productTransaction->product->discount->discount / 100;
                $totalDiscountProductTransaction = ($productTransactionPrice * $productTransactionDiscountPercentage) * $quantity;
            }

            $grandTotalSellingAmountProductTransaction = $subTotalSellingAmountProductTransaction - $totalDiscountProductTransaction;
            $profitAmount = $grandTotalSellingAmountProductTransaction - $grandTotalPurchaseAmountProductTransaction;

            ProductTransaction::where('product_id', $data['product_id'])
                ->where('transaction_id', $data['transaction_id'])
                ->update([
                    'product_id' => $data['product_id'],
                    'transaction_id' => $data['transaction_id'],
                    'grandtotal_purchase_amount' => $grandTotalPurchaseAmountProductTransaction,
                    'subtotal_selling_amount' => $subTotalSellingAmountProductTransaction,
                    'total_discount' => $totalDiscountProductTransaction,
                    'grandtotal_selling_amount' => $grandTotalSellingAmountProductTransaction,
                    'profit_amount' => $profitAmount,
                    'quantity' => $quantity
                ]);
            // End Update Product Transaction

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
                )->find($data['transaction_id']);

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
        } catch (Exception $exception) {
            Log::info($exception->getMessage());
            DB::rollBack();
            throw $exception;
        }
    }

    public function getTransactionsByCode($keyword)
    {
        if (Auth::user()->hasRole('customer')) {
            return Transaction::where('transaction_code', $keyword)
                ->where('user_id', Auth::user()->id)
                ->latest()
                ->paginate(perPage: 5);
        } else {
            return Transaction::where('transaction_code', $keyword)
                ->latest()
                ->paginate(perPage: 5);
        }
    }

    public function getTransactionsByName($keyword)
    {
        return Transaction::whereHas('user', function ($query) use ($keyword) {
            $query->whereLike('name', '%' . $keyword . '%');
        })->latest()->paginate(perPage: 5);
    }

    public function getTransactionsByType($keyword)
    {
        if (Auth::user()->hasRole('customer')) {
            return Transaction::where('transaction_type', $keyword)
                ->where('user_id', Auth::user()->id)
                ->latest()->paginate(perPage: 5);
        } else {
            return Transaction::where('transaction_type', $keyword)
                ->latest()->paginate(perPage: 5);
        }
    }

    public function getTransactionsByStatus($keyword)
    {
        if (Auth::user()->hasRole('customer')) {
            return Transaction::where('transaction_status', $keyword)
                ->where('user_id', Auth::user()->id)
                ->latest()->paginate(perPage: 5);
        } else {
            return Transaction::where('transaction_status', $keyword)->latest()->paginate(perPage: 5);
        }
    }

    public function getAllTransactions()
    {
        if (Auth::user()->hasRole('customer')) {
            return Transaction::where('user_id', Auth::user()->id)
                ->latest()->paginate(perPage: 5);
        } else {
            return Transaction::latest()->paginate(perPage: 5);
        }
    }
}
