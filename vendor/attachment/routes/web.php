<?php
use Illuminate\Http\Request;
use Plugins\Attachment\App\Exceptions\AttachmentException;

$router->group(['prefix' => 'attachment'], function($router) {
	$ctrl = 'AttachmentController';
	$router->get('download/{id}', $ctrl.'@download');
	$router->get('preview/{id}', $ctrl.'@preview');
	$router->get('phone/{id}', $ctrl.'@phone');
	$router->get('{id}/{width}x{height}', $ctrl.'@resize')->where(['width' => '[0-9]+', 'height' => '[0-9]+'])->name('attachment-resize');
	$router->get('{id}/{watermark}', $ctrl.'@watermark')->where('watermark', '[0-9]+')->name('attachment-watermark');
	$router->get('{id}/{watermark}/{width}x{height}', $ctrl.'@watermark')->where('watermark', '[0-9]+')->name('attachment-watermark-resize');
	$router->get('{id}/{filename?}', $ctrl.'@show')->where('filename', '[[:ascii:]]+')->name('attachment');
	$router->put('hash', $ctrl.'@hashQuery');
	$router->post('uploader', $ctrl.'@uploaderQuery');
	$router->post('dataurl', $ctrl.'@dataurlQuery');
	$router->post('editormd', $ctrl.'@editormdQuery');
	$router->post('ueditor', $ctrl.'@ueditorQuery');
	$router->post('kindeditor', $ctrl.'@kindeditorQuery');
	$router->post('fullavatar', $ctrl.'@fullavatarQuery');
});

$router->get('attachment', function(Request $request) {
	if (!$request->offsetExists('id'))
		throw (new AttachmentException('attachment::attachment.failure_notexists'))->setStatusCode(404);
	$route = 'attachment';
	$parameters = ['id' => $request->query('id')];
	if ($request->offsetExists('m'))
	{
		$route .= '-watermark';
		$parameters += [
			'watermark' => $request->query('m'),
		];
	}
	if ($request->offsetExists('width') || $request->offsetExists('height'))
	{
		$route .= '-resize';
		$parameters += [
			'width' => intval($request->query('width')),
			'height' => intval($request->query('height')),
		];
	}
	$url = url()->route($route, $parameters);
	return redirect($url);
});