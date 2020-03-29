<?php

namespace Plugins\Catalog\App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

use App\Catalog as AppCatalog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Catalog implements CastsAttributes
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
		$node = AppCatalog::searchCatalog($value);

		return !empty($node) ? $node->fillToModel(new AppCatalog(), function($model, $data){
			$data['extra'] = json_encode($data['extra']);
			return $data;
		}) : null;
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
		return $value instanceof AppCatalog ? $value->getKey() : $value;
	}

}
