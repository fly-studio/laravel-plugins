<?php

$router->resource('manual', 'ManualController');
$router->addUnActionRoutes([
	'tools' => NULL,
	'placeholder' => NULL,
	'qr' => NULL,
]);