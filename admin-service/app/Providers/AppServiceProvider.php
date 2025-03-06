<?php

namespace App\Providers;

use App\Jobs\ProductLiked;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->bindMethod(ProductLiked::class, 'handle', fn($job) => $job->handle());
    }
}
