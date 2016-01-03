<?php

$router->resource('manual', 'ManualController');
$router->addAnyActionRoutes([
	'tools',
	'placeholder',
	'qr',
]);