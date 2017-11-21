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
		$wuid = $this->__invoke();
		return empty($wuid) ? null : app(WechatUserRepository::class)->find($wuid);
	}

	public function __invoke($wuid = null)
	{
		if (is_null($wuid))
			return session('wechat.user.'.$this->account_id, null);
		if ($wuid === false)
			return session()->forget('wechat.user.'.$this->account_id);
		session([
			'wechat.user.'.$this->account_id => $wuid
		]);
		session()->save();
	}

}
