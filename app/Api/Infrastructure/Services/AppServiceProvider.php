<?php

namespace App\Api\Infrastructure\Services;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->bind(
            'App\Api\Domain\Contracts\UserRepositoryContract',
            'App\Api\Infrastructure\Persistence\Eloquent\UserRepository'
        );
    }
}
