<?php

namespace App\Services\Repositories;

use Exception;
use App\Models\Cart;
use App\Models\Voucher;
use App\Models\Transaction;
use App\Models\ProductTransaction;
use Illuminate\Support\Facades\DB;
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
        return Transaction::select('id')->where('transaction_code', $code)->firstOrFail();
    }
}
