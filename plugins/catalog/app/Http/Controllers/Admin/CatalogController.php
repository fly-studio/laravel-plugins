<?php
namespace Plugins\Catalog\App\Http\Controllers\Admin;

use DB;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Http\Controllers\Controller;

use App\Catalog;
use App\Repositories\CatalogRepository;

class CatalogController extends Controller
{
	public $permissions = ['catalog', 'orderQuery,move' => 'catalog.edit', 'tree' => 'catalog.view'];

	protected $repo;

	public function __construct(CatalogRepository $repo)
	{
		$this->repo = $repo;
	}

	public function index(Request $request)
	{
		return redirect('admin/catalog/0');
	}

	public function data(Request $request)
	{
		$data = $this->repo->data($request);
		return $this->api($data);
	}

	public function tree(Request $request, $parentName)
	{
		$catalog = catalog_search($parentName);
		if (empty($catalog))
			return $this->error('document.not_exists')->code(404);

		$data = $this->repo->tree($catalog['id']);
		return $this->api(['data' => $data]);
	}

	public function show(Request $request, $id)
	{
		$root = $this->repo->findWithParents($id);
		if (empty($root))
			return $this->error('document.not_exists')->code(404);

		if ($request->offsetExists('of'))
			return $this->api($root);

		$this->_topNodes = $this->repo->findTops(0);
		$this->_root = $root;
		$this->_table_data = empty($id) ? null : $this->repo->findLeaves($root);
		return $this->view('catalog::admin.catalog.list');
	}

	public function orderQuery(Request $request)
	{
		$keys = ['orders'];
		$data = $this->censor($request, 'catalog::catalog.store', $keys);

		$this->repo->order($data['orders']);
		return $this->success()->action('back');
	}

	public function store(Request $request)
	{
		$keys = ['name', 'title', 'pid', 'extra'];
		$data = $this->censor($request, 'catalog::catalog.store', $keys);

		if (!empty($this->repo->findByNamePid($data['name'], $data['pid'])))
			return $this->error('catalog::catalog.name_exists', $data);

		$this->repo->store($data);
		return $this->success();
	}

	public function update(Request $request, $id)
	{
		$catalog = $this->repo->find($id);
		if (empty($catalog))
			return $this->error('document.not_exists')->code(404);

		$keys = ['title', 'extra'];
		$data = $this->censor($request, 'catalog::catalog.store', $keys, $catalog);

		$this->repo->update($catalog, $data);

		return $this->success();
	}

	public function move(Request $request)
	{
		$keys = 'original_id,target_id,move_type';
		$data = $this->censor($request, 'catalog::catalog.move', $keys);

		if ($this->repo->move($data['target_id'], $data['original_id'], $data['move_type']) === false)
			return $this->error('document.not_exists')->code(404);

		return $this->success('catalog::catalog.move_success', $data)->action('back');
	}

	public function destroy(Request $request, $id)
	{
		empty($id) && !empty($request->input('id')) && $id = $request->input('id');
		$ids = Arr::wrap($id);

		$this->repo->destroy($ids);
		return $this->success();
	}
}
