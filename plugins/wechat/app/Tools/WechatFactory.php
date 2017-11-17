<?php

namespace Plugins\Wechat\App\Tools;

use Plugins\Wechat\App\WechatAccount;

class WechatFactory {

	private $wechatAccount;

	public function __construct($waid)
	{
		!empty($waid) && $this->wechatAccount = WechatAccount::findOrFail($waid);
	}

	public function make($method, ...$args)
	{
		return $this->{$method}(...$args);
	}

	public function account($account = null)
	{
		if (is_null($account)) return $this->wechatAccount;
		$this->wechatAccount = $account;
		return $this;
	}

	public function accountSession($account_id = null)
	{
		$invoke = new Methods\AccountSession();
		return $invoke($account_id);
	}

	public function user()
	{
		return new Methods\User($this->account);
	}




}
