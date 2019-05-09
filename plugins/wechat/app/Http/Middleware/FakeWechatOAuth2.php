<?php

namespace Plugins\Wechat\App\Http\Middleware;

use Closure, Log, Event;
use Overtrue\Socialite\User;
use Plugins\Wechat\App\Tools;
use Plugins\Wechat\App\Tools\WechatFactory;
use Plugins\Wechat\App\Events\WeChatUserAuthorized;

class FakeWechatOAuth2
{
	/**
	 * The Plugins\Wechat\App\Tools\WechatFactory.
	 *
	 * @var Plugins\Wechat\App\Tools\WechatFactory
	 */
	protected $wechat;

	/**
	 * Create a new filter instance.
	 *
	 * @param  \Plugins\Wechat\App\Tools\WechatFactory  $wechat
	 * @return void
	 */
	public function __construct(WechatFactory $wechat)
	{
		$this->wechat = $wechat;
	}

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next, $waid, $openid = null)
	{
		$app = $this->wechat->accountID($waid)->make('OfficialAccount');

		$isNewSession = false;
		$onlyRedirectInWeChatBrowser = $app['config']->get('oauth.only_wechat_browser', false);

		if ($onlyRedirectInWeChatBrowser && !$this->isWeChatBrowser($request)) {
			if ($app['config']->get('debug', false)) {
				Log::debug('[not wechat browser] skip wechat oauth redirect.');
			}

			return $next($request);
		}

		$user = Tools\oauth2_storage($waid);

		if (empty($user)) {
			// 伪造数据
			if (empty($openid)) $openid = 'fake-'.mt_rand(100000, 999999);
			$user = new User([
				'id' => $openid,
				'username' => $openid,
				'nickname' => null,
				'email' => null,
				'avatar' => null,
				'original' => [

				]
			]);

			Tools\oauth2_storage($waid, $user);
			$isNewSession = true;
		}

		Event::dispatch(new WeChatUserAuthorized($app, $user, $isNewSession));

		return $next($request);
	}

	/**
	 * Detect current user agent type.
	 *
	 * @param \Illuminate\Http\Request $request
	 *
	 * @return bool
	 */
	protected function isWeChatBrowser($request)
	{
		return false !== strpos($request->header('user_agent'), 'MicroMessenger');
	}
}
