<?php
namespace Plugins\Tools\App\Http\Controllers;

use Illuminate\Http\Request;
use Addons\Core\Controllers\Controller;
use Addons\Censor\Validation\ValidatesRequests;

class InstallController extends Controller {
	use ValidatesRequests;

	protected $disableUser = true;

	public function index()
	{
		$this->_path = preg_replace('#[/\\\\]+#', '/', dirname($_SERVER['SCRIPT_NAME']));
		$this->_url = get_current_url(HTTP_URL_SCHEME | HTTP_URL_PATH | HTTP_URL_PATH);

		return $this->view('tools::system.install');
	}

	public function saveQuery(Request $request)
	{
		$keys = ['SESSION_PATH', 'APP_URL', 'DB_HOST', 'DB_PORT', 'DB_DATABASE', 'DB_USERNAME', 'DB_PASSWORD'];
		$data = $this->censor($request, 'tools::install.store', $keys);

		$data['APP_KEY'] = 'base64:'.base64_encode(random_bytes(config('app.cipher') == 'AES-128-CBC' ? 16 : 32));

		//.env
		$path = app()->environmentFilePath();
		$content = file_get_contents($path);

		foreach($data as $key => $value)
		{
			$value = str_replace(array('\\', '$'), array('\\\\', '\\$'), $value);
			$content = preg_replace('/'.$key.'=(.*?)([\r\n]{1,2})/i', $key.'='.$value.'$2', $content);
		}

		file_put_contents($path, $content);

		//.htaccess
		$path = base_path('.htaccess');
		$content = file_get_contents($path);
		$content = preg_replace('/RewriteBase(.*?)([\r\n]{1,2})/i', 'RewriteBase '.str_replace(array('\\', '$'), array('\\\\', '\\$'), $data['SESSION_PATH']).'$2', $content);
		file_put_contents($path, $content);
		//public/.htaccess
		$path = public_path('.htaccess');
		$content = file_get_contents($path);
		$content = preg_replace('/RewriteBase(.*?)([\r\n]{1,2})/i', 'RewriteBase '.str_replace(array('\\', '$'), array('\\\\', '\\$'), $data['SESSION_PATH']).'/public$2', $content);
		file_put_contents($path, $content);


		return $this->success('系统配置成功！');
	}
}
