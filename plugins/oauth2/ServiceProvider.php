<?php

namespace Plugins\OAuth2;

use Carbon\Carbon;
use Laravel\Passport\Passport;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
	/**
	 * 指定是否延缓提供者加载。
	 *
	 * @var bool
	 */
	protected $defer = true;
	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{

	}
	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		if (config('oauth2.enableImplicitGrant', false)) //隐式授权令牌
			Passport::enableImplicitGrant();
		Passport::tokensExpireIn(Carbon::now()->addSeconds(config('oauth2.tokensExpireIn', 7 * 86400)));
		Passport::refreshTokensExpireIn(Carbon::now()->addDays(config('oauth2.refreshTokensExpireIn', 14 * 86400)));
		if (config('oauth2.pruneRevokedTokens', false)) //删除过期令牌
			Passport::pruneRevokedTokens();
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return [];
	}
}
