<?php
namespace Plugins\Wechat\App\Http\Controllers\Admin\Wechat;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Addons\Core\Controllers\AdminTrait;
use Plugins\Wechat\App\WechatBill;

class StatementController extends Controller
{
	use AdminTrait;
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$bill = new WechatBill;
		$pagesize = $request->input('pagesize') ?: config('site.pagesize.admin.'.$bill->getTable(), $this->site['pagesize']['common']);

		$this->_pagesize = $pagesize;
		$this->_filters = $this->_getFilters($request);
		return $this->view('wechat::admin.wechat.statement.list');
	}

	public function data(Request $request)
	{
		$bill = new WechatBill;
		$builder = $bill->newQuery();
		$_builder = clone $builder;$total = $_builder->count();unset($_builder);
		$data = $this->_getData($request, $builder);
		$data['recordsTotal'] = $total;
		$data['recordsFiltered'] = $data['total'];
		return $this->api($data);
	}

	public function export(Request $request)
	{
		$bill = new WechatBill;
		$builder = $bill->newQuery();
		$page = $bill->input('page') ?: 0;
		$pagesize = $request->input('pagesize') ?: config('site.pagesize.export', 1000);
		$total = $this->_getCount($request, $builder);

		if (empty($page)){
			$this->_of = $request->input('of');
			$this->_table = $bill->getTable();
			$this->_total = $total;
			$this->_pagesize = $pagesize > $total ? $total : $pagesize;
			return $this->view('wechat::admin.wechat.statement.export');
		}

		$data = $this->_getExport($request, $builder);
		return $this->api($data);
	}
}

