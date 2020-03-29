<?php

namespace Plugins\Attachment\App\Casts;

use Plugins\Attachment\App\Tools\Utils\Helpers;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class Attachment implements CastsAttributes
{
	/**
	 * 将取出的数据进行转换
	 *
	 * @param  \Illuminate\Database\Eloquent\Model  $model
	 * @param  string  $key
	 * @param  mixed  $value
	 * @param  array  $attributes
	 * @return array
	 */
	public function get($model, $key, $value, $attributes)
	{
		return Helpers::encode($value);
	}

	/**
	 * 转换成将要进行存储的值
	 *
	 * @param  \Illuminate\Database\Eloquent\Model  $model
	 * @param  string  $key
	 * @param  array  $value
	 * @param  array  $attributes
	 * @return string
	 */
	public function set($model, $key, $value, $attributes)
	{
		return is_numeric($value) ? $value : Helpers::decode($value);
	}

}
