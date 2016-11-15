<?php

$router->resource('manual', 'ManualController');
$router->addAnyActionRoutes([
	'tools',
	'placeholder',
	'qr',
	'loading',
]);
$router->get('artisans', 'ArtisansController@index');
$router->group(['middleware' => 'local'], function($router){
	$router->addAnyActionRoutes([
		'artisans',
		'install',
		'database',
	]);
});