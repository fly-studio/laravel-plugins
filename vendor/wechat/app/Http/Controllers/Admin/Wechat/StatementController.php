<?php
namespace Plugins\Wechat\App\Http\Controllers\Admin\Wechat;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Addons\Core\Controllers\ApiTrait;
use Plugins\Wechat\App\WechatBill;

class StatementController extends Controller
{
	use ApiTrait;
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$bill = new WechatBill;
		$size = $request->input('size') ?: config('size.models.'.$bill->getTable(), config('size.common'));

		$this->_size = $size;
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
		$size = $request->input('size') ?: config('size.export', 1000);
		$total = $this->_getCount($request, $builder);

		if (empty($page)){
			$this->_of = $request->input('of');
			$this->_table = $bill->getTable();
			$this->_total = $total;
			$this->_size = $size > $total ? $total : $size;
			return $this->view('wechat::admin.wechat.statement.export');
		}

		$data = $this->_getExport($request, $builder);
		return $this->api($data);
	}
}

