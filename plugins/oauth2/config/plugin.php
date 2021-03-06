<?php

return [
	'enabled' => true,
	'namespace' => 'Plugins\\OAuth2',
	'register' => [
		'view' => true,
		'migrate' => true,
		'translator' => true,
		'router' => true,
		'censor' => true,
	],
	'configs' => [
		'oauth2',
	],
	'injectViews' => [
		'admin/sidebar.inc.tpl' => 9998,
	],
];
