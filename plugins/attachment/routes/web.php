<?php

$router->group(['prefix' => 'attachment'], function($router) {
	$ctrl = 'AttachmentController';$pattern = '[a-zA-z0-9_\-]+';
	$router->get('download/{id}', $ctrl.'@download')->where('id', $pattern);
	$router->get('preview/{id}', $ctrl.'@preview')->where('id', $pattern);
	$router->get('phone/{id}', $ctrl.'@phone')->where('id', $pattern);
	$router->get('ueditor', $ctrl.'@ueditorQuery');
	$router->get('{id}/{width}x{height}', $ctrl.'@resize')->where(['width' => '[0-9]+', 'height' => '[0-9]+', 'id' => $pattern])->name('attachment-resize');
	$router->get('{id}~{watermark}', $ctrl.'@watermark')->where(['watermark' => $pattern, 'id' => $pattern])->name('attachment-watermark');
	$router->get('{id}~{watermark}/{width}x{height}', $ctrl.'@watermark')->where(['width' => '[0-9]+', 'height' => '[0-9]+', 'watermark' => $pattern, 'id' => $pattern])->name('attachment-watermark-resize');
	$router->get('{id}/{filename?}', $ctrl.'@show')->where(['filename' => '.+', 'id' => $pattern])->name('attachment');
	$router->put('hash', $ctrl.'@hashQuery');
	$router->post('uploader', $ctrl.'@uploaderQuery');
	$router->post('dataurl', $ctrl.'@dataurlQuery');
	$router->post('editormd', $ctrl.'@editormdQuery');
	$router->post('ueditor', $ctrl.'@ueditorQuery');
	$router->post('kindeditor', $ctrl.'@kindeditorQuery');
	$router->post('fullavatar', $ctrl.'@fullavatarQuery');
	$router->get('/', $ctrl.'@index');
});