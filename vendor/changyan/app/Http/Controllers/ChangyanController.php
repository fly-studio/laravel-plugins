<?php
namespace Plugins\Changyan\App\Http\Controllers;

use Addons\Core\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
class ChangyanController extends Controller {

	private function getSign($data)
	{
		$appkey = config('changyan.app_key');
		$str = [];
		foreach($data as $k => $v)
			$str[] = $k . '=' . urldecode($v);
		$hmac = hash_hmac("sha1", implode('&', $str), $appkey, true);//dd(implode('&', $str), config('changyan.app_key'), urldecode($sign), base64_encode($hmac));
		return base64_encode($hmac);
	}

	public function userInfo(Request $request)
	{
		if (Auth::check())
			return $this->output([
			'is_login' => 1, //已登录，返回登录的用户信息
			'user' =>  [
				'user_id' => $this->user->getKey(),
				'nickname' => $this->user->nickname,
				'img_url' => url('attachment?id='.$this->user->avatar_aid),
				'profile_url' => url('member/'.$this->user->getKey()),
				'sign' => '**' //注意这里的sign签名验证已弃用，任意赋值即可
			]]);
		else
			return $this->output(['is_login' => 0]);
	}

	public function login(Request $request)
	{
		$cy_user_id = $request->input('cy_user_id');
		$user_id = $request->input('user_id');
		$nickname = $request->input('nickname');
		$img_url = $request->input('img_url');
		$profile_url = $request->input('profile_url');
		$sign = $request->input('sign');

		/*//不能乱提交啊
		if ($this->getSign(compact('cy_user_id', 'img_url', 'nickname', 'profile_url', 'user_id')) != urldecode($sign))
			return $this->output([
				'code' => '1',
				'msg' => 'sign error',
			]);*/

		if (empty($user_id)) //无绑定关系
		{
			if (Auth::check()) { //登录了
				return $this->output([
					'user_id' => $this->user->getKey(), //回传id过去让畅言绑定
					'reload_page' => 1,
					'js_src' => [],
				]);
			} else {
				return $this->output([
					'user_id' => 0,
					'reload_page' => 0,
					'js_src' => [url('plugins/js/changyan/login.js')],
				]);
			}
		} else { //有绑定关系
			Auth::loginUsingId($user_id); //登录本账号
			return $this->output([
				'user_id' => $user_id,
				'reload_page' => 1, //reload_page为1表示会重新刷新当前页
				'js_src' => [],
			]);
		}
	}

	public function logout(Request $request)
	{
		Auth::logout();
		return $this->output([
			'code' => 1,
			'reload_page' => 1,
			'js_src' => [url('plugins/js/changyan/logout.js')],
		]);
	}
}