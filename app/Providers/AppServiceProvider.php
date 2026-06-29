<?php

namespace App\Providers;

use App\Contract\AuthServiceContract;
use App\Contract\BookingServiceContract;
use App\Contract\PaymentGatewayContract;
use App\Contract\ProductServiceContract;
use App\Services\AuthService;
use App\Services\BookingService;
use App\Services\PaymentGatewayService;
use App\Services\ProductService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AuthServiceContract::class, AuthService::class);
        $this->app->bind(BookingServiceContract::class, BookingService::class);
        $this->app->bind(PaymentGatewayContract::class, PaymentGatewayService::class);
        $this->app->bind(ProductServiceContract::class, ProductService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
