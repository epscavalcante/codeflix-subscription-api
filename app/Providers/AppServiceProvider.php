<?php

namespace App\Providers;

use App\Repositories\PlanEloquentRepository;
use Core\Plan\Domain\Repositories\PlanRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(
            PlanRepositoryInterface::class,
            PlanEloquentRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
