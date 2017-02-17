<?php
namespace Plugins\Catalog\App;

use Addons\Core\Models\Tree;
use Addons\Core\Models\TreeCacheTrait;

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

	public static function getCatalogsByName($name = NULL)
	{
		empty(static::$cacheTree) && static::getAll('name');
		$name = str_replace(['.', '.children.children', '.children.children'], ['.children.', '.children', '.children'], $name);
		return is_null($name) ? static::$cacheTree['name'] : 
			(empty($name) || in_array($name, ['none', 'null']) ? static::find(0)->toArray() : array_get(static::$cacheTree['name'], $name));
	}

	public static function getCatalogsById($id = NULL)
	{
		empty(static::$cacheTree) && static::getAll();
		return is_null($id) ? static::$cacheTree['id'][ 0 ][ 'children' ] : 
			(empty($id) ? static::find(0)->toArray() : array_get(static::$cacheTree['id'], $id));
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
