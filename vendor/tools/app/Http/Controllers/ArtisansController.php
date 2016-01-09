<?php
namespace Plugins\Tools\App\Http\Controllers;

use Addons\Core\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class ArtisansController extends Controller {

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
			exec($command, $out);
			$result = implode(PHP_EOL, $out);
		}

		return $this->success('', FALSE, compact('command', 'result'));
	}
}