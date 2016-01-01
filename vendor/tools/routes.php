<?php

$router->resource('manual', 'ManualController');
$router->addUnActionRoutes([
	'tools',
	'placeholder',
	'qr',
]);