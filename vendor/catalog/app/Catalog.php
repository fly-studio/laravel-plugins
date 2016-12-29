<?php
namespace Plugins\Catalog\App;

use Addons\Core\Models\Tree;
use Addons\Core\Models\TreeCacheTrait;

class Catalog extends Tree {
	use TreeCacheTrait;

	//不能批量赋值
	public $orderKey = 'order_index';
	public $pathKey = NULL;
	public $levelKey = NULL;

	public $casts = [
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
}
