<?php
namespace Plugins\Attachment\App\Tools;

use Illuminate\Support\Manager;
use Plugins\Attachment\App\Tools\File;
use \Illuminate\Foundation\Application;
use Plugins\Attachment\App\Tools\Utils\Path;
use Plugins\Attachment\App\Exceptions\AttachmentException;

use Plugins\Attachment\App\Attachment;

class SaveManager extends Manager {

	private $driver = null;

	protected $filename = null;
	protected $ext = null;
	protected $extra = [];
	protected $user = null;
	protected $chunks = [];
	protected $file = null;
	protected $deleteAfter = false;

	public function __construct(Application $app)
	{
		$this->app = $app;
	}

	public function file(File $file = null)
	{
		if (is_null($file))
			return $this->file;

		if (!$file->isFile())
			throw new AttachmentException('file_invalid');

		$this->file = $file;
		$size = $file->getSize();

		if ($size > config('attachment.maxsize', 0))
			throw new AttachmentException('out_of_size');
		else if (empty($size))
			throw new AttachmentException('empty_file');

		$this->filename($this->file->getClientOriginalName());

		return $this;
	}

	public function filename($filename = null)
	{
		if (is_null($filename))
		{
			if (empty($this->filename))
				throw new AttachmentException('lost_filename', 'error');

			return $this->filename;
		}

		$this->filename = $filename;
		$this->ext(pathinfo($filename, PATHINFO_EXTENSION));

		return $this;
	}

	public function ext($ext = null)
	{
		if (is_null($ext))
			return $this->ext ?: strtolower(pathinfo($this->filename(), PATHINFO_EXTENSION));

		$this->ext = strtolower($ext);
		if(!in_array($this->ext, config('attachment.ext', [])))
			throw new AttachmentException('ext_deny');

		return $this;
	}

	public function user($user = null)
	{
		if (is_null($user))
			return $this->user;

		$this->user = $user;
		return $this;
	}

	public function extra($extra = null)
	{
		if (is_null($extra))
			return $this->extra;

		$this->extra = $extra;
		return $this;
	}

	public function chunks($chunksConfig = null)
	{
		if (is_null($chunksConfig))
			return $this->chunks;

		$this->chunks = $chunksConfig;
		return $this;
	}

	public function deleteFileAfterSaved()
	{
		$this->deleteAfter = true;
		return $this;
	}

	public function deleteAfter()
	{
		return $this->deleteAfter;
	}

	public function save()
	{
		$attachment = null;
		$chunks = $this->chunks();
		if (!is_null($this->driver))
			$attachment = $this->driver($this->driver)->save();
		elseif (empty($chunks) || empty($chunks['uuid']) || empty($chunks['count']) || $chunks['count'] <= 1)
			$attachment = $this->driver('whole')->save();
		else
			$attachment = $this->driver('chunk')->save();

		if ($this->deleteAfter)
			@unlink($this->file()->getPathName());

		return Attachment::mix($attachment->getKey());
	}

	public function createWholeDriver()
	{
		return new Save\Whole($this);
	}

	public function createChunkDriver()
	{
		return new Save\Chunk($this);
	}

	public function createHashDriver()
	{
		return new Save\Hash($this);
	}

	public function getDefaultDriver()
	{
		return $this->driver ?: 'whole';
	}

	public function setDriver($driver)
	{
		$this->driver = $driver;
		return $this;
	}

}
