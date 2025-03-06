<?php

namespace App\Providers;

use App\Jobs\ProductLiked;
use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
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
        $this->app->bindMethod(ProductLiked::class, 'handle', fn($jobs) => $jobs->handle());
    }
}
