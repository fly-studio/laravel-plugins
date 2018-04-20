<?php

$router->group(['namespace' => 'Admin','prefix' => 'admin', 'middleware' => ['auth:admin', 'role:administrator.**']], function($router) {

	$router->crud([
		'wechat/account' => 'Wechat\\AccountController',
	]);

	$router->group(['namespace' => 'Wechat', 'prefix' => 'wechat', 'middleware' => 'wechat.account'], function($router) {
		$router->post('menu/read-json','MenuController@readJson');
		$router->post('menu/publish-json','MenuController@publishJson');
		$router->post('menu/publish-query','MenuController@publishQuery');
		$router->post('menu/delete-all','MenuController@deleteAll');
		$router->crud([
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
$router->get('wechat/test', 'PayController@test');

$ctrl = '\App\Http\Controllers\WechatController';
$router->post('wechat/feedback/{aid}/{oid?}', $ctrl.'@feedback');
$router->get('wechat', $ctrl.'@index');
$router->get('wechat/news', $ctrl.'@news');
$router->post('wechat/push', $ctrl.'@push');
$router->get('wechat/auth', $ctrl.'@auth');
$router->post('wechat/choose-query', $ctrl.'@chooseQuery');
$router->get('wechat/modifing-account', $ctrl.'@modifingAccount');
