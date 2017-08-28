<?php
namespace Plugins\Helpers\App\Http\Controllers;

use Image;
use PHPQRCode\QRcode;
use PHPQRCode\Constants;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class QrController extends Controller {

	/**
	 * 输出二维码
	 * @param  [type]  $text      [description]
	 * @param  integer $size      [description]
	 * @param  string  $watermark [description]
	 * @return [type]             [description]
	 */
	public function index(Request $request)
	{
		return $this->png($request);
	}

	public function png(Request $request)
	{
		$text = $request->input('text');
		$size = $request->input('size', 25);
		$watermark = $request->input('watermark', '');

		if (empty($watermark) || !file_exists(base_path($watermark)))
		{
			return response()->stream(function() use ($text, $size, $watermark){
				echo QRcode::png($text, FALSE, Constants::QR_ECLEVEL_M, $size, 0 );
			}, 200, ['Content-Type' => 'image/png']);
		}
		else
		{
			$watermark = base_path($watermark);
			$tmp = tempnam(sys_get_temp_dir(), '.png');
			QRcode::png($text, $tmp, Constants::QR_ECLEVEL_M, $size, 0 );
			$img = Image::make($tmp);
			$wm = Image::make($watermark)->resize($img->width() * 0.2, $img->height() * 0.2);
			unlink($tmp);
			$img->insert($wm, 'center');
			return $img->response('png');
		}
	}

	public function svg(Request $request)
	{
		$text = $request->input('text');
		$element_id = $request->input('element_id', false);
		$width = $request->input('width', false);
		$size = $request->input('size', false);

		return response(
			QRcode::svg($text, $element_id, FALSE, Constants::QR_ECLEVEL_H, $width, $size, 0),
			200,
			['Content-Type' => 'image/svg']
		);
	}
}
