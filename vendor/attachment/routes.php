<?php

$router->get('attachment/{id}/{filename}', function($id, $filename){
	$className = 'Plugins\\Attachment\\App\\Http\\Controllers\\AttachmentController';
	$obj = app()->make($className);
	$request = app('request');
	return $obj->callAction('index', [ $id, $request->input('width'), $request->input('height'), $request->input('m') ]);
});

$router->addAnyActionRoutes([
	'attachment',
]);