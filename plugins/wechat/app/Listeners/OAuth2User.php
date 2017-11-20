<?php

namespace Plugins\Wechat\App\Listeners;

use Plugins\Wechat\App\Tools\Methods\User;
use Plugins\Wechat\App\Events\WeChatUserAuthorized;

class OAuth2User {

	public function handle(WeChatUserAuthorized $authorized)
	{
		$app = $authorized->getApp();

		//更新到系统
		$user = new User($app);
		$user->updateWechatUser();
	}

}
