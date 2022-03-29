<?php

use Laravel\Lumen\Routing\Router;

/** @var Router $router */

$router->put('', "Create");

$router->group([
	'middleware' => 'auth'
], function () use ($router) {
	$router->get('', "GetAll");
	$router->get('me', "Me");
	$router->delete('/{id:[0-9]+}', "Delete");
});
