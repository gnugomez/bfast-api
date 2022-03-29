<?php

use Laravel\Lumen\Routing\Router;

/** @var Router $router */

$router->post('', "Create");
$router->get('', "GetAll");

$router->group(
	[
		'prefix' => '{organization:[0-9]+}',
		'middleware' => ['organization_exist', 'organization_owner']
	],
	function () use ($router) {

		$router->delete('', "Delete");

		$router->group(
			[
				'prefix' => 'members',
				'namespace' => 'Members',
			],
			function () use ($router) {
				$router->get('', "GetAll");
				$router->put('', "Add");
			}
		);
	}
);
