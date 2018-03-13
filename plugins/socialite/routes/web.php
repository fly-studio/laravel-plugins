<?php

$router->get('socialite/login/{id}', 'LoginController@index');

$router->get('socialite/feedback/{id}', 'FeedbackController@index');
