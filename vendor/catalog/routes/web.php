<?php

$router->group(['namespace' => 'Admin','prefix' => 'admin', 'middleware' => ['auth', 'role:super']], function($router) {
	
	$router->addAdminRoutes([
		'catalog' => 'CatalogController',
	]);

});
