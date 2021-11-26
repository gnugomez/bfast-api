<?php
use App\Infrastructure\Persistence\Eloquent\Models\User;
use Laravel\Lumen\Routing\Router;

/** @var Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group([
    'prefix' => 'users',
    'namespace' => 'User',
], function () use ($router) {
    $router->get('', "GetAll");
    $router->get('me', "Me");
    $router->post('', "Add");
    $router->delete('/{id:[0-9]+}', "Delete");
});

$router->group([
    'prefix' => 'auth',
    'namespace' => 'Auth',
], function () use ($router) {
    $router->post('validate', "ValidateUser");
});
