<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\AccessTokenRepositoryInterface;
use App\Repositories\DbAccessTokenRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AccessTokenRepositoryInterface::class, DbAccessTokenRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
