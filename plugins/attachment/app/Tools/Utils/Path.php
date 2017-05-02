<?php
namespace Plugins\Attachment\App\Tools\Utils;

use Plugins\Attachment\App\AttachmentFile;

class Path {
	/**
	 * 获取一个不存在的文件名称
	 * 
	 * @return [type] [description]
	 */
	public static function generateHashName()
	{
		do
		{
			$hashName = uniqid(date('YmdHis,') . rand(1000000, 9999999), ',') . config('attachment.saved_ext', '');
			$file = AttachmentFile::findByBasename($hashName);
		} while (!empty($file));
		return $hashName;
	}

	/**
	 * 根据附件名称获得相对路径
	 * 	
	 * @param  string $hashName 附件文件名
	 * @return string           相对路径
	 */
	public static function hashNameToPath($hashName)
	{
		$md5 = md5($hashName . md5($hashName));
		return $md5[0].$md5[1].'/'.$md5[2].$md5[3].'/'.$md5[4].$md5[5].','.$hashName;
	}

	/**
	 * 根据数据库中的路径得到绝对路径
	 * 
	 * @param  string $hashPath 数据库中取出的路径
	 * @return string                绝对路径
	 */
	public static function realPath($hashPath)
	{
		return base_path(static::relativePath($hashPath));
	}

	/**
	 * 根据数据库中的路径得到远程绝对路径
	 * 
	 * @param  string $hashPath 数据库中取出的路径
	 * @return string                远程绝对路径
	 */
	public static function remotePath($hashPath)
	{
		return config('attachment.remote.path').'/'.$hashPath;
	}

	/**
	 * 根据数据库中的路径获得文件的相对路径
	 * 	
	 * @param  string $hashPath 数据库中的路径
	 * @return string            相对路径
	 */
	public static function relativePath($hashPath)
	{
		return config('attachment.local.path').DIRECTORY_SEPARATOR.$hashPath;
	}

	public static function mkLocalDir($dir)
	{
		!is_dir($dir) && @mkdir($dir, config('attachment.local.folder_mod', 0777), true);
		!empty(config('attachment.local.folder_own')) && @chown($dir, config('attachment.local.folder_own'));
		!empty(config('attachment.local.folder_grp')) && @chgrp($dir, config('attachment.local.folder_grp'));
		if (!is_dir($dir) || !is_writable($dir))
			throw new AttachmentException('write_no_permission');
	}

	public static function chLocalMod($path)
	{
		@chmod($path, config('attachment.local.file_mod', 0777));
		!empty(config('attachment.local.file_own')) && @chown($path, config('attachment.local.file_own'));
		!empty(config('attachment.local.file_grp')) && @chgrp($path, config('attachment.local.file_grp'));
	}
}