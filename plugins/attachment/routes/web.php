<?php

$router->group(['prefix' => 'attachment'], function($router) {
	$ctrl = 'AttachmentController';
	$idPattern = '[a-zA-z0-9_\-]{2,}';
	$filePatern = '[^\"\#\%\*\:\<\>\?\|\/\\\\]+';
	$intPattern = '[0-9]+';
	$extPattern = '\.(jpg|jpeg|png|gif|bmp|webp|svg)';
	$router->get('download/{id}{ext?}', $ctrl.'@download')->where(['id' => $idPattern, 'ext' => '\.'.$filePatern]);
	$router->get('preview/{id}{ext?}', $ctrl.'@preview')->where(['id' => $idPattern, 'ext' => $extPattern])->name('attachment-resize');
	$router->get('phone/{id}{ext?}', $ctrl.'@phone')->where(['id' => $idPattern, 'ext' => $extPattern]);
	$router->get('ueditor', $ctrl.'@ueditorQuery');
	$router->get('{id}/{width}x{height}{ext?}', $ctrl.'@resize')->where(['width' => $intPattern, 'height' => $intPattern, 'id' => $idPattern, 'ext' => $extPattern])->name('attachment-resize');
	$router->get('{id}~{watermark}{ext?}', $ctrl.'@watermark')->where(['watermark' => $idPattern, 'id' => $idPattern, 'ext' => $extPattern])->name('attachment-watermark');
	$router->get('{id}~{watermark}/{width}x{height}{ext?}', $ctrl.'@watermark')->where(['width' => $intPattern, 'height' => $intPattern, 'watermark' => $idPattern, 'id' => $idPattern, 'ext' => $extPattern])->name('attachment-watermark-resize');
	$router->get('{id}/{filename?}', $ctrl.'@show')->where(['filename' => '.+', 'id' => $idPattern])->name('attachment');
	$router->put('hash', $ctrl.'@hashQuery');
	$router->post('temp', $ctrl.'@tempQuery');
	$router->post('uploader', $ctrl.'@uploaderQuery');
	$router->post('dataurl', $ctrl.'@dataurlQuery');
	$router->post('editormd', $ctrl.'@editormdQuery');
	$router->post('ueditor', $ctrl.'@ueditorQuery');
	$router->post('kindeditor', $ctrl.'@kindeditorQuery');
	$router->post('fullavatar', $ctrl.'@fullavatarQuery');
	$router->get('/', $ctrl.'@index');
});
