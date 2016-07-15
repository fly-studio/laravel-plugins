<?php
use Plugins\Attachment\App\Attachment;
return [
	'failure_noexists' => [
		'title' => '附件不存在',
		'content' => '该附件不存在，或者已被删除！',
	],
	'success_upload' => [
		'title' => '上传成功',
		'content' => '您的文件已经上传成功！',
	],
	'success_download' => [
		'title' => '下载成功',
		'content' => '您的文件已经下载成功！',
	],
	'failure_image' => [
		'title' => '无法预览',
		'content' => '您的文件非图片类型，无法预览！',
	],
	'failure_watermark' => [
		'title' => '无法预览',
		'content' => '水印文件有误。',
	],
	UPLOAD_ERR_OK => [
		'title' => '上传成功',
		'content' => '文件上传成功。',
	],
	UPLOAD_ERR_INI_SIZE => [
		'title' => '上传失败',
		'content' => '上传的文件超过了 php.ini 中 upload_max_filesize ('.ini_get('upload_max_filesize').'B) 选项限制的值。 ',
	],
	UPLOAD_ERR_FORM_SIZE => [
		'title' => '上传失败',
		'content' => '上传文件的大小超过了 HTML 表单中 MAX_FILE_SIZE 选项指定的值。',
	],
	UPLOAD_ERR_PARTIAL => [
		'title' => '上传失败',
		'content' => '文件不完整，只有部分被上传。',
	],
	UPLOAD_ERR_NO_FILE => [
		'title' => '上传失败',
		'content' => '没有文件被上传。',
	],
	UPLOAD_ERR_NO_TMP_DIR => [
		'title' => '上传失败',
		'content' => '系统错误，找不到临时文件夹。',
	],
	UPLOAD_ERR_CANT_WRITE => [
		'title' => '上传失败',
		'content' => '系统错误，临时文件写入失败。',
	],
	Attachment::UPLOAD_ERR_MAXSIZE => [
		'title' => '上传/下载失败',
		'content' => '文件大小超出:maxsize字节！',
	],
	Attachment::UPLOAD_ERR_EMPTY => [
		'title' => '上传/下载失败',
		'content' => '文件不能为空！',
	],
	Attachment::UPLOAD_ERR_EXT => [
		'title' => '上传/下载失败',
		'content' => '不合法的文件类型，请上传/下载常规的文件，以下是允许的文件类型：:ext',
	],
	Attachment::UPLOAD_ERR_SAVE => [
		'title' => '保存文件失败',
		'content' => '请检查目录是否有写入权限，或者检查远程服务器配置是否正确。',
	],
	Attachment::DOWNLOAD_ERR_URL => [
		'title' => '下载失败',
		'content' => '下载的URL无效。',
	],
	Attachment::DOWNLOAD_ERR_FILE => [
		'title' => '下载失败',
		'content' => '服务器无响应，无法下载此URL。',
	],
];