<?php

namespace Plugins\Wechat\App\Tools\Storages;

class OAuth2 {

	public $account_id = null;

	public function __construct($account_id)
	{
		$this->account_id = $account_id;
	}

	public function __invoke($user = null)
	{
		if (is_null($user))
			return session('wechat.oauth2.'.$this->account_id, null);
		if ($user === false)
			return session()->forget('wechat.oauth2.'.$this->account_id);
		session([
			'wechat.oauth2.'.$this->account_id => $user
		]);
		session()->save();
	}

}
