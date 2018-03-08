<?php

$router->get('socialite/login/{name}', 'LoginController@index');

$router->get('socialite/callback/{name}', 'FeedbackController@index');
