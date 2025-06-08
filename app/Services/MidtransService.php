<?php

namespace App\Services;

use Exception;
use Midtrans\Config;
use Midtrans\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Services\Interfaces\CartInterface;
use App\Services\Interfaces\TransactionInterface;

class MidtransService
{
    public function __construct(
        private TransactionInterface $transactionRepository,
        private CartInterface $cartRepository
    ) {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    public function getNotification()
    {
        try {
            $notification = new Notification();
            $notification = $notification->getResponse();
            $transaction = $notification->transaction_status;
            $order_id = $notification->order_id;

            if ($transaction == 'settlement') {
                DB::beginTransaction();

                $transaction = $this->transactionRepository->getTransactionByCode($order_id);
                $carts = $this->cartRepository->getCartsByUserId($transaction->user_id);

                foreach ($carts as $cart) {
                    if ($cart->quantity <= $cart->product->stock && $cart->product->stock > 0) {
                        $cart->product->update([
                            'stock' => $cart->product->stock - $cart->quantity
                        ]);
                    } else {
                        throw new Exception('Produk yang dibeli melebihi stok.');
                    }
                }

                $transaction->update([
                    'transaction_status' => 'paid'
                ]);

                $this->cartRepository->deleteCartsByUserId($transaction->user_id);

                DB::commit();
            }
        } catch (Exception $exception) {
            DB::rollBack();
            Log::info($exception->getMessage());
            throw new Exception($exception->getMessage());
        }
    }
}
