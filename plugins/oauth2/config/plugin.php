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
		'config' => false,
	],
	'configs' => [
		'oauth2',
	],
];
