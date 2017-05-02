<?php
namespace Plugins\Wechat\App\Http\Controllers;

use Illuminate\Http\Request;
use Plugins\Wechat\App\Http\Controllers\WechatOAuth2Controller;
use Plugins\Wechat\App\WechatAccount;
use Plugins\Wechat\App\Tools\API;
use Plugins\Wechat\App\Tools\Pay;
use Plugins\Wechat\App\Tools\Js;
use Plugins\Wechat\App\Tools\Pay\UnifiedOrder;

class PayController extends WechatOAuth2Controller
{
	public $wechat_oauth2_account = 1;
	public $wechat_oauth2_type = 'snsapi_base'; // snsapi_base  snsapi_userinfo  hybrid
	public $wechat_oauth2_bindUserRole = null; // 将微信用户绑定到系统用户的用戶組，為空則不綁定

	public function test(Request $request)
	{
		$wechatUser = $this->getWechatUser();
		$account = WechatAccount::findOrFail($this->wechat_oauth2_account);
		$api = new API($account->toArray(), $account->getKey());

		$pay = new Pay($api);
		$order = (new UnifiedOrder('JSAPI', date('YmdHis'), '买1分钱的单', 1))->SetNotify_url(url('wechat/feedback/'.$account->getKey()))->SetOpenid($wechatUser->openid);
		$UnifiedOrderResult = $pay->unifiedOrder($order);
		$js = new Js($api);
		$this->_parameters = $js->getPayParameters($UnifiedOrderResult);
		return $this->view('wechat::pay.test');
	}

}
