<?php

namespace Plugins\Socialite\App\Http\Controllers;

use Laravel\Socialite\Contracts\Factory;
use Addons\Core\Exceptions\OutputResponseException;

use Plugins\Socialite\App\Repositories\SocialiteRepository;

trait AddonsTrait {

	protected function getSocialite($id)
	{
		list($name, $settings) = app(SocialiteRepository::class)->settings($id);

		//未启用此社交平台
		if (!in_array($name, config('socialite.enable_drivers')))
			throw (new OutputResponseException())->setMessage('socialite::socialite.not_exists', compact('name'));

		$config = new \SocialiteProviders\Manager\Config(null, null, url('socialite/feedback/'.$id), (array)$settings);

		return app(Factory::class)->with($settings['driver_name'] ?? str_replace('-', '', $name))->setConfig($config);
	}
}
