<?php

$router->group(['namespace' => 'Admin','prefix' => 'admin', 'middleware' => ['auth', 'role:administrator']], function($router) {
	
	$router->addAdminRoutes([
		'role' => 'RoleController',
		'permission' => 'PermissionController',
		'password' => 'PasswordController',
		'profile' => 'ProfileController',
		//'field' => 'FieldController',
	]);


});
