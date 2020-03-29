<?php

namespace Plugins\Attachment\App\Tools\Sync;

use Addons\Func\Tools\SSHClient;
use Plugins\Attachment\App\Tools\Utils\Path;
use Plugins\Attachment\App\Contracts\Tools\Sync;
use Plugins\Attachment\App\Tools\AttachmentException;

class SSHEngine implements Sync {

	public function recv($hashPath, $toPath = null, $life_time = null)
	{

		$localPath = empty($toPath) ? Path::realPath($hashPath) : $toPath;
		$remotePath = Path::remotePath($hashPath);

		//如果本地存在，就放弃下载
		if (file_exists($localPath)) return true;

		$dir = dirname($localPath);
		Path::mkLocalDir($dir);

		$ssh = new SSHClient((array)config('attachment.remote.SSH'));

		if (!$ssh->file_exists($remotePath))
			throw AttachmentException::create('remote_not_exists')->code(404);

		if (!(@$ssh->receive_file($remotePath, $localPath)))
			throw AttachmentException::create('write_no_permission')->code(403);

		Path::chLocalMod($localPath);

		//过期文件 删除
		is_null($life_time) && !config('attachment.local.enabled') && $life_time = config('attachment.local.life_time');
		//!empty($life_time) && delay_unlink($local, $life_time);

		return true;
	}

	protected function send($fromPath, $hashPath)
	{
		$ssh = new SSHClient((array)config('attachment.remote.SSH'));

		$remotePath = Path::remotePath($hashPath);
		$dir = dirname($remotePath);
		$this->mkRemoteDir($ssh, $dir);
		if (!(@$ssh->send_file($fromPath, $remotePath)))
			throw AttachmentException::create('remote_no_permission')->code(403);
		$this->chRemoteMod($ssh, $remotePath);

		return true;
	}

	private function mkRemoteDir(SSHClient $ssh, $dir)
	{
		!$ssh->is_dir($dir) && @$ssh->mkdir($dir, config('attachment.remote.SSH.folder_mod', 0777), true);
		!empty(config('attachment.remote.SSH.folder_own')) && @$ssh->chown($dir, config('attachment.remote.SSH.folder_own'));
		!empty(config('attachment.remote.SSH.folder_grp')) && @$ssh->chgrp($dir, config('attachment.remote.SSH.folder_grp'));
		if (!is_dir($dir) || !is_writable($dir))
			throw AttachmentException::create('remote_no_permission')->code(403);
	}

	private function chRemoteMod(SSHClient $ssh, $path)
	{
		@$ssh->chmod($path, config('attachment.remote.SSH.file_mod', 0777));
		!empty(config('attachment.remote.SSH.file_own')) && @$ssh->chown($path, config('attachment.remote.SSH.file_own'));
		!empty(config('attachment.remote.SSH.file_grp')) && @$ssh->chgrp($path, config('attachment.remote.SSH.file_grp'));
	}
}
