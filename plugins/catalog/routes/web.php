<?php

$router->group(['namespace' => 'Admin','prefix' => 'admin', 'middleware' => ['auth:admin', 'role:super']], function($router) {

	$router->match(['get', 'post'], 'catalog/{name}/data', 'CatalogController@tree');
	$router->put('catalog/move', 'CatalogController@move');
	$router->crud([
		'catalog' => 'CatalogController',
	]);

});
