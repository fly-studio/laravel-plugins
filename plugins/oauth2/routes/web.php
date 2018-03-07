<?php

$router->group(['prefix' => 'api/oauth', 'namespace' => 'Api'], function($router) {
    $router->group(['middleware' => ['web', 'auth']], function ($router) {
        $router->get('/authorize', [
            'uses' => 'AuthorizationController@authorize',
        ]);

        $router->post('/authorize', [
            'uses' => 'ApproveAuthorizationController@approve',
        ]);

        $router->delete('/authorize', [
            'uses' => 'DenyAuthorizationController@deny',
        ]);
    });

    $router->post('/token', [
        'uses' => 'AccessTokenController@issueToken',
        'middleware' => 'throttle',
    ]);

    $router->group(['middleware' => ['web', 'auth']], function ($router) {
        $router->get('/tokens', [
            'uses' => 'AuthorizedAccessTokenController@forUser',
        ]);

        $router->delete('/tokens/{token_id}', [
            'uses' => 'AuthorizedAccessTokenController@destroy',
        ]);
    });

    $router->post('/token/refresh', [
        'middleware' => ['web', 'auth'],
        'uses' => 'TransientTokenController@refresh',
    ]);

    $router->group(['middleware' => ['web', 'auth']], function ($router) {
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
    });

    $router->group(['middleware' => ['web', 'auth']], function ($router) {
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

});
