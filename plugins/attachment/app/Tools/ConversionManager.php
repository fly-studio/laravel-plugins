<?php

namespace Plugins\Attachment\App\Tools;

use Illuminate\Support\Manager;
use Illuminate\Foundation\Application;

class ConversionManager extends Manager {

	protected $driver = null;

	public function __construct(Application $app)
	{
		$this->app = $app;
	}

	public function createCaptureDriver()
	{
		return new Conversions\Capture();
	}

	public function createConvertMediaDriver()
	{
		return new Conversions\ConvertMedia();
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
