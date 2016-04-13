<?php

$router->group(['namespace' => 'Admin','prefix' => 'admin', 'middleware' => ['auth', 'role:admin|manager|owner|leader']], function($router) {
	
	$router->addAdminRoutes([
		'wechat/account' => 'Wechat\\AccountController',
	]);

	$router->group(['namespace' => 'Wechat', 'prefix' => 'wechat', 'middleware' => 'wechat.account'], function($router) {
	    $router->post('menu/publish-query','MenuController@publishQuery');
		$router->addAdminRoutes([
			'user' => 'UserController',
			'depot' => 'DepotController',
			'depot-news' => 'DepotNewsController',
			'menu' => 'MenuController',
			'message' => 'MessageController',
			'reply' => 'ReplyController',
			'statement' => 'StatementController',
		]);
	});
});
