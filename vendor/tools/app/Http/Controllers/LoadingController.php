<?php
namespace Plugins\Tools\App\Http\Controllers;

use Addons\Core\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Addons\Core\Validation\ValidatesRequests;
class LoadingController extends Controller {
	protected $addons = false;

	public function index($folders = [], $style = '', $url = '', $tips = '')
	{
		$files = array();$folders = to_array($folders);
		foreach ($folders as $v)
		{
			$_folder = base_path($v);
			if (!is_dir($_folder)) continue;
			$_f = file_list($_folder, array(
				base_path(config('app.static').'*'),
			));
			foreach($_f as $_v)
				$files[] = str_replace(base_path(), '', $_v);
		}

		$styles = ['ball-pulse' => 3, 'ball-grid-pulse' => 9, 'ball-clip-rotate' => 1, 'ball-clip-rotate-pulse' => 2, 'square-spin' => 1, 'ball-clip-rotate-multiple' => 2, 'ball-pulse-rise' => 5, 'ball-rotate' => 1, 'cube-transition' => 2, 'ball-zig-zag' => 2, 'ball-zig-zag-deflect' => 2, 'ball-triangle-path' => 3, 'ball-scale' => 1, 'line-scale' => 5, 'line-scale-party' => 4, 'ball-scale-multiple' => 3, 'ball-pulse-sync' => 3, 'ball-beat' => 3, 'line-scale-pulse-out' => 5, 'line-scale-pulse-out-rapid' => 5, 'ball-scale-ripple' => 1, 'ball-scale-ripple-multiple' => 3, 'ball-spin-fade-loader' => 8, 'line-spin-fade-loader' => 8, 'triangle-skew-spin' => 1, 'pacman' => 5, 'semi-circle-spin' => 1, 'ball-grid-beat' => 9, 'ball-scale-random' => 3];
		!array_key_exists($style, $styles) && $style = 'square-spin';

		$this->_files = $files;
		$this->_style = $style;
		$this->_loading_divs= $styles[$style] ?: 1;
		$this->_url = url($url);
		$this->_tips = $tips;
		return $this->view('tools::system.loading');
	}
}