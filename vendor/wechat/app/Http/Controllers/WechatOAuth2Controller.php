<?php
namespace Plugins\Wechat\App\Http\Controllers;

use Addons\Core\Controllers\Controller;
use App\Role;
use Plugins\Wechat\App\WechatAccount;
use Plugins\Wechat\App\Tools\API;
use Plugins\Wechat\App\Tools\OAuth2;
use Plugins\Wechat\App\Tools\Js;
class WechatOAuth2Controller extends Controller {

	public $wechat_oauth2_account = NULL;
	public $wechat_oauth2_type = 'snsapi_base'; // snsapi_base  snsapi_userinfo  hybrid
	public $wechat_oauth2_bindUserRole = Role::WECHATER; // 将微信用户绑定到系统用户的用戶組，為空則不綁定

	protected $wechatUser = NULL;

	public function callAction($method, $parameters)
	{
		if (!empty($this->wechat_oauth2_account))
		{
			$account = WechatAccount::findOrFail($this->wechat_oauth2_account);
			$oauth2 = new OAuth2($account->toArray(), $account->getKey());

			$this->wechatUser = $oauth2->getUser();
			if (empty($this->wechatUser))
			{
				//ajax 请求则报错
				if (app('request')->ajax()) 
					return $this->failure('wechat::wechat.failure_ajax_oauth2');

				$this->wechatUser = $oauth2->authenticate(NULL, $this->wechat_oauth2_type, $this->wechat_oauth2_bindUserRole);
			}
			$userModel = config('auth.model');
			$this->wechat_oauth2_bindUserRole && $this->user = (new $userModel)->find($this->wechatUser->uid);
			$this->user = (new $userModel)->find(15);
		}

		return parent::callAction($method, $parameters);
	}

	public function getWechatUser()
	{
		return $this->wechatUser;
	}

	public function getJsParameters($url = NULL)
	{
		$account = WechatAccount::findOrFail($this->wechat_oauth2_account);
		$js = new Js($account->toArray(), $account->getKey());

		return $js->getConfig($url);
	}

}