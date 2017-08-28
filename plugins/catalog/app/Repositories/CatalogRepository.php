<?php

namespace Plugins\Catalog\App\Repositories;

use DB;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Addons\Core\Contracts\Repository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

use App\Catalog;

class CatalogRepository extends Repository {

	public function prePage()
	{
		return config('size.models.'.(new Catalog)->getTable(), config('size.common'));
	}

	public function find($id)
	{
		return Catalog::find($id);
	}

	public function findTops($id = 0)
	{
		return $this->findWithChildren($id)->children->where('name', '>', '')->where('title', '>', '');
	}

	public function findWithParents($id)
	{
		$catalog = Catalog::with('parent')->find($id);
		!empty($catalog) && $catalog->parents = $catalog->getParents();

		return $catalog;
	}

	public function findWithChildren($id)
	{
		$catalog = Catalog::with('children')->find($id);

		return $catalog;
	}

	public function findDescendant($id)
	{
		$root = $id instanceof Catalog ? $id : Catalog::find($id);

		return !empty($root) ? $root->getDescendant()->prepend($root) : false;
	}

	public function findByNamePid($name, $pid)
	{
		return Catalog::findByNamePid($name, $pid);
	}

	public function getCatalogsByName($name = NULL)
	{
		return Catalog::getCatalogsByName($name);
	}

	public function getCatalogsById($id = NULL)
	{
		return Catalog::getCatalogsById($id);
	}

	public function store(array $data)
	{
		return DB::transaction(function() use ($data) {
			$catalog = Catalog::create($data);
			return $catalog;
		});
	}

	public function update(Model $catalog, array $data)
	{
		return DB::transaction(function() use ($catalog, $data){
			$catalog->update($data);
			return $catalog;
		});
	}

	public function move($target_id, $original_id, $move_type)
	{
		$c0 = Catalog::find($target_id);
		if (empty($c0))
			return false;

		$c1 = Catalog::find($original_id);
		if (empty($c1))
			return false;

		DB::transaction(function() use ($c0, $c1, $move_type) {
			$c1->move($c0->getKey(), $move_type);
		});
	}

	public function order($orders)
	{
		DB::transaction(function() use ($orders) {
			foreach($orders as $id => $order)
				Catalog::where('id', $id)->update(['order_index' => intval($order)]);
		});
	}

	public function destroy(array $ids)
	{
		DB::transaction(function() use ($ids) {
			Catalog::destroy($ids);
		});
	}

	public function tree($id)
	{
		$descendant = $this->findDescendant($id);
		if (empty($descendant))
			return false;
		return Catalog::datasetToTree($descendant->keyBy('id')->toArray(), $id, false);
	}

	public function data(Request $request)
	{
		$catalog = new Catalog;
		$builder = $catalog->newQuery();

		$total = $this->_getCount($request, $builder, FALSE);
		$data = $this->_getData($request, $builder, function($page) use($request, $catalog) {
			if ($request->input('tree') == 'true')
			{
				$items = $page->getCollection()->keyBy($catalog->getKeyName())->toArray();
				unset($items[0]);
				$page->setCollection(new Collection(Catalog::datasetToTree($items, 0, false)));
			}
		});
		$data['recordsTotal'] = $total; //不带 f q 条件的总数
		$data['recordsFiltered'] = $data['total']; //带 f q 条件的总数

		return $data;
	}

	public function export(Request $request)
	{
		$catalog = new Catalog;
		$builder = $catalog->newQuery();
		$size = $request->input('size') ?: config('size.export', 1000);

		$data = $this->_getExport($request, $builder);

		return $data;
	}

}
