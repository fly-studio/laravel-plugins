<?php

namespace Plugins\Wechat\App\Http\Middleware;

use Closure;
use Plugins\Wechat\App\Tools;

class WechatAccount
{
	/**
	 * The \Addons\Core\Tools\Wechat\Account.
	 *
	 * @var \Addons\Core\Tools\Wechat\Account
	 */
	protected $account;

	/**
	 * Create a new filter instance.
	 *
	 * @param  \Addons\Core\Tools\Wechat\Account  $auth
	 * @return void
	 */
	public function __construct()
	{

	}

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{

		if (empty(Tools\account_storage()))
		{
			if ($request->ajax()) {
				return response('Unauthorized.', 401);
			} else {
				return redirect()->guest('wechat/choose');
			}
		}

		return $next($request);
	}
}
