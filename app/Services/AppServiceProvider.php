<?php

namespace App\Services;

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
            'App\User\Domain\Contracts\UserRepositoryContract',
            'App\User\Infrastucture\EloquentUserRepository'
        );
    }
}
