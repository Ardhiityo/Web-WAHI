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

            $subTotal = 0;
            $totalAmount = 0;
            $discount = 0;
            $discountProduct = 0;
            $userId = Auth::user()->id;

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
                    $discountIsValid = $cart->product->discount->untill_date > now();

                    if ($discountIsValid) {
                        $discountPercentage = $cart->product->discount->discount / 100;
                        $discount = $productPrice * $discountPercentage;
                        $productPrice -= $discount;
                        $discountProduct += $discount * $cart->quantity;
                    }
                }

                $subTotal += $cart->product->price * $cart->quantity;
                $totalAmount += $productPrice * $cart->quantity;
            }

            $totalDiscount = $discountProduct;

            $transaction = Transaction::create(
                [
                    'total_discount' => $totalDiscount,
                    'subtotal_amount' => $subTotal,
                    'total_amount' => $totalAmount,
                    'transaction_code' => $data['transaction_code'],
                    'transaction_type' => $data['transaction_type'],
                    'transaction_status' => 'pending',
                    'user_id' => $userId,
                ]
            );

            Session::put('transaction_code', $transaction->transaction_code);

            foreach ($carts as $key => $cart) {

                $discountProductTransaction = 0;
                $productTransactionPrice = $cart->product->price;

                if ($cart->product->discount->discount ?? false) {
                    $productTransactionDiscountPercentage = $cart->product->discount->discount / 100;
                    $discountProductTransaction = $productTransactionPrice * $productTransactionDiscountPercentage;
                }

                Log::info(json_encode($discountProductTransaction, JSON_PRETTY_PRINT), ['discountProductTransaction']);

                Log::info(json_encode($productTransactionPrice, JSON_PRETTY_PRINT), ['productTransactionPrice']);

                $productTransaction = ProductTransaction::create([
                    'product_id' => $cart->product_id,
                    'transaction_id' => $transaction->id,
                    'purchase_price' => $cart->product->purchase_price,
                    'unit_price' => $cart->product->price,
                    'subtotal_price' => $cart->product->price * $cart->quantity,
                    'total_price' => ($productTransactionPrice * $cart->quantity) - ($discountProductTransaction * $cart->quantity),
                    'total_discount' => $discountProductTransaction * $cart->quantity,
                    'quantity' => $cart->quantity,
                    'discount' => $discountProductTransaction
                ]);
            };

            Log::info(json_encode($productTransaction, JSON_PRETTY_PRINT), ['productTransaction']);

            if ($transaction->transaction_type == 'cash') {
                Cart::where('user_id', $userId)->delete();
            }

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
            ->sum('total_amount');
    }

    public function getTotalTransactionProfit()
    {
        return Transaction::where('transaction_status', 'paid')->sum('total_amount');
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

            ProductTransaction::where('transaction_id', $data['transaction_id'])
                ->where('product_id', $data['product_id'])
                ->update($data);

            $transaction = $this->getTransactionById($data['transaction_id']);

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
