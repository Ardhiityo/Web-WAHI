<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Exception;
use Midtrans\Notification;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MidtransController extends Controller
{
    public function __construct()
    {
        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = config('midtrans.is_sanitized');
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = config('midtrans.is_3ds');
    }

    public function notification()
    {
        try {
            $notification = new Notification();
        } catch (Exception $e) {
            exit($e->getMessage());
        }

        $notification = $notification->getResponse();
        $transaction = $notification->transaction_status;
        $order_id = $notification->order_id;

        if ($transaction == 'settlement') {
            try {
                DB::beginTransaction();
                $user = Transaction::where('transaction_code', $order_id)->first();
                $carts = Cart::where('user_id', $user->user_id)->get();
                foreach ($carts as $cart) {
                    if ($cart->quantity > $cart->product->stock) {
                        throw new Exception('Produk yang dibeli melebihi stok produk');
                    } else {
                        $cart->product->update([
                            'stock' => $cart->product->stock - $cart->quantity
                        ]);
                    }
                }
                Transaction::where('transaction_code', $order_id)->update([
                    'transaction_status' => 'paid'
                ]);

                $cart->delete();
                DB::commit();
            } catch (Exception $exception) {
                Log::info($exception->getMessage());
                DB::rollBack();
            }
        }
    }
}
