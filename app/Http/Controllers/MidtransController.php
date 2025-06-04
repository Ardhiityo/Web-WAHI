<?php

namespace App\Http\Controllers;

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
        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = config('midtrans.is_sanitized');
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = config('midtrans.is_3ds');
        Log::info('Midtrans notification received');
        try {
            $notification = new Notification();
        } catch (\Exception $e) {
            exit($e->getMessage());
        }

        $notification = $notification->getResponse();
        $transaction = $notification->transaction_status;
        $order_id = $notification->order_id;
        if ($transaction == 'settlement') {
            try {
                DB::beginTransaction();
                Transaction::where('transaction_code', $order_id)->update([
                    'transaction_status' => 'paid'
                ]);
                DB::commit();
                Log::info('Oke');
            } catch (\Throwable $th) {
                DB::rollBack();
            }
        }
    }
}
