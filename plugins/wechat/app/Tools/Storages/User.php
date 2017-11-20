<?php

namespace Plugins\Wechat\App\Tools\Storages;

class User {

	public function __invoke($account_id = null, $user = null)
	{
		if (is_null($user))
			return session('wechat.user.'.$account_id, null);
		if ($user === false)
			return session()->forget('wechat.user.'.$account_id);
		session([
			'wechat.user.'.$account_id => $user
		]);
		session()->save();
	}

}