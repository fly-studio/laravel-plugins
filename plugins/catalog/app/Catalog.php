<?php

namespace Plugins\Catalog\App;

use Addons\Core\Models\Tree;
use Addons\Core\Models\TreeCacheTrait;
use Illuminate\Database\Eloquent\Builder;

class Catalog extends Tree {

	use TreeCacheTrait;

	//不能批量赋值
	public $orderKey = 'order_index';
	public $pathKey = 'path';
	public $levelKey = 'level';
	protected $hidden = ['created_at', 'updated_at', 'deleted_at', 'path', 'order_index'/*, 'level'*/];
	protected $casts = [
		'extra' => 'array',
	];

	protected $guarded = ['id'];

	public static function searchCatalog($name = null, $subKeys = null)
	{
		$node = static::getTreeCache()->search($name, null, 'name');
		return empty($node) ? null :
			(is_null($subKeys) ? $node : $node[$subKeys]);
	}

	public function scope_all(Builder $builder, $keywords)
	{
		if (empty($keywords)) return;
		$catalogs = static::search(null)->where(['name', 'title', 'description', 'extra'], $keywords)->take(2000)->keys();
		return $builder->whereIn($this->getKeyName(), $catalogs);
	}

	public static function import(&$data, $parentNode)
	{
		foreach($data as $k => $v)
		{
			@list($name, $title, $extra) = explode('|', $k);
			!empty($extra) && $extra = json_decode($extra, true);
			$node = $parentNode->children()->create(compact('name', 'title', 'extra'));
			!empty($v) && static::import($v, $node);
		}
	}
}
