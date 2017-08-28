<?php

namespace Plugins\Attachment\App\Tools;

use Illuminate\Support\Manager;
use Illuminate\Foundation\Application;

use Plugins\Attachment\App\Attachment;

class OutputManager extends Manager {

	protected $driver = null;
	protected $attachment = null;

	public function __construct(Application $app)
	{
		$this->app = $app;
	}

	public function createSendDriver()
	{
		return new Outputs\Send($this);
	}

	public function createPreviewDriver()
	{
		return new Outputs\Preview($this);
	}
	
	public function createResizeDriver()
	{
		return new Outputs\Resize($this);
	}

	public function createWatermarkDriver()
	{
		return new Outputs\Watermark($this);
	}

	public function getDefaultDriver()
	{
		return $this->driver;
	}

	public function attachment(Attachment $attachment = null)
	{
		if (is_null($attachment))
			return $this->attachment;

		$this->attachment = $attachment;
		return $this;
	}

	public function __call($method, $parameters)
	{
		$this->driver = $method;
		return $this->driver($method)->$method(...$parameters);
	}
}