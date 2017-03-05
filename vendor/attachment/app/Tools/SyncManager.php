<?php
namespace Plugins\Attachment\App\Tools;

use Illuminate\Support\Manager;
use \Illuminate\Foundation\Application;

class SyncManager extends Manager {

	public function __construct(Application $app)
	{
		$this->app = $app;
	}

	public function createSSHDriver()
	{
		return new Sync\SSHEngine();
	}

	public function createNullDriver()
	{
		return new Sync\NullEngine();
	}

	public function getDefaultDriver()
	{
		return config('attachment.remote.driver', 'null');
	}

}