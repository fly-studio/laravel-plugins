<?php

namespace Plugins\Wechat\App\Tools\Storages;

class OAuth2 {

	public function __invoke($account_id = null, $user = null)
	{
		if (is_null($user))
			return session('wechat.oauth2.'.$account_id, null);
		if ($user === false)
			return session()->forget('wechat.oauth2.'.$account_id);
		session([
			'wechat.oauth2.'.$account_id => $user
		]);
		session()->save();
	}

}
