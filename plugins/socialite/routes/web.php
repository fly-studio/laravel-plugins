<?php

$router->get('socialite/login/{id}', 'LoginController@index');

$router->get('socialite/feedback/{id}', 'FeedbackController@index');

$router->group(['prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth:admin', 'role:administrator.**']], function($router) {
	$router->crud([
		'socialite' => 'SocialiteController',
	]);
});
