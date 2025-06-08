<?php

namespace App\Http\Controllers;

use App\Services\MidtransService;
use Exception;

class MidtransController extends Controller
{
    public function __construct(private MidtransService $midtransService) {}

    public function notification()
    {
        try {
            return $this->midtransService->getNotification();
        } catch (Exception $exception) {
            return response()->json([
                'message' => 'Failed to process notification',
                'error' => $exception->getMessage()
            ], 500);
        }
    }
}
