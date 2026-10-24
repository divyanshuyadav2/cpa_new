<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\PushNotificationServiceInterface;
use App\Services\Notification\FcmNotificationService;
use App\Models\Order;
use App\Observers\OrderObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(PushNotificationServiceInterface::class, FcmNotificationService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Order::observe(OrderObserver::class);
    }
}
