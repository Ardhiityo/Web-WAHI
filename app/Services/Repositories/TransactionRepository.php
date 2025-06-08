<?php

namespace App\Services\Repositories;

use Exception;
use App\Models\Cart;
use App\Models\Voucher;
use App\Models\Transaction;
use App\Models\ProductTransaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Services\Interfaces\TransactionInterface;

class TransactionRepository implements TransactionInterface
{
    public function createTransaction(array $data): Transaction
    {
        try {
            DB::beginTransaction();

            $subtotal = 0;
            $totalAmount = $subtotal;
            $discount = null;
            $totalDiscount = 0;
            $discountPercentage = null;

            $carts = Cart::with('product:id,stock,price')
                ->select('id', 'product_id', 'quantity')
                ->where('user_id', Auth::user()->id)
                ->get();

            foreach ($carts as $key => $cart) {
                $subtotal +=  (int)$cart->product->price * (int)$cart->quantity;
            }

            if (!is_null($data['voucher'])) {
                $voucher = Voucher::where('code', $data['voucher'])->first();
                $data['voucher'] = $voucher->id;
                $discount = (int)$voucher->discount / 100;
                $discountPercentage = $voucher->discount;
                $totalDiscount = $subtotal * $discount;
                $totalAmount = $subtotal - $totalDiscount;
            }

            $transaction = Transaction::create(
                [
                    'discount' => $totalDiscount,
                    'discount_percentage' => $discountPercentage,
                    'subtotal_amount' => $subtotal,
                    'transaction_code' => $data['transaction_code'],
                    'transaction_type' => $data['transaction_type'],
                    'voucher_id' => $data['voucher'],
                    'total_amount' => $totalAmount,
                    'transaction_status' => 'pending',
                    'user_id' => Auth::user()->id,
                ]
            );

            Session::put('transaction_code', $transaction->transaction_code);

            foreach ($carts as $key => $cart) {
                ProductTransaction::create([
                    'product_id' => $cart->product_id,
                    'transaction_id' => $transaction->id,
                    'price' => $cart->product->price,
                    'quantity' => $cart->quantity
                ]);
            };

            if ($transaction->transaction_type == 'cash') {
                Cart::where('user_id', Auth::user()->id)->delete();
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

    public function getTransactionByDateRange(string $startDate, string $endDate)
    {
        return Transaction::where('transaction_status', 'paid')
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->sum('total_amount');
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
            return Transaction::where('transaction_status', $keyword)->where('user_id', $user->id)
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
