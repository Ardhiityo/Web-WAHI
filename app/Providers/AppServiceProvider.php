<?php

namespace App\Providers;

use App\Services\Interfaces\BrandInterface;
use App\Services\Interfaces\ProductInterface;
use App\Services\Repositories\BrandRepository;
use App\Services\Repositories\ProductRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(BrandInterface::class, BrandRepository::class);
        $this->app->singleton(ProductInterface::class, ProductRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
