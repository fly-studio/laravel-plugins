<?php

namespace Plugins\Socialite;

use Carbon\Carbon;
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
		//add enable_drivers to config
		$enable_drivers = [];
		foreach(config('socialite.drivers') as $driver => $config)
			if ($config['enable'])
				$enable_drivers[] = $driver;
		config()->set('socialite.enable_drivers', $enable_drivers);
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
