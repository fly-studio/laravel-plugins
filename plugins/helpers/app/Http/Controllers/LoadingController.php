<?php
namespace Plugins\Helpers\App\Http\Controllers;

use Illuminate\Http\Request;
use Addons\Core\Controllers\Controller;

class LoadingController extends Controller {

	protected $disableUser = true;

	public function index(Request $request)
	{
		$folders = $request->input('folders', []);
		$style = $request->input('style', '');
		$url = $request->input('url', '');
		$tips = $request->input('tips', '');

		$files = array();
		foreach (array_wrap($folders) as $v)
		{
			$_folder = base_path($v);
			if (!is_dir($_folder)) continue;

			$_f = file_list($_folder, array(
				static_path('*'),
			));
			foreach($_f as $_v)
				$files[] = str_replace(base_path(), '', $_v);
		}

		static $styles = ['ball-pulse' => 3, 'ball-grid-pulse' => 9, 'ball-clip-rotate' => 1, 'ball-clip-rotate-pulse' => 2, 'square-spin' => 1, 'ball-clip-rotate-multiple' => 2, 'ball-pulse-rise' => 5, 'ball-rotate' => 1, 'cube-transition' => 2, 'ball-zig-zag' => 2, 'ball-zig-zag-deflect' => 2, 'ball-triangle-path' => 3, 'ball-scale' => 1, 'line-scale' => 5, 'line-scale-party' => 4, 'ball-scale-multiple' => 3, 'ball-pulse-sync' => 3, 'ball-beat' => 3, 'line-scale-pulse-out' => 5, 'line-scale-pulse-out-rapid' => 5, 'ball-scale-ripple' => 1, 'ball-scale-ripple-multiple' => 3, 'ball-spin-fade-loader' => 8, 'line-spin-fade-loader' => 8, 'triangle-skew-spin' => 1, 'pacman' => 5, 'semi-circle-spin' => 1, 'ball-grid-beat' => 9, 'ball-scale-random' => 3];
		!array_key_exists($style, $styles) && $style = 'square-spin';

		$this->_files = $files;
		$this->_style = $style;
		$this->_loading_divs= $styles[$style] ?: 1;
		$this->_url = url($url);
		$this->_tips = $tips;

		return $this->view('helpers::loading');
	}
}
