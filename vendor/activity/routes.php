<?php
$router->group(['namespace' => 'Admin','prefix' => 'admin', 'middleware' => ['auth', 'role:admin|manager|owner|leader']], function($router) {
    $router->get('activity/setShelves/{id}/{status}','ActivityController@setShelves');
    $router->post('activity/getTypeHtml','ActivityController@getTypeHtml');
    $router->addAdminRoutes([
         'activity' => 'ActivityController',
		 'activity-type' => 'ActivityTypeController'
    ]);
});


$router->group(['namespace' => 'Factory','prefix' => 'factory', 'middleware' => ['auth', 'role:factory']], function($router) {
    $router->get('activity/setShelves/{id}/{status}','ActivityController@setShelves');
    $router->post('activity/getTypeHtml','ActivityController@getTypeHtml');
    $router->addAdminRoutes([
        'activity' => 'ActivityController',
        'activity-type' => 'ActivityTypeController'
    ]);
});


$router->group(['namespace' => 'M','prefix' => 'm'], function($router) {
    $router->get('special/{activity_id}','ActivityController@special');
    $router->get('discount','ActivityController@discount');
});