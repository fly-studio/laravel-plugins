<?php
namespace Plugins\Wechat\App\Http\Controllers\Admin\Wechat;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Plugins\Wechat\App\WechatMenu;
use Addons\Core\Controllers\AdminTrait;
use Plugins\Wechat\App\Tools\Account;

class MenuController extends Controller
{
	use AdminTrait;
	public $RESTful_permission = 'wechat-menu';
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request, Account $account)
	{
		$menu = new WechatMenu;
		$builder = $menu->newQuery()->where('waid', $account->getAccountID());
		$pagesize = $request->input('pagesize') ?: config('site.pagesize.admin.'.$menu->getTable(), $this->site['pagesize']['common']);
		$base = boolval($request->input('base')) ?: false;

		//view's variant
		$this->_base = $base;
		$this->_pagesize = $pagesize;
		$this->_filters = $this->_getFilters($request, $builder);
		$this->_table_data = $base ? $this->_getPaginate($request, $builder, ['*'], ['base' => $base]) : [];
		return $this->view('wechat::admin.wechat.menu.'. ($base ? 'list' : 'datatable'));
	}

	public function data(Request $request, Account $account)
	{
		$menu = new WechatMenu;
		$builder = $menu->newQuery()->where('waid', $account->getAccountID());
		$_builder = clone $builder;$total = $_builder->count();unset($_builder);
		$data = $this->_getData($request, $builder);
		$data['recordsTotal'] = $total;
		$data['recordsFiltered'] = $data['total'];
		return $this->success('', FALSE, $data);
	}

	public function export(Request $request, Account $account)
	{
		$menu = new WechatMenu;
		$page = $request->input('page') ?: 0;
		$pagesize = $request->input('pagesize') ?: config('site.pagesize.export', 1000);
		$total = $menu::count();

		if (empty($page)){
			$this->_of = $request->input('of');
			$this->_table = $menu->getTable();
			$this->_total = $total;
			$this->_pagesize = $pagesize > $total ? $total : $pagesize;
			return $this->view('wechat::admin.wechat.menu.export');
		}

		$builder = $menu->newQuery()->where('waid', $account->getAccountID());
		$data = $this->_getExport($request, $builder);
		return $this->success('', FALSE, $data);
	}

	public function show($id)
	{
		return '';
	}

	public function create()
	{
		$keys = 'name,url,wdid';
		$this->_data = [];
		$this->_validates = $this->getScriptValidate('wechat-menu.store', $keys);
		return $this->view('wechat::admin.wechat.menu.create');
	}

	public function store(Request $request, Account $account)
	{
		$keys = 'name,url,wdid';
		$data = $this->autoValidate($request, 'wechat-memu.store', $keys);

		WechatMenu::create($data + ['waid' => $account->getAccountID()]);
		return $this->success('', url('admin/wechat/menu'));
	}

	public function edit($id)
	{
		$menu = WechatMenu::find($id);
		if (empty($menu))
			return $this->failure_noexists();

		$keys = 'name,url,wdid';
		$this->_validates = $this->getScriptValidate('wechat-memu.store', $keys);
		$this->_data = $menu;
		return $this->view('wechat::admin.wechat.menu.edit');
	}

	public function update(Request $request, $id)
	{
		$menu = WechatMenu::find($id);
		if (empty($menu))
			return $this->failure_noexists();

		$keys = 'name,url,wdid';
		$data = $this->autoValidate($request, 'wechat-memu.store', $keys);
		$menu->update($data);
		return $this->success();
	}

	public function destroy(Request $request, $id)
	{
		empty($id) && !empty($request->input('id')) && $id = $request->input('id');
		$id = (array) $id;
		
		foreach ($id as $v)
			$menu = WechatMenu::destroy($v);
		return $this->success('', count($id) > 5, compact('id'));
	}
}
