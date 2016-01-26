<?php
namespace Plugins\Tools\App\Http\Controllers;

use Addons\Core\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Addons\Core\Validation\ValidatesRequests;
use DB;
class ArtisansController extends Controller {
	use ValidatesRequests;

	public function index()
	{
		return $this->view('tools::system.artisans');
	}

	public function consoleQuery(Request $request)
	{
		$command = trim($request->input('command'));
		$result = trans('tools::tools.unknow_command');
		if (empty($command))
			return $this->failure('', FALSE, compact('command', 'result'), TRUE);

		if (Str::startsWith($command, 'php artisan'))
		{
			set_time_limit(120);
			exec($command, $out);
			$result = implode(PHP_EOL, $out);
		}

		return $this->success('', FALSE, compact('command', 'result'));
	}

	public function sqlQuery(Request $request)
	{
		$keys = 'content';
		$data = $this->autoValidate($request, 'artisans.store', $keys);
		try {
			set_time_limit(120);
			DB::transaction(function () use ($data){
					DB::statement($data['content']);
			});
		} catch (Exception $e) {
			$error = error_get_last();
			return $this->failure('tools:artisans.failure_sql', FALSE, $error);
		}
		return $this->success('tools::artisans.success_sql', FALSE);
	}

	public function schemaQuery(Request $request)
	{
		$keys = 'content';
		$data = $this->autoValidate($request, 'artisans.store', $keys);

		try {
			set_time_limit(120);
			eval('use Illuminate\Database\Schema\Blueprint;use Illuminate\Database\Migrations\Migration;' .$data['content'] );
		} catch (Exception $e) {
			$error = error_get_last();
			return $this->failure('tools:artisans.failure_schema', FALSE, $error);
		}
		
		return $this->success('tools::artisans.success_schema', FALSE);
	}
}