<?php

namespace App\Providers;

use App\Models\OrderRecord;
use App\Policies\OrderPolicy;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
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
        //Gate::policy(OrderRecord::class, OrderPolicy::class);
        Paginator::useBootstrapFive();
    }
}
