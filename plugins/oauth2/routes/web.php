<?php

$router->group(['prefix' => 'api/oauth', 'namespace' => 'Api', 'middleware' => ['auth']], function($router) {

	$router->get('/authorize', [
		'uses' => 'AuthorizationController@authorize',
	]);

	$router->post('/authorize', [
		'uses' => 'ApproveAuthorizationController@approve',
	]);

	$router->delete('/authorize', [
		'uses' => 'DenyAuthorizationController@deny',
	]);

	$router->get('/tokens', [
		'uses' => 'AuthorizedAccessTokenController@forUser',
	]);

	$router->delete('/tokens/{token_id}', [
		'uses' => 'AuthorizedAccessTokenController@destroy',
	]);

	$router->post('/token/refresh', [
		'uses' => 'TransientTokenController@refresh',
	]);

	$router->get('/clients', [
		'uses' => 'ClientController@forUser',
	]);

	$router->post('/clients', [
		'uses' => 'ClientController@store',
	]);

	$router->put('/clients/{client_id}', [
		'uses' => 'ClientController@update',
	]);

	$router->delete('/clients/{client_id}', [
		'uses' => 'ClientController@destroy',
	]);

	$router->get('/scopes', [
		'uses' => 'ScopeController@all',
	]);

	$router->get('/personal-access-tokens', [
		'uses' => 'PersonalAccessTokenController@forUser',
	]);

	$router->post('/personal-access-tokens', [
		'uses' => 'PersonalAccessTokenController@store',
	]);

	$router->delete('/personal-access-tokens/{token_id}', [
		'uses' => 'PersonalAccessTokenController@destroy',
	]);

});


$router->group(['prefix' => 'admin/oauth', 'namespace' => 'Admin\\OAuth', 'middleware' => ['auth:admin', 'role:administrator']], function($router) {
	$router->crud([
		'client' => 'ClientController',
	]);
});
