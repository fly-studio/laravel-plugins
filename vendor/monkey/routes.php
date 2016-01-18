<?php
$router->group(['namespace' => 'Admin','prefix' => 'admin', 'middleware' => ['auth', 'role:admin|manager|owner|leader']], function($router) {
    $router->addAdminRoutes([
         'activity-bonus' => 'ActivityBonusController',
    ]);
});


$router->group(['namespace' => 'Factory','prefix' => 'factory', 'middleware' => ['auth', 'role:factory']], function($router) {
    $router->addAdminRoutes([
        'activity-bonus' => 'ActivityBonusController'
    ]);
});


$router->group(['namespace' => 'M','prefix' => 'm'], function($router) {
    $router->get('game','GameController@index');
    $router->any('game/save_score','GameController@saveScore');
});