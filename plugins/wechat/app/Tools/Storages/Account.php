<?php

namespace Plugins\Wechat\App\Tools\Storages;

use Plugins\Wechat\App\Repositories\WechatAccountRepository;

class Account {

	public function wechatAccount()
	{
		$account_id = $this->get();
		return empty($account_id) ? null : app(WechatAccountRepository::class)->find($account_id);
	}

	public function forget()
	{
		return session()->forget('wechat.account_id');
	}

	public function get()
	{
		return session('wechat.account_id', null);
	}

	public function put($account_id)
	{
		session([
			'wechat.account_id' => $account_id
		]);
		session()->save();
	}

}
