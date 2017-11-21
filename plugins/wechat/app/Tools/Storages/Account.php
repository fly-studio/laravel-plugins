<?php

namespace Plugins\Wechat\App\Tools\Storages;

use Plugins\Wechat\App\Repositories\WechatAccountRepository;

class Account {

	public function wechatAccount()
	{
		$account_id = $this->__invoke();
		return empty($account_id) ? null : app(WechatAccountRepository::class)->find($account_id);
	}

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
