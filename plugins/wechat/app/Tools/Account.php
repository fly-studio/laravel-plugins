<?php
namespace Plugins\Wechat\App\Tools;

use Plugins\Wechat\App\Tools\API;
use Plugins\Wechat\App\Tools\User as WechatUserTool;
use Session;
class Account {

	public function getAccountID()
	{
		return Session::get('wechat-account-id', NULL);
	}

	public function setAccountID($accountid)
	{
		Session::put('wechat-account-id', $accountid);
		Session::save();
	}
}