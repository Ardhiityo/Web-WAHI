<?php

use App\Http\Controllers\MidtransController;
use Illuminate\Support\Facades\Route;

Route::post('/midtrans/callback/notification', [MidtransController::class, 'notification'])
    ->name('midtrans.notification');

Route::post('/tes', function () {
    return response()->json([
        'message' => 'Hello World'
    ]);
});

    //api/midtrans/callback/notification
