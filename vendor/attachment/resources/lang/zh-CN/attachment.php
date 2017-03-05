<?php
use Plugins\Attachment\App\Attachment;
return [
	'failure_notexists' => [
		'title' => '附件不存在',
		'content' => '该附件不存在，或者已被删除！',
	],
	'failure_file_notexists' => [
		'title' => '文件不存在',
		'content' => '该文件不存在，可能上传不完整、或者已被删除！',
	],
	'success_upload' => [
		'title' => '上传成功',
		'content' => '您的文件已经上传成功！',
	],
	'success_download' => [
		'title' => '下载成功',
		'content' => '您的文件已经下载成功！',
	],
	'image_invalid' => [
		'title' => '无法预览',
		'content' => '您的文件非图片类型，无法预览！',
	],
	'watermark_invalid' => [
		'title' => '无法预览',
		'content' => '水印文件有误。',
	],
	'lost_filename' => [
		'title' => '附件名错误',
		'content' => '请输入需要保存的文件名。',
	],
	'write_no_permission' => [
		'title' => '保存文件失败',
		'content' => '请检查本地目录是否有写入权限。',
	],
	'remote_no_permission' => [
		'title' => '保存远程文件失败',
		'content' => '请检查远程目录是否有写入权限，或者检查远程服务器配置是否正确。',
	],
	'remote_not_exists' => [
		'title' => '文件不存在',
		'content' => '远程文件不存在，无法同步。',
	],
	'hash_not_exists' => [
		'title' => 'Hash不存在',
		'content' => '服务器并不存在此文件的Hash，无法秒传。',
	],
	'url_invalid' => [
		'title' => '下载失败',
		'content' => '请提供合法的URL地址',
	],
	'download_no_response' => [
		'title' => '下载失败',
		'content' => 'URL的服务器无响应，无法下载。',
	],
	'ext_deny' => [
		'title' => '传输失败',
		'content' => '不合法的文件类型，请上传/下载如下文件类型：:ext',
	],
	'out_of_size' => [
		'title' => '传输失败',
		'content' => '文件大小超出 :maxsize ！',
	],
	'empty_file' => [
		'title' => '传输失败',
		'content' => '文件内容不能为空！',
	],
	'file_invalid' => [
		'title' => '传输失败',
		'content' => '无效文件！',
	],
	'lost_chunk' => [
		'title' => '分块文件丢失',
		'content' => '分块上传的文件不存在，或者没有读取权限，无法合并最终文件。'
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

];