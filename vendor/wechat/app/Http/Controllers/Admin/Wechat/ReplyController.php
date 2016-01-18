<?php
namespace Plugins\Wechat\App\Http\Controllers\Admin\Wechat;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Plugins\Wechat\App\WechatAccount;
use Plugins\Wechat\App\WechatReply;
use Plugins\Wechat\App\Tools\Account;
use Addons\Core\Controllers\AdminTrait;

class ReplyController extends Controller
{
	use AdminTrait;
	public $RESTful_permission = 'wechat-reply';
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request, Account $account)
	{
		$reply = new WechatReply;
		$builder = $reply->newQuery()->where('waid', $account->getAccountID());
		$pagesize = $request->input('pagesize') ?: config('site.pagesize.admin.'.$reply->getTable(), $this->site['pagesize']['common']);
		$base = boolval($request->input('base')) ?: false;

		//view's variant
		$this->_base = $base;
		$this->_pagesize = $pagesize;
		$this->_filters = $this->_getFilters($request, $builder);
		$this->_table_data = $base ? $this->_getPaginate($request, $builder, ['*'], ['base' => $base]) : [];
		return $this->view('wechat::admin.wechat.reply.'. ($base ? 'list' : 'datatable'));
	}

	public function data(Request $request, Account $account)
	{
		$reply = new WechatReply;
		$builder = $reply->newQuery()->where('waid', $account->getAccountID());
		$_builder = clone $builder;$total = $_builder->count();unset($_builder);
		$data = $this->_getData($request, $builder);
		$data['recordsTotal'] = $total;
		$data['recordsFiltered'] = $data['total'];
		return $this->success('', FALSE, $data);
	}

	public function export(Request $request, Account $account)
	{
		$reply = new WechatReply;
		$builder = $reply->newQuery();
		$page = $request->input('page') ?: 0;
		$pagesize = $request->input('pagesize') ?: config('site.pagesize.export', 1000);
		$total = $this->_getCount($request, $builder);

		if (empty($page)){
			$this->_of = $request->input('of');
			$this->_table = $reply->getTable();
			$this->_total = $total;
			$this->_pagesize = $pagesize > $total ? $total : $pagesize;
			return $this->view('wechat::admin.wechat.reply.export');
		}

		$data = $this->_getExport($request, $builder)->where('waid', $account->getAccountID());
		return $this->success('', FALSE, $data);
	}

	public function show($id)
	{
		return '';
	}

	public function create()
	{
		$keys = 'name,description,appid,appsecret,token,encodingaeskey,qr_aid';
		$this->_data = [];
		$this->_validates = $this->getScriptValidate('wechat-replay.store', $keys);
		return $this->view('wechat::admin.wechat.reply.create');
	}

	public function store(Request $request, Account $account)
	{
		$keys = 'name,description,appid,appsecret,token,encodingaeskey,qr_aid';
		$data = $this->autoValidate($request, 'wechat-replay.store', $keys);

		WechatReply::create($data + ['waid' => $account->getAccountID()]);
		return $this->success('', url('admin/wechat/replay'));
	}

	public function edit($id)
	{
		$reply = WechatReply::find($id);
		if (empty($reply))
			return $this->failure_noexists();

		$keys = 'name,description,appid,appsecret,token,encodingaeskey,qr_aid';
		$this->_validates = $this->getScriptValidate('wechat-replay.store', $keys);
		$this->_data = $reply;
		return $this->view('wechat::admin.wechat.reply.edit');
	}

	public function update(Request $request, $id)
	{
		$reply = WechatReply::find($id);
		if (empty($reply))
			return $this->failure_noexists();

		$keys = 'name,description,appid,appsecret,token,encodingaeskey,qr_aid';
		$data = $this->autoValidate($request, 'wechat-replay.store', $keys);
		$reply->update($data);
		return $this->success();
	}

	public function destroy(Request $request, $id)
	{
		empty($id) && !empty($request->input('id')) && $id = $request->input('id');
		$id = (array) $id;
		
		foreach ($id as $v)
			$reply = WechatReply::destroy($v);
		return $this->success('', count($id) > 5, compact('id'));
	}
}
