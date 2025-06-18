<?php

namespace App\Services;

use Exception;
use Midtrans\Config;
use Midtrans\Transaction;
use Midtrans\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Services\Interfaces\CartInterface;
use App\Services\Interfaces\TransactionInterface;

class MidtransService
{
    public function __construct(
        private TransactionInterface $transactionRepository,
        private CartInterface $cartRepository,
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

                foreach ($transaction->products as $product) {
                    if ($product->pivot->quantity <= $product->stock && $product->stock > 0) {
                        $product->product->update([
                            'stock' => $product->stock - $product->pivot->quantity
                        ]);
                    } else {
                        throw new Exception('Produk yang dibeli melebihi stok.');
                    }
                }

                $transaction->update([
                    'transaction_status' => 'paid'
                ]);

                DB::commit();

                return response()->json([
                    'message' => 'success',
                ], 200);
            }
        } catch (Exception $exception) {
            DB::rollBack();
            Log::info($exception->getMessage());
            throw new Exception($exception->getMessage());
        }
    }

    public function checkStatus(string $orderId)
    {
        try {
            // <- SDK akan GET /v2/{orderId}/status;
            $transaction = Transaction::status($orderId);
            return $transaction;
        } catch (\Throwable $th) {
            Log::info(json_encode($th->getMessage(), JSON_PRETTY_PRINT));
            return false;
        }
    }

    public function isPaid($response)
    {
        $isPaid = in_array($response->transaction_status, ['capture', 'settlement', 'success']);

        if ($isPaid) {
            try {
                DB::beginTransaction();

                $order_id = $response->order_id;
                $transaction = $this->transactionRepository->getTransactionByCode($order_id);

                Log::info(json_encode($transaction, JSON_PRETTY_PRINT), ['is_paid']);

                foreach ($transaction->products as $product) {
                    if ($product->pivot->quantity <= $product->stock && $product->stock > 0) {
                        $product->update([
                            'stock' => $product->stock - $product->pivot->quantity
                        ]);
                    } else {
                        throw new Exception('Produk yang dibeli melebihi stok.');
                    }
                }

                $transaction->update(['transaction_status' => 'paid']);

                DB::commit();
            } catch (\Throwable $th) {
                DB::rollBack();
                Log::info($th->getMessage());
            }
        }

        return $isPaid;
    }
}
