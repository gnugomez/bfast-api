<?php

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
    require __DIR__ . '/users.php';
});

$router->group(
    [
        'prefix' => 'organizations',
        'namespace' => 'Organization',
        'middleware' => 'auth'
    ],

    function () use ($router) {
        require __DIR__ . '/organizations.php';
    }
);

$router->group(
    [
        'prefix' => 'organizations/{organization:[0-9]+}/workspaces',
        'namespace' => 'Workspace',
        'middleware' => 'auth'
    ],
    function () use ($router) {
        require __DIR__ . '/workspaces.php';
    }
);
