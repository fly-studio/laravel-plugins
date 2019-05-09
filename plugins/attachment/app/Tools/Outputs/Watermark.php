<?php
namespace Plugins\Attachment\App\Tools\Outputs;

use Image;
use Plugins\Attachment\App\Contracts\Tools\Output;
use Plugins\Attachment\App\Exceptions\AttachmentException;

use Plugins\Attachment\App\Attachment;

class Watermark extends Output {

	public function watermark(Attachment $watermark, $width = 0, $height = 0, $cached = true)
	{
		$attachment = $this->attachment();

		$full_path = $attachment->full_path;
		$watermark_path = $watermark->full_path;
		$size = getimagesize($full_path);
		if (!empty($width) || !empty($height)) {
			$wh = aspect_ratio($size[0], $size[1], $width, $height);
			extract($wh);
		} else
			list($width, $height) = $size;

		$new_path = storage_path(str_replace('.', '[dot]', $attachment->relative_path.';'.$width.'x'.$height.';'.md5($watermark_path)).'.'.$attachment->ext);

		if (!file_exists($new_path))
		{
			$img = Image::make($full_path);
			!is_dir($path = dirname($new_path)) && mkdir($path, 0777, true);
			($size[0] != $width || $size[1] != $height) &&
				$img->resize($width, $height, function ($constraint) {
					$constraint->aspectRatio();
				});
			$size = getimagesize($watermark_path);
			$wh = aspect_ratio($size[0], $size[1], $width * 0.2, $height * 0.2);
			$wm = Image::make($watermark_path)->resize($wh['width'], $wh['height']);
			$img->insert($wm, 'bottom-right', 7, 7)->save($new_path);
			unset($img);
		}

		$mime_type = $attachment->mime;
		$content_length = null;//$attachment->size;
		$last_modified = $attachment->created_at;
		$etag = $attachment->hash; //为什么可以输出源文件的hash，因为etag是区分网址的
		return response()->preview($new_path, [], compact('mime_type', 'etag', 'last_modified', 'content_length', 'cached'));
	}
}
