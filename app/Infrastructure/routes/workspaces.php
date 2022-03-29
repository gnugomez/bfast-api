<?php

use Laravel\Lumen\Routing\Router;

/** @var Router $router */

$router->get('self', "GetSelf");

$router->group(
	[
		'middleware' => ['organization_owner']
	],
	function () use ($router) {

		$router->post('', "Create");
		$router->get('', "GetAll");

		$router->group(
			[
				'prefix' => '{workspace:[0-9]+}',
				'middleware' => ['workspace_exist'],
			],
			function () use ($router) {
				$router->delete('', "Delete");

				$router->group(
					[
						'namespace' => 'Members',
					],
					function () use ($router) {
						$router->get('members', "GetAll");
						$router->put('members', "Add");
					}
				);
			}
		);
	}
);
