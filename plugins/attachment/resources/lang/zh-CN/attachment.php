<?php

return [
	'failure_notexists' => '该附件不存在，或者已被删除！',
	'failure_invalid_id' => '附件的ID错误，无此附件名。',
	'failure_file_notexists' => '该文件不存在，可能上传不完整、或者已被删除！',
	'success_upload' => '您的文件已经上传成功！',
	'success_download' => '您的文件已经下载成功！',
	'image_invalid' => '您的文件非图片类型，无法预览！',
	'watermark_invalid' => '水印文件有误。',
	'lost_filename' => '请输入需要保存的文件名。',
	'write_no_permission' => '请检查本地目录是否有写入权限。',
	'remote_no_permission' => '请检查远程目录是否有写入权限，或者检查远程服务器配置是否正确。',
	'remote_not_exists' => '远程文件不存在，无法同步。',
	'hash_not_exists' => '服务器并不存在此文件的Hash，无法秒传。',
	'url_invalid' => '请提供合法的URL地址',
	'download_no_response' => 'URL的服务器无响应，无法下载。',
	'ext_deny' => '不合法的文件类型，请上传/下载如下文件类型：:ext',
	'out_of_size' => '文件大小超出 :maxsize ！',
	'empty_file' => '文件内容不能为空！',
	'file_invalid' => '无效文件！',
	'lost_chunk' => '分块上传的文件不存在，或者没有读取权限，无法合并最终文件。',
	UPLOAD_ERR_OK => '文件上传成功。',
	UPLOAD_ERR_INI_SIZE => '上传的文件超过了 php.ini 中 upload_max_filesize ('.ini_get('upload_max_filesize').'B) 选项限制的值。 ',
	UPLOAD_ERR_FORM_SIZE => '上传文件的大小超过了 HTML 表单中 MAX_FILE_SIZE 选项指定的值。',
	UPLOAD_ERR_PARTIAL => '文件不完整，只有部分被上传。',
	UPLOAD_ERR_NO_FILE => '没有文件被上传。',
	UPLOAD_ERR_NO_TMP_DIR => '系统错误，找不到临时文件夹。',
	UPLOAD_ERR_CANT_WRITE => '系统错误，临时文件写入失败。',

];
