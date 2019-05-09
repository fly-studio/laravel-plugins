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

	public function find($id, array $columns = ['*'])
	{
		return Catalog::find($id, $columns);
	}

	public function findTops($id = 0, array $columns = ['*'])
	{
		return $this->findWithChildren($id, $columns)->children->where('name', '>', '')->where('title', '>', '');
	}

	public function findWithParents($id, array $columns = ['*'])
	{
		$catalog = Catalog::with('parent')->find($id);
		!empty($catalog) && $catalog->parents = $catalog->getParents();

		return $catalog;
	}

	public function findWithChildren($id, array $columns = ['*'])
	{
		$catalog = Catalog::with('children')->find($id, $columns);

		return $catalog;
	}

	public function findLeaves($id, array $columns = ['*'])
	{
		$root = $id instanceof Catalog ? $id : Catalog::find($id, $columns);

		return !empty($root) ? $root->getLeaves()->prepend($root) : false;
	}

	public function findByNamePid($name, $pid, array $columns = ['*'])
	{
		return Catalog::findByNamePid($name, $pid, $columns);
	}

	public function searchCatalog($name = null, $subKeys = null)
	{
		return Catalog::searchCatalog($name, $subKeys);
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
		$leaves = $this->findLeaves($id);
		if (empty($leaves))
			return false;
		return Catalog::datasetToTree($leaves->keyBy('id')->toArray(), false);
	}

	public function data(Request $request, callable $callback = null, array $columns = ['*'])
	{
		$catalog = new Catalog;
		$builder = $catalog->newQuery();

		$total = $this->_getCount($request, $builder, FALSE);
		$data = $this->_getData($request, $builder, function($page) use($request, $catalog) {
			if ($request->input('tree') == 'true')
			{
				$items = $page->getCollection()->keyBy($catalog->getKeyName())->toArray();
				unset($items[0]);
				$page->setCollection(new Collection(Catalog::datasetToTree($items, false)));
			}
		}, $columns);
		$data['recordsTotal'] = $total; //不带 f q 条件的总数
		$data['recordsFiltered'] = $data['total']; //带 f q 条件的总数

		return $data;
	}

	public function export(Request $request, callable $callback = null, array $columns = ['*'])
	{
		$catalog = new Catalog;
		$builder = $catalog->newQuery();
		$size = $request->input('size') ?: config('size.export', 1000);

		$data = $this->_getExport($request, $builder, $callback, $columns);

		return $data;
	}

}
