<?php

$router->get('attachment/{id}/{filename}', function($id, $filename){
	$className = 'Plugins\\Attachment\\App\\Http\\Controllers\\AttachmentController';
	$obj = app()->make($className);
	return $obj->callAction('index', [$id]);
});

$router->addAnyActionRoutes([
	'attachment',
]);