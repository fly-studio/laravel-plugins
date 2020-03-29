<?php

return [
	'key' => 'a random bytes', //上线时需要设置，只能设置一次，如果已经上线之后再修改，会导致所有附件的对外ID，也就是URL全被改变，后果非常严重
	'remote' => [
		'driver' => 'null', // string: null, SSH

		'SSH' => [
			'host' => 'SSH\'s ip', //ip only
			//'host_fingerprint' => null,
			'port' => 22,
			'authentication_method' => 'PASS', //PASS KEY
			'user' => null, //set it if authentication_method == 'PASS'
			'password' => null, //set it if authentication_method == 'PASS'
			//'pub_key' => null, //set it if authentication_method == 'KEY'
			//'private_key' => null, //set it if authentication_method == 'KEY'
			//'passphrase' => null, //set it if authentication_method == 'KEY'
			'auto_connect' => true,
			'path' => '/path/to/attachments/', //远程存放的路径
			'file_own' => null, //文件所属用户，比如：nobody
			'file_grp' => null, //文件所属组，比如：nobody
			'file_mod' => 0644, //文件的权限
			'folder_own' => null, //文件夹所属用户，比如：nobody
			'folder_grp' => null, //文件夹所属组，比如：nobody
			'folder_mod' => 0777, //文件夹的权限，一般情况下必须要777
		],
	],
	'local' => [
		'enabled' => true,
		'life_time' => 0, //enabled为true时无效，0表示永不过期，
		'path' => public_path(env('ATTACHMENT_PATH', 'attachments')), //本地存放路径，必须放在public目录下
		'file_own' => null, //文件所属用户，比如：nobody
		'file_grp' => null, //文件所属组，比如：nobody
		'file_mod' => 0644,
		'folder_own' => null, //文件夹所属用户，比如：nobody
		'folder_grp' => null, //文件夹所属组，比如：nobody
		'folder_mod' => 0777, //文件夹的权限，一般情况下必须要777
	],
	'ext' => [
		'mp4','m4v','mov','tp','ts','mkv','webm','rmvb','rm','asf','mpeg','mpg','avi',
		'midi','mid','wmv','wma','wav','mp3','amr','ogg','weba', 'aac',
		'f4v','flv','swf',
		'bz2','gz','7z','rar','zip',
		'pptx','ppt','xslx','xsl','csv','docx','doc','pdf',
		'gif','png','bmp','jpeg','jpg','svg', 'svga','webp'
	],
	'maxsize' => 1024 * 1024 * 100,  //最大上传 100M
	'write_cache' => 1024 * 512, //分块写入缓存 512K
	'saved_ext' => '.gf',
	'file_type' => [
		'text' => [
			'php','php5','phps',
			'html','htm','shtm','shtml','tpl',
			'htaccess',
			'js','vbs',
			'css','less','cass',
			'asp','aspx',
			'c','cpp','cs',
			'h','hpp',
			'sql',
			'txt','text',
			'log',
			'cache',
		],
		'image' => [
			'jpg','jpeg',
			'bmp',
			'gif',
			'png',
			'webp',
			'svg', 'svga'
		],
		'video' => [
			'mov',
			'tp','ts',
			'mkv',
			'webm',
			'mp4','m4v','mpeg','mpg',
			'wmv',
			'avi',
			'rm','rmvb',
			'asf',
			'f4v','flv',
			'swf',
		],
		'audio' => [
			'mp3',
			'ogg', 'aac',
			'wma',
			'amr',
			'mid','midi',
			'weba',
		],
		'archive' => [
			'7z','001','002','003','004','005',
			'rar',
			'zip','bz2','gz','tar'
		],
		'document' => [
			'pptx','ppt',
			'xslx','xsl','csv', 'tsv',
			'docx','doc',
			'pdf',
		],
	],
];
