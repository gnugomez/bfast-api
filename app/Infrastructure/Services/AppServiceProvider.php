<?php

namespace App\Infrastructure\Services;

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
            'App\Domain\Contracts\UserRepositoryContract',
            'App\Infrastructure\Persistence\Eloquent\UserRepository'
        );
    }
}
