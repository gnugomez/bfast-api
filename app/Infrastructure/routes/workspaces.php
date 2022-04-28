<?php

use Laravel\Lumen\Routing\Router;

/** @var Router $router */

$router->get('self', "GetSelf");

$router->group(
	[
		'prefix' => '{workspace_slug}',
	],
	function () use ($router) {
		$router->get('', "GetSingle");
	}
);

$router->group(
	[
		'prefix' => '{workspace:[0-9]+}',
		'middleware' => ['workspace_exist_in_organization'],
		'namespace' => 'Members',
	],
	function () use ($router) {
		$router->get('members', "GetAll");
	}
);

$router->group(
	[
		'middleware' => ['user_privileged_in_organization']
	],
	function () use ($router) {

		$router->post('', "Create");
		$router->get('', "GetAll");

		$router->group(
			[
				'prefix' => '{workspace:[0-9]+}',
				'middleware' => ['workspace_exist_in_organization'],
			],
			function () use ($router) {
				$router->delete('', "Delete");

				$router->group(
					[
						'namespace' => 'Members',
					],
					function () use ($router) {
						$router->put('members', "Add");
						$router->delete('members/{user_id:[0-9]+}', "Remove");
						$router->patch('members/{user_id:[0-9]+}', "UpdateRole");
					}
				);
			}
		);
	}
);
