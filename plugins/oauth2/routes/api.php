<?php

$router->group(['prefix' => 'oauth', 'namespace' => 'Api'], function($router) {

	$router->post('token', [
		'uses' => 'AccessTokenController@issueToken',
	]);

});
