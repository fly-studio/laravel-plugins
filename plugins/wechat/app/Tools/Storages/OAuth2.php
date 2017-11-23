<?php

namespace Plugins\Wechat\App\Tools\Storages;

use Overtrue\Socialite\User;

class OAuth2 {

	public $account_id = null;

	public function __construct($account_id)
	{
		$this->account_id = $account_id;
	}

	public function forget()
	{
		return session()->forget('wechat.oauth2.'.$this->account_id);
	}

	public function get()
	{
		return session('wechat.oauth2.'.$this->account_id, null);
	}

	public function put(User $user)
	{
		session([
			'wechat.oauth2.'.$this->account_id => $user
		]);
		session()->save();
	}
}
