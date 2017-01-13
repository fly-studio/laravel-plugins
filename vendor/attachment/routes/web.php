<?php
use Illuminate\Http\Request;

$router->get('attachment/{id}/{filename}', function(Request $request, $id, $filename){
	$className = 'Plugins\\Attachment\\App\\Http\\Controllers\\AttachmentController';
	$obj = app()->make($className);
	$request = app('request');
	return $obj->callAction('index', [ $request, $id, $request->input('width'), $request->input('height'), $request->input('m') ]);
});

$router->addAnyActionRoutes([
	'attachment',
]);