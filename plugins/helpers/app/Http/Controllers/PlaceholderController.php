<?php

namespace Plugins\Helpers\App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PlaceholderController extends Controller {

	/**
	 * 输出图片
	 *
	 * @param  string $size     [description]
	 * @param  string $bgcolor  [description]
	 * @param  string $color    [description]
	 * @param  string $text     [description]
	 * @param  [type] $fontsize [description]
	 * @return [type]           [description]
	 */
	public function index(Request $request)
	{
		$size = $request->input('size', '100x100');
		$bgcolor = $request->input('bgcolor', 'ccc');
		$color = $request->input('color', '555');
		$text = $request->input('text', '');
		$fontsize = $request->input('fontsize', null);

		$cache_filepath = utils_path('placeholders/'.md5(serialize(compact('size', 'bgcolor', 'color', 'text', 'fontsize'))).'.png');

		if (!file_exists($cache_filepath))
		{
			// Dimensions
			list($width, $height) = explode('x', $size);
			empty($height) && $height = $width;
			$bgcolor = hex2rgb($bgcolor);
			$color = hex2rgb($color);
			empty($text) && $text = $width . ' x ' .$height;

			//$hash_key = md5(serialize(compact('width','height','bgcolor','color','text')));

			// Create image
			$image = imagecreate($width, $height);

			// Colours
			$setbg = imagecolorallocate($image, $bgcolor['r'], $bgcolor['g'], $bgcolor['b']);
			$fontcolor = imagecolorallocate($image, $color['r'], $color['g'], $color['b']);

			// Text positioning
			empty($fontsize) && $fontsize = ($width > $height) ? ($height / 10) : ($width / 10) ;
			$font = static_path('common/fonts/msyh.ttf');
			$fontbox = calculate_textbox($fontsize, 0, $font, $text);
			// Generate text
			function_exists('imageantialias') && imageantialias($image, true);
			imagettftext($image, $fontsize, 0, ceil(($width - $fontbox['width'] ) / 2 + $fontbox['left']), ceil(($height - $fontbox['height']  ) / 2 + $fontbox['top']), $fontcolor, $font, $text);
			// Render image
			imagepng($image, $cache_filepath);
			imagedestroy($image);
		}

		return response()->preview($cache_filepath, ['Content-Type' => 'image/png']);
	}
}
