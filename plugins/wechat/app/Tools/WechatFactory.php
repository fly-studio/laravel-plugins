<?php

namespace Plugins\Wechat\App\Tools;

use Plugins\Wechat\App\Tools;
use EasyWeChat\Work\AgentFactory as Work;
use EasyWeChat\Payment\Application as Payment;
use EasyWeChat\MiniProgram\Application as MiniProgram;
use EasyWeChat\OpenPlatform\Application as OpenPlatform;
use EasyWeChat\OfficialAccount\Application as OfficialAccount;

use Plugins\Wechat\App\Repositories\WechatAccountRepository;

class WechatFactory {

	private $repo;
	private $waid;

	public function __construct(WechatAccountRepository $repo)
	{
		$this->repo = $repo;
	}

	public function make($method, ...$args)
	{
		if (empty($this->waid))
			throw new InvalidArgumentException('Set accountID first.');

		$app = $this->{$method}(...$args);
		if (config('wechat.defaults.use_laravel_cache'))
			$app['cache'] = app('cache.store');
		$app['request'] = app('request');
		return $app;
	}

	public function accountID($waid)
	{
		if (is_null($waid)) return $this->waid;
		$this->waid = $waid;
		return $this;
	}

	private function options($optionsName)
	{
		return Tools\extendsConfig($optionsName, $this->repo->options($this->waid, $optionsName));
	}

	protected function OfficialAccount()
	{
		return new OfficialAccount($this->options('official_account'));
	}

	protected function Payment()
	{
		return new Payment($this->options('payment'));
	}

	protected function Work()
	{
		return new Work($this->options('work'));
	}

	protected function MiniProgram()
	{
		return new MiniProgram($this->options('mini_program'));
	}

	protected function OpenPlatform()
	{
		return new OpenPlatform($this->options('open_platform'));
	}

}
