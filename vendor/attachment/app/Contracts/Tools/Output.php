<?php

namespace Plugins\Attachment\App\Contracts\Tools;

use Plugins\Attachment\App\Tools\OutputManager;
use Plugins\Attachment\App\Tools\File;

abstract class Output {

	protected $manager;

	public function __construct(OutputManager $manager)
	{
		$this->manager = $manager;
	}

	public function attachment()
	{
		return $this->manager->attachment();
	}

}