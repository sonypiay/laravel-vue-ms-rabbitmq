<?php

namespace App\Providers;

use App\Jobs\ProductCreated;
use App\Jobs\TestJob;
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
        $this->app->bindMethod(TestJob::class, 'handle', fn($jobs) => $jobs->handle());
    }
}
