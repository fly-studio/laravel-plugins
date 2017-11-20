<?php
namespace Plugins\Wechat\App\Tools\Methods;

use Plugins\Wechat\App\Tools\API;
use Plugins\Wechat\App\WechatUser;

class Url {

	private $app;

	public function __construct()
	{

	}


	public function getURL($url, WechatUser $user = NULL)
	{
		return url('wechat').'?url='.rawurlencode($url).(!empty($user) ? '&wuid='.rawurlencode($user->getKey()) : '');
	}

}
