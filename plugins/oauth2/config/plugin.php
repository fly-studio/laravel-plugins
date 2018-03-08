<?php

return [
	'enabled' => true,
	'namespace' => 'Plugins\\OAuth2',
	'register' => [
		'view' => true,
		'migrate' => false,
		'translator' => true,
		'router' => true,
		'censor' => false,
	],
	'configs' => [
		'oauth2',
	],
];
