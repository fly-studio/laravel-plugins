<?php

namespace Plugins\Wechat\App\Tools\Storages;

use Plugins\Wechat\App\Repositories\WechatUserRepository;

class User {

	public $account_id = null;

	public function __construct($account_id)
	{
		$this->account_id = $account_id;
	}

	public function wechatUser()
	{
		$wuid = $this->get();
		return empty($wuid) ? null : app(WechatUserRepository::class)->find($wuid);
	}

	public function forget()
	{
		return session()->forget('wechat.user.'.$this->account_id);
	}

	public function get()
	{
		return session('wechat.user.'.$this->account_id, null);
	}

	public function put($wuid)
	{
		session([
			'wechat.user.'.$this->account_id => $wuid
		]);
		session()->save();
	}

}
