<?php
namespace Plugins\Catalog\App\Http\Controllers\Admin;

use DB;
use App\Catalog;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;
use Addons\Core\Controllers\ApiTrait;

class CatalogController extends Controller
{
	use ApiTrait;
	public $permissions = ['catalog'];
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		return redirect('admin/catalog/0');
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
				$page->setCollection(new Collection($catalog->_data_to_tree($items, 0, false)));
			}
		});
		$data['recordsTotal'] = $total; //不带 f q 条件的总数
		$data['recordsFiltered'] = $data['total']; //带 f q 条件的总数
		return $this->api($data);
	}

	public function show(Request $request, $id)
	{
		$root = Catalog::find($id);
		if (empty($root))
			return $this->failure_notexists();
		$root->parents = $root->getParents();
		if ($request->offsetExists('of'))
			return $this->api($root->load(['parent'])->toArray());

		$this->_topNodes = Catalog::find('0')->children->where('name', '>', '')->where('title', '>', '');
		$this->_root = $root;
		$this->_table_data = empty($id) ? null : $root->getDescendant()->prepend($root);
		return $this->view('catalog::admin.catalog.list');
	}

	public function orderQuery(Request $request)
	{
		$keys = ['orders'];
		$data = $this->autoValidate($request, 'catalog.store', $keys);

		DB::transaction(function() use ($data) {
			foreach($data['orders'] as $id => $order)
				Catalog::where('id', $id)->update(['order_index' => intval($order)]);
		});
		return $this->success('', false);
	}

	public function store(Request $request)
	{
		$keys = ['name', 'title', 'pid', 'extra'];
		$data = $this->autoValidate($request, 'catalog.store', $keys);

		if (Catalog::findByNamePid($data['name'], $data['pid']) !== false)
			return $this->failure('catalog::catalog.name_exists', false, $data);

		DB::transaction(function() use ($data) {
			Catalog::create($data);
		});
		return $this->success();
	}

	public function update(Request $request, $id)
	{
		$catalog = Catalog::find($id);
		if (empty($catalog))
			return $this->failure_notexists();

		$keys = ['title', 'extra'];
		$data = $this->autoValidate($request, 'catalog.store', $keys, $catalog);

		DB::transaction(function() use ($data, $catalog) {
			$catalog->update($data);
		});
		return $this->success();
	}

	public function move(Request $request)
	{
		$keys = 'original_id,target_id,move_type';
		$data = $this->autoValidate($request, 'catalog.move', $keys);

		$c0 = Catalog::find($data['target_id']);
		if (empty($c0))
			return $this->failure_notexists();

		$c1 = Catalog::find($data['original_id']);
		if (empty($c1))
			return $this->failure_notexists();

		DB::transaction(function() use ($c0, $c1, $data) {
			$c1->move($c0->getKey(), $data['move_type']);
		});

		return $this->success('catalog::catalog.move_success', false, $data);
	}

	public function destroy(Request $request, $id)
	{
		empty($id) && !empty($request->input('id')) && $id = $request->input('id');
		$ids = array_wrap($id);
		
		DB::transaction(function() use ($ids) {
			Catalog::destroy($ids);
		});
		return $this->success();
	}
}