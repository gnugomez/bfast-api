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
            'App\User\Domain\Interfaces\UserRepositoryInterface',
            'App\User\Infrastucture\EloquentUserRepository'
        );
    }
}
