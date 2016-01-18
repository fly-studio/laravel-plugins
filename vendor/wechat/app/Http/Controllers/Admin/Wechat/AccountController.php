<?php
namespace Plugins\Wechat\App\Http\Controllers\Admin\Wechat;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Plugins\Wechat\App\WechatAccount;
use Addons\Core\Controllers\AdminTrait;

class AccountController extends Controller
{
	use AdminTrait;
	public $RESTful_permission = 'wechat-account';
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$account = new WechatAccount;
		$builder = $account->newQuery();
		$pagesize = $request->input('pagesize') ?: config('site.pagesize.admin.'.$account->getTable(), $this->site['pagesize']['common']);
		$base = boolval($request->input('base')) ?: false;

		//view's variant
		$this->_base = $base;
		$this->_pagesize = $pagesize;
		$this->_filters = $this->_getFilters($request, $builder);
		$this->_table_data = $base ? $this->_getPaginate($request, $builder, ['*'], ['base' => $base]) : [];
		return $this->view('wechat::admin.wechat.account.'. ($base ? 'list' : 'datatable'));
	}

	public function data(Request $request)
	{
		$account = new WechatAccount;
		$builder = $account->newQuery();
		$_builder = clone $builder;$total = $_builder->count();unset($_builder);
		$data = $this->_getData($request, $builder, function(&$v, $k){
			$v['users-count'] = $v->users()->count();
			$v['depots-count'] = $v->depots()->count();
			$v['messages-count'] = $v->messages()->count();
		});
		$data['recordsTotal'] = $total;
		$data['recordsFiltered'] = $data['total'];
		return $this->success('', FALSE, $data);
	}

	public function export(Request $request)
	{
		$account = new WechatAccount;
		$builder = $account->newQuery();
		$page = $request->input('page') ?: 0;
		$pagesize = $request->input('pagesize') ?: config('site.pagesize.export', 1000);
		$total = $this->_getCount($request, $builder);

		if (empty($page)){
			$this->_of = $request->input('of');
			$this->_table = $account->getTable();
			$this->_total = $total;
			$this->_pagesize = $pagesize > $total ? $total : $pagesize;
			return $this->view('wechat::admin.wechat.account.export');
		}

		$data = $this->_getExport($request, $builder);
		return $this->success('', FALSE, $data);
	}

	public function show($id)
	{
		return '';
	}

	public function create()
	{
		$keys = 'name,description,wechat_type,account,appid,appsecret,token,encodingaeskey,qr_aid,mchid,mchkey,sub_mch_id';
		$this->_data = [];
		$this->_validates = $this->getScriptValidate('wechat-account.store', $keys);
		return $this->view('wechat::admin.wechat.account.create');
	}

	public function store(Request $request)
	{
		$keys = 'name,description,wechat_type,account,appid,appsecret,token,encodingaeskey,qr_aid,mchid,mchkey,sub_mch_id';
		$data = $this->autoValidate($request, 'wechat-account.store', $keys);

		WechatAccount::create($data);
		return $this->success('', url('admin/wechat/account'));
	}

	public function edit($id)
	{
		$account = WechatAccount::find($id);
		if (empty($account))
			return $this->failure_noexists();

		$keys = 'name,description,wechat_type,account,appid,appsecret,token,encodingaeskey,qr_aid,mchid,mchkey,sub_mch_id';
		$this->_validates = $this->getScriptValidate('wechat-account.store', $keys);
		$this->_data = $account;
		return $this->view('wechat::admin.wechat.account.edit');
	}

	public function update(Request $request, $id)
	{
		$account = WechatAccount::find($id);
		if (empty($account))
			return $this->failure_noexists();

		$keys = 'name,description,wechat_type,account,appid,appsecret,token,encodingaeskey,qr_aid,mchid,mchkey,sub_mch_id';
		$data = $this->autoValidate($request, 'wechat-account.store', $keys, $account);
		$account->update($data);
		return $this->success();
	}

	public function destroy(Request $request, $id)
	{
		empty($id) && !empty($request->input('id')) && $id = $request->input('id');
		$id = (array) $id;
		
		foreach ($id as $v)
			$account = WechatAccount::destroy($v);
		return $this->success('', count($id) > 5, compact('id'));
	}
}
