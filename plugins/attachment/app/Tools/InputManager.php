<?php

namespace Plugins\Attachment\App\Tools;

use Illuminate\Support\Manager;
use Illuminate\Foundation\Application;

class InputManager extends Manager {

	protected $driver = null;

	public function __construct(Application $app)
	{
		$this->app = $app;
	}

	public function createDownloadDriver()
	{
		return new Inputs\Download();
	}

	public function createHashDriver()
	{
		return new Inputs\Hash();
	}

	public function createUploadDriver()
	{
		return new Inputs\Upload($this->app['request']);
	}

	public function createRawDriver()
	{
		return new Inputs\Raw();
	}

	public function getDefaultDriver()
	{
		return $this->driver;
	}

	public function __call($method, $parameters)
	{
		$this->driver = $method;
		return $this->driver($method)->$method(...$parameters);
	}
}
