<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\ProductTransactionController;
use App\Http\Controllers\ProfitController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TransactionController;

Route::middleware('auth')->group(function () {
    Route::get('/',  [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('brands', BrandController::class);
    Route::resource('products', ProductController::class);

    Route::resource('carts', CartController::class);

    Route::get('/checkouts', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkouts/cashless', [CheckoutController::class, 'snapToken'])->name('checkout.snaptoken');

    Route::resource('discounts', DiscountController::class);
    Route::resource('transactions', TransactionController::class);

    Route::patch('/transactions/{transaction}/cancel', [TransactionController::class, 'cancel'])->name('transactions.cancel');

    Route::resource('product-transactions', ProductTransactionController::class);
    Route::resource('roles', RoleController::class);

    Route::get('/profits', [ProfitController::class, 'index'])->name('profits.index');

    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/export', [ReportController::class, 'exportByDate'])->name('reports.export.date');
    Route::get('/reports/export/{transaction}', [ReportController::class, 'exportByTransaction'])->name('reports.export.transaction');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
