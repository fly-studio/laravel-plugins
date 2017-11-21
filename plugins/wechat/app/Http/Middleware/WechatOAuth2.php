<?php

namespace Plugins\Wechat\App\Http\Middleware;

use Closure, Log, Event;
use Plugins\Wechat\App\Tools;
use Plugins\Wechat\App\Tools\WechatFactory;
use Plugins\Wechat\App\Events\WeChatUserAuthorized;

class WechatOAuth2
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
	public function handle($request, Closure $next, $waid, $scopes = null)
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

		$scopes = $scopes ?: $app['config']->get('oauth.scopes', ['snsapi_base']);
		if (is_string($scopes)) $scopes = explode(',', $scopes);

		$user = Tools\oauth2_storage($waid);

		if (empty($user) || $this->needReauth($user, $scopes)) {
			//微信回执
			if ($request->has('code')) {
				$user = $app->oauth->user();

				Tools\oauth2_storage($waid, $user);
				$isNewSession = true;

				Event::fire(new WeChatUserAuthorized($app, $user, $isNewSession));

				return redirect()->to($this->getTargetUrl($request));
			}
			Tools\oauth2_storage($waid, false); //forget it
			return $app->oauth->scopes($scopes)->redirect($request->fullUrl());
		}

		Event::fire(new WeChatUserAuthorized($app, $user, $isNewSession));

		return $next($request);
	}

	/**
	 * Build the target business url.
	 *
	 * @param Request $request
	 *
	 * @return string
	 */
	protected function getTargetUrl($request)
	{
		$queries = array_except($request->query(), ['code', 'state']);

		return $request->url().(empty($queries) ? '' : '?'.http_build_query($queries));
	}

	/**
	 * Is different scopes.
	 *
	 * @param array $scopes
	 *
	 * @return bool
	 */
	protected function needReauth($user, $scopes)
	{
		return 'snsapi_base' == array_get($user, 'original.scope') && in_array('snsapi_userinfo', $scopes);
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
