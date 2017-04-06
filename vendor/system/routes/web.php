<?php

$router->group(['namespace' => 'Admin','prefix' => 'admin', 'middleware' => ['auth', 'role:administrator']], function($router) {
	
	$router->crud([
		'password' => 'PasswordController',
		'profile' => 'ProfileController',
	]);

	$router->group(['middleware' => ['auth', 'role:super']], function($router) {

		$router->get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
		$router->crud([
			'role' => 'RoleController',
			'permission' => 'PermissionController',
		]);
		
	});

});
