<?php

namespace Plugins\Tools\App\Http\Controllers;

use DB;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Addons\Core\Controllers\Controller;
use Addons\Censor\Validation\ValidatesRequests;
use Symfony\Component\Console\Input\StringInput;

class ArtisansController extends Controller {

	use ValidatesRequests;

	protected $disableUser = true;

	public function index()
	{
		return $this->view('tools::system.artisans');
	}

	public function consoleQuery(Request $request)
	{
		$command = trim($request->input('command'));
		$result = trans('tools::tools.unknow_command');
		if (empty($command))
			return $this->error(null, compact('command', 'result'));

		if (Str::startsWith($command, 'php artisan'))
		{
			set_time_limit(120);
			//在网页上执行，下面的方法会导致 plugins 中的commands、console、migrations都无法加载，待修改为cli执行
			$kernel = app('Addons\\Core\\Console\\Kernel');
			$commands = get_property(app('App\\Console\\Kernel'), 'commands');
			$kernel->setCommands($commands);
			try {
				$out = $kernel->run($command);
			} catch (Exception $e) {
				return $this->error(null, compact('command', 'result'));
			}

			$result = $out->fetch();
		}

		return $this->success(null, compact('command', 'result'))->action('back');
	}

	public function sqlQuery(Request $request)
	{
		$keys = ['content'];
		$data = $this->censor($request, 'tools::artisans.store', $keys);
		try {
			set_time_limit(120);

			DB::transaction(function () use ($data){
				DB::statement($data['content']);
			});

		} catch (Exception $e) {
			$error = error_get_last();
			return $this->error('tools:artisans.failure_sql', $error);
		}
		return $this->success('tools::artisans.success_sql')->action('back');
	}

	public function schemaQuery(Request $request)
	{
		$keys = ['content'];
		$data = $this->censor($request, 'tools::artisans.store', $keys);

		try {
			set_time_limit(500);
			eval('use Illuminate\Database\Schema\Blueprint;use Illuminate\Database\Migrations\Migration;' .$data['content'] );
		} catch (Exception $e) {
			$error = error_get_last();

			return $this->error('tools:artisans.failure_schema', $error);
		}

		return $this->success('tools::artisans.success_schema')->action('back') ;
	}
}
