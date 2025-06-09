<?php

namespace App\Http\Controllers;

use Exception;
use Midtrans\Snap;
use Illuminate\Http\Request;
use App\Services\MidtransService;
use Illuminate\Support\Facades\Log;
use App\Services\Interfaces\CartInterface;
use App\Services\Interfaces\TransactionInterface;

class CheckoutController extends Controller
{
    public function __construct(
        private MidtransService $midtransService,
        private CartInterface $cartRepository,
        private TransactionInterface $transactionRepository
    ) {}

    public function index()
    {
        return view('pages.checkout.index');
    }

    public function snapToken(Request $request)
    {
        $transaction = $this->transactionRepository->getTransactionByCode($request->transaction_code);

        $params = [
            'transaction_details' => [
                'order_id' => $transaction->transaction_code,
                'gross_amount' => $transaction->total_amount
            ]
        ];

        try {
            $snapToken = Snap::getSnapToken($params);

            return response()->json([
                'token' => $snapToken
            ]);
        } catch (Exception $exception) {
            Log::info($exception->getMessage());

            return response()->json([
                'token' => $exception->getMessage()
            ]);
        }
    }
}
