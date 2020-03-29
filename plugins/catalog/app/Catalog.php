<?php

namespace Plugins\Catalog\App;

use App\Model;
use Addons\Core\Models\TreeTrait;
use Illuminate\Database\Eloquent\Builder;

class Catalog extends Model {

	use TreeTrait;

	protected $hidden = ['created_at', 'updated_at', 'deleted_at', 'path', 'order_index'/*, 'level'*/];
	protected $casts = [
		'extra' => 'array',
	];

	protected $guarded = ['id'];

	public function getOrderKeyName()
	{
		return 'order_index';
	}

	public static function searchCatalog($name = null, $subKeys = null)
	{
		$node = static::getTreeCache()->search($name, null, 'name');

		return empty($node) ? null :
			(is_null($subKeys) ? $node : $node[$subKeys]);
	}

	public static function import(&$data, $parentNode)
	{
		foreach($data as $k => $v)
		{
			@list($name, $title, $extra) = explode('|', $k);

			if (!empty($extra))
				$extra = json_decode($extra, true);

			$node = $parentNode->children()
				->create(compact('name', 'title', 'extra'));

			if (!empty($v))
				static::import($v, $node);
		}
	}
}
