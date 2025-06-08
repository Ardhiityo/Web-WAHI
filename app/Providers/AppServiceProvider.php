<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Interfaces\CartInterface;
use App\Services\Interfaces\BrandInterface;
use App\Services\Interfaces\ProductInterface;
use App\Services\Repositories\CartRepository;
use App\Services\Interfaces\TransactionInterface;
use App\Services\Repositories\BrandRepository;
use App\Services\Repositories\ProductRepository;
use App\Services\Repositories\TransactionRepository;

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
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
