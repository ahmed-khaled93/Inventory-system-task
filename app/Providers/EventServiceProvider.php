<?php

namespace App\Providers;

// use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events\LowStockDetected;
use App\Listeners\SendLowStockAlert;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        LowStockDetected::class => [
            SendLowStockAlert::class,
        ],
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}


