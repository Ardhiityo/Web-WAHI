<?php

use App\Http\Controllers\MidtransController;
use Illuminate\Support\Facades\Route;

Route::post('/midtrans/callback/notification', [MidtransController::class, 'notification'])
    ->name('midtrans.notification');
