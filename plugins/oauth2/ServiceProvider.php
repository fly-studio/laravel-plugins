<?php

namespace Plugins\OAuth2;

use DateInterval;
use Carbon\Carbon;
use Laravel\Passport\Passport;
use League\OAuth2\Server\CryptKey;
use Plugins\OAuth2\App\CodeFactory;
use Plugins\OAuth2\App\AccessTokenFactory;
use Plugins\OAuth2\App\Grant\AuthCodeGrant;
use League\OAuth2\Server\AuthorizationServer;
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

		$server = $this->app->make(AuthorizationServer::class);
		$server->enableGrantType(
			$this->makeAuthCodeGrant(), Passport::tokensExpireIn()
		);

		$this->app->singleton(AccessTokenFactory::class, function(){
			return new AccessTokenFactory(
				Passport::tokensExpireIn(),
				Passport::refreshTokensExpireIn(),
				$this->makeCryptKey('oauth-private.key'),
				app('encrypter')->getKey()
			);
		});

		$this->app->singleton(CodeFactory::class, function(){
			return new CodeFactory(
				new DateInterval('PT10M'),
				app('encrypter')->getKey()
			);
		});

	}

	/**
	 * Create and configure an instance of the Auth Code grant.
	 *
	 * @return \League\OAuth2\Server\Grant\AuthCodeGrant
	 */
	protected function makeAuthCodeGrant()
	{
		return tap($this->buildAuthCodeGrant(), function ($grant) {
			$grant->setRefreshTokenTTL(Passport::refreshTokensExpireIn());
		});
	}

	/**
	 * Build the Auth Code grant instance.
	 *
	 * @return \League\OAuth2\Server\Grant\AuthCodeGrant
	 */
	protected function buildAuthCodeGrant()
	{
		return new AuthCodeGrant(
			$this->app->make(\Laravel\Passport\Bridge\AuthCodeRepository::class),
			$this->app->make(\Laravel\Passport\Bridge\RefreshTokenRepository::class),
			new DateInterval('PT10M')
		);
	}

	/**
	 * Create a CryptKey instance without permissions check
	 *
	 * @param string $key
	 * @return \League\OAuth2\Server\CryptKey
	 */
	protected function makeCryptKey($key)
	{
		return new CryptKey(
			'file://'.Passport::keyPath($key),
			null,
			false
		);
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
