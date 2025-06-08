<?php

namespace App\Http\Controllers;

use Midtrans\Snap;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Services\MidtransService;
use App\Services\Interfaces\CartInterface;

class CheckoutController extends Controller
{
    public function __construct(
        private MidtransService $midtransService,
        private CartInterface $cartRepository
    ) {}

    public function index()
    {
        return view('pages.checkout.index');
    }

    public function snapToken(Request $request)
    {
        $transaction = Transaction::where('transaction_code', $request->transaction_code)->first();

        $params = [
            'transaction_details' => [
                'order_id' => $transaction->transaction_code,
                'gross_amount' => $transaction->total_amount
            ]
        ];

        $snapToken = Snap::getSnapToken($params);

        return response()->json([
            'token' => $snapToken
        ]);
    }
}
