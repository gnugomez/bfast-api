<?php

namespace App\Infrastructure\Services;

use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Routing\UrlGenerator;

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


        if (env('REDIRECT_HTTPS')) {
            $this->app['request']->server->set('HTTPS', true);
        }
    }


    public function boot(UrlGenerator $url)
    {
        if (env('REDIRECT_HTTPS')) {
            $url->formatScheme('https://');
        }
    }
}
