<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Interfaces\CartInterface;
use App\Services\Interfaces\BrandInterface;
use App\Services\Interfaces\ProductInterface;
use App\Services\Interfaces\VoucherInterface;
use App\Services\Repositories\CartRepository;
use App\Services\Repositories\BrandRepository;
use App\Services\Repositories\ProductRepository;
use App\Services\Repositories\VoucherRepository;
use App\Services\Interfaces\TransactionInterface;
use App\Services\Repositories\TransactionRepository;
use App\Services\Interfaces\ProductTransactionInterface;
use App\Services\Repositories\ProductTransactionRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(BrandInterface::class, BrandRepository::class);
        $this->app->singleton(ProductInterface::class, ProductRepository::class);
        $this->app->singleton(CartInterface::class, CartRepository::class);
        $this->app->singleton(TransactionInterface::class, TransactionRepository::class);
        $this->app->singleton(VoucherInterface::class, VoucherRepository::class);
        $this->app->bind(ProductTransactionInterface::class, ProductTransactionRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
