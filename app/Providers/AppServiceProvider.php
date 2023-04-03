<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\PopulatorInterface;
use App\Services\PopulatorService;
use App\Contracts\ApiInterface;
use App\Services\MarvelApiService;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(PopulatorInterface::class, PopulatorService::class);
        $this->app->bind(ApiInterface::class, MarvelApiService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}