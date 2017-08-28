<?php
namespace Plugins\Attachment\App\Tools\Outputs;

use Image;
use Plugins\Attachment\App\Contracts\Tools\Output;
use Plugins\Attachment\App\Exceptions\AttachmentException;

class Resize extends Output {
	
	public function resize($width, $height, $cache = true)
	{
		$attachment = $this->attachment();

		$full_path = $attachment->full_path;
		$size = getimagesize($full_path);
		if ((!empty($width) && $size[0] > $width) || (!empty($height) && $size[1] > $height))
		{
			$wh = aspect_ratio($size[0], $size[1], $width, $height);
			extract($wh);
			$new_path = storage_path(str_replace('.', '[dot]', $attachment->relative_path.';'.$width.'x'.$height).'.'.$attachment->ext);
			if (!file_exists($new_path))
			{
				$img = Image::make($full_path);
				class_exists('Imagick') && $img->setCore($img->getCore()->coalesceImages());
				!is_dir($path = dirname($new_path)) && mkdir($path, 0777, true);
				$img->resize($width, $height, function ($constraint) {
					$constraint->aspectRatio();
				})->save($new_path);
				unset($img);
			}
		} else
			$new_path = $full_path;
		$mime_type = $attachment->mime;
		$content_length = null;//$attachment->size;
		$last_modified = true;
		$etag = $attachment->hash; //为什么可以输出源文件的hash，因为etag是区分网址的
		return response()->preview($new_path, [], compact('mime_type', 'etag', 'last_modified', 'content_length', 'cached'));
	}
}