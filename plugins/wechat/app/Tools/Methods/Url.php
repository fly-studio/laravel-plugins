<?php
namespace Plugins\Wechat\App\Tools\Methods;

use Plugins\Wechat\App\Tools\API;
use Plugins\Wechat\App\WechatUser;

class Url {

	private $api;

	public function __construct($options, $waid = NULL)
	{
		$this->api = $options instanceof API ? $options : new API($options, $waid);
	}

	public function getAPI()
	{
		return $this->api;
	}
	
	public function getURL($url, WechatUser $user = NULL)
	{
		return url('wechat').'?url='.rawurlencode($url).(!empty($user) ? '&wuid='.rawurlencode($user->getKey()) : '');
	}

}
