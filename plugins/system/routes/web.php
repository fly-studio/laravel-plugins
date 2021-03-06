<?php

$router->group(['namespace' => 'Admin','prefix' => 'admin', 'middleware' => ['auth:admin', 'role:administrator.**']], function($router) {

	$router->crud([
		'password' => 'PasswordController',
		'profile' => 'ProfileController',
	]);

	$router->group(['middleware' => ['auth:admin', 'role:administrator.**']], function($router) {

		$router->get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
		$router->crud([
			'role' => 'RoleController',
			'permission' => 'PermissionController',
		]);

	});

});
