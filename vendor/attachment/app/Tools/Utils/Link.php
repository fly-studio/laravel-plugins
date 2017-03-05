<?php
namespace Plugins\Attachment\App\Tools;

class Link {

	/**
	 * 在cache目录下创建一个软连接
	 * 
	 * @param  integer $id AID
	 * @return string
	 */
	public function create_symlink($path = null, $life_time = 86400)
	{
		//将云端数据同步到本地
		$this->remote && $this->sync();
		$path = !empty($path) ? $path : storage_path($this->_config['local']['path'].'attachment,'.md5($this->getKey()).'.'.$this->ext);
		@unlink($path);
		symlink($this->full_path(), $path);

		//!empty($life_time) && delay_unlink($path, $life_time);
		return $path;
	}

	/**
	 * 在cache目录下创建一个硬连接
	 * 
	 * @param  integer $id AID
	 * @return string
	 */
	public function create_link($path = null, $life_time = 86400)
	{
		//将云端数据同步到本地
		$this->remote && $this->sync();
		$path = !empty($path) ? $path : storage_path($this->_config['local']['path'].'attachment,'.md5($this->getKey()).'.'.$this->ext);
		@unlink($path);
		link($this->full_path(), $path);

		//!empty($life_time) && delay_unlink($path, $life_time);
		return $path;
	}
}