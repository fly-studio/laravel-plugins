<?php

namespace Plugins\Socialite\App\Http\Controllers;

use Socialite;
use Addons\Core\Exceptions\OutputResponseException;

trait AddonsTrait {

	protected function getSocialite($name)
	{
		//未启用此社交平台
		if (!in_array($name, config('socialite.enable_drivers')))
			throw (new OutputResponseException())->setMessage('socialite::socialite.not_exists', compact('name'));

		$settings = config('socialite.drivers.'.$name);

		$config = new \SocialiteProviders\Manager\Config(null, null, url('socialite/callback/'.$name), (array)$settings);

		return Socialite::with($settings['driver_name'] ?? str_replace('-', '', $name))->setConfig($config);
	}
}
