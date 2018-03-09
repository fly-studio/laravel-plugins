<?php

$router->get('socialite/login/{nameOrId}', 'LoginController@index');

$router->get('socialite/feedback/{nameOrId}', 'FeedbackController@index');
