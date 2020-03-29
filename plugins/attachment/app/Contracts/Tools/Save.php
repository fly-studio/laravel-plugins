<?php

namespace Plugins\Attachment\App\Contracts\Tools;

use Plugins\Attachment\App\Tools\File;
use Plugins\Attachment\App\Tools\Utils\Path;
use Plugins\Attachment\App\Tools\SaveManager;
use Plugins\Attachment\App\Tools\SyncManager;
use Plugins\Attachment\App\Exceptions\AttachmentException;

use Plugins\Attachment\App\AttachmentFile;

abstract class Save {

	protected $manager;

	public function __construct(SaveManager $manager)
	{
		$this->manager = $manager;
	}

	abstract function save();

	protected function saveToLocal(string $fromPath, string $hashPath)
	{
		if (config('attachment.local.enabled')) //本地存储打开
			return $this->forceSaveToLocal($fromPath, $hashPath);

		return true;
	}

	public function doSave(string $fromPath, string $toPath)
	{
		$result = false;

		$dir = dirname($toPath);
		Path::mkLocalDir($dir);

		if ($this->manager->deleteAfter())
		{
			if(is_uploaded_file($fromPath))
				$result = @move_uploaded_file($fromPath, $toPath);
			else
				$result = @rename($fromPath, $toPath);
		} else
			$result = @copy($fromPath, $toPath);

		if ($result)
			Path::chLocalMod($toPath);
		else
			throw AttachmentException::create('write_no_permission')->code(403);

		return true;
	}

	protected function forceSaveToLocal(string $fromPath, string $hashPath)
	{
		$localPath = Path::realPath($hashPath);

		return $this->doSave($fromPath, $localPath);
	}

	protected function saveToSync(string $fromPath, string $hashPath)
	{
		return app(SyncManager::class)->send($fromPath, $hashPath);
	}

	public function saveToTempFile(File $file)
	{
		if ($file->isFile())
		{
			$tempPath = tempnam(utils_path('attachments'), 'upload-');

			$this->doSave($file->getPathName(), $tempPath);

			return $tempPath;
		}

		return false;
	}

	public function saveToAttachmentFile(File $file)
	{
		$hash = $file->hash();
		$size = $file->size();
		$attachmentFile = AttachmentFile::findByHashSize($hash, $size);

		if (empty($attachmentFile) && $file->isFile())
		{
			$hashName = Path::generateHashName();
			$hashPath = Path::hashNameToPath($hashName);

			$this->saveToLocal($file->getPathName(), $hashPath);
			$this->saveToSync($file->getPathName(), $hashPath);

			$attachmentFile = AttachmentFile::create([
				'basename' => $hashName,
				'path' => $hashPath,
				'hash' => $hash,
				'size' => $size,
			]);
		}
		return $attachmentFile;
	}

}
