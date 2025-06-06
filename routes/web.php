<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductTransactionController;
use App\Http\Controllers\ProfitController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TransactionController;

Route::middleware('auth')->group(function () {
    Route::get('/',  [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('brands', BrandController::class);
    Route::resource('products', ProductController::class);

    Route::get('/carts/checkout', [CartController::class, 'checkout'])->name('carts.checkout');
    Route::post('/carts/checkout/detail', [CartController::class, 'checkoutDetail'])->name('carts.checkout.detail');
    Route::post('/carts/checkout/cashless', [CartController::class, 'getSnapToken'])->name('carts.checkout.snaptoken');

    Route::resource('carts', CartController::class);
    Route::resource('vouchers', VoucherController::class);
    Route::resource('transactions', TransactionController::class);
    Route::resource('product-transactions', ProductTransactionController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('profits', ProfitController::class);

    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/export', [ReportController::class, 'exportByDate'])->name('reports.export.date');
    Route::get('/reports/export/{transaction}', [ReportController::class, 'exportByTransaction'])->name('reports.export.transaction');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
