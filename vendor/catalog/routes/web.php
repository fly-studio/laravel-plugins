<?php

$router->group(['namespace' => 'Admin','prefix' => 'admin', 'middleware' => ['auth', 'role:super']], function($router) {
	
	$router->put('catalog/move', 'CatalogController@move');
	$router->crud([
		'catalog' => 'CatalogController',
	]);

});
