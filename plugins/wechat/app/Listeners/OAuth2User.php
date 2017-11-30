<?php

namespace Plugins\Wechat\App\Listeners;

use Plugins\Wechat\App\Tools;
use Plugins\Wechat\App\Tools\Methods\User;
use Plugins\Wechat\App\Events\WeChatUserAuthorized;

class OAuth2User {

	public function handle(WeChatUserAuthorized $authorized)
	{
		$app = $authorized->getApp();
		$waid = $app['config']->get('id');

		//更新到系统
		$user = new User($app);
		$wuid = $user->updateWechatUser($authorized->getUser());
		Tools\user_storage($waid, $wuid); //storage to session
	}

}
