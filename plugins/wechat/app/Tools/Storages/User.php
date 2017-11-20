<?php

namespace Plugins\Wechat\App\Tools\Storages;

class User {

	public function __invoke($account_id = null)
	{
		if (is_null($account_id))
			return session('wechat.account_id', null);
		session([
			'wechat.account_id' => $account_id
		]);
		session()->save();
	}

}
