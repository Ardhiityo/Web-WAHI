<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Interfaces\CartInterface;
use App\Services\Interfaces\RoleInterface;
use App\Services\Interfaces\BrandInterface;
use App\Services\Interfaces\DiscountInterface;
use App\Services\Interfaces\ProductInterface;
use App\Services\Repositories\CartRepository;
use App\Services\Repositories\RoleRepository;
use App\Services\Repositories\BrandRepository;
use App\Services\Repositories\ProductRepository;
use App\Services\Interfaces\TransactionInterface;
use App\Services\Repositories\TransactionRepository;
use App\Services\Interfaces\ProductTransactionInterface;
use App\Services\Repositories\DiscountRepository;
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
        $this->app->singleton(DiscountInterface::class, DiscountRepository::class);
        $this->app->bind(ProductTransactionInterface::class, ProductTransactionRepository::class);
        $this->app->bind(RoleInterface::class, RoleRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
