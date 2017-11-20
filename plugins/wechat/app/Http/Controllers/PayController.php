<?php
namespace Plugins\Wechat\App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Plugins\Wechat\App\WechatAccount;
use Plugins\Wechat\App\Tools\API;
use Plugins\Wechat\App\Tools\Pay;
use Plugins\Wechat\App\Tools\Js;
use Plugins\Wechat\App\Tools\Pay\UnifiedOrder;

class PayController extends Controller
{

	public function __construct()
	{
		$this->middleware('wechat.oauth2:1');
	}


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
