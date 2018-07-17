<?php

namespace Plugins\Catalog\App\Models;

use App\Catalog as AppCatalog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

trait CatalogCastTrait {

	public function asCatalog($value) {
		$node = AppCatalog::searchCatalog($value);

		return $node->fillToModel(new AppCatalog(), function($model, $data){
			$data['extra'] = json_encode($data['extra']);
			return $data;
		});
	}

	public function catalogToArray($value) {
		return $value->toArray();
	}

	public function asCatalogName($value) {
		$node = AppCatalog::searchCatalog($value);

		return $node->fillToModel(new AppCatalog(), function($model, $data){
			$data['extra'] = json_encode($data['extra']);
			return $data;
		});
	}

	public function catalogNameToArray($value) {
		return $value->toArray();
	}

	public function asStatus($value) {
		return $this->asCatalog($value);
	}

	public function statusToArray($value) {
		return $value->toArray();
	}

	public function scopeOfCatalog(Builder $builder, $idOrModel, $field_name)
	{
		$id = $idOrModel;

		if ($idOrModel instanceof Model)
		{
			$id = $idOrModel->getKey();
		}
		elseif (!is_numeric($idOrModel) && strpos($idOrModel, '.') !== false)
		{
			$catalog = $this->asCatalogName($idOrModel);
			!empty($catalog->getKey()) && $id = $catalog->getKey();
		}

		$builder->where($field_name, $id);
	}
}
