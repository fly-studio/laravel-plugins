<?php

$router->group(['namespace' => 'Admin','prefix' => 'admin', 'middleware' => ['auth', 'role:admin,manager,owner,leader']], function($router) {
	
	$router->addAdminRoutes([
		'wechat/account' => 'Wechat\\AccountController',
	]);

	$router->group(['namespace' => 'Wechat', 'prefix' => 'wechat', 'middleware' => 'wechat.account'], function($router) {
		$router->post('menu/read-json','MenuController@readJson');
		$router->post('menu/publish-json','MenuController@publishJson');
		$router->post('menu/publish-query','MenuController@publishQuery');
		$router->post('menu/delete-all','MenuController@deleteAll');
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
