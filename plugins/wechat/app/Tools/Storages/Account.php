<?php

namespace Plugins\Wechat\App\Tools\Storages;

class Account {

	public function __invoke($account_id = null)
	{
		if (is_null($account_id))
			return session('wechat.account_id', null);
		if ($user === false)
			return session()->forget('wechat.account_id');
		session([
			'wechat.account_id' => $account_id
		]);
		session()->save();
	}

}
