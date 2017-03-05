<?php
namespace Plugins\Wechat\App\Http\Controllers\Admin\Wechat;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Plugins\Wechat\App\WechatAccount;
use Plugins\Wechat\App\WechatReply;
use Plugins\Wechat\App\Tools\Account;
use Addons\Core\Controllers\ApiTrait;

class ReplyController extends Controller
{
	use ApiTrait;
	public $permissions = ['wechat-reply'];
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request, Account $account)
	{
		$reply = new WechatReply;
		$size = $request->input('size') ?: config('size.models.'.$reply->getTable(), config('size.common'));

		//view's variant
		$this->_size = $size;
		$this->_filters = $this->_getFilters($request);
		$this->_queries = $this->_getQueries($request);
		return $this->view('wechat::admin.wechat.reply.list');
	}

	public function data(Request $request, Account $account)
	{
		$reply = new WechatReply;
		$builder = $reply->newQuery()->withCount(['depots', 'replies'])->where('waid', $account->getAccountID());
		$total = $this->_getCount($request, $builder, FALSE);
		$data = $this->_getData($request, $builder);
		$data['recordsTotal'] = $total;
		$data['recordsFiltered'] = $data['total'];
		return $this->api($data);
	}

	public function export(Request $request, Account $account)
	{
		$reply = new WechatReply;
		$builder = $reply->newQuery();
		$size = $request->input('size') ?: config('size.export', 1000);

		$data = $this->_getExport($request, $builder)->where('waid', $account->getAccountID());
		return $this->office($data);
	}

	public function show($id)
	{
		return '';
	}

	public function create()
	{
		$keys = 'keywords,match_type,wdid,reply_count';
		$this->_data = [];
		$this->_validates = $this->getScriptValidate('wechat-reply.store', $keys);
		return $this->view('wechat::admin.wechat.reply.create');
	}

	public function store(Request $request, Account $account)
	{
		$keys = 'keywords,match_type,wdid,reply_count';
		$data = $this->autoValidate($request, 'wechat-reply.store', $keys);

		$wdid = $data['wdid'];unset($data['wdid']);
		$reply = WechatReply::create($data + ['waid' => $account->getAccountID()]);
		$reply->depots()->sync($wdid);
		return $this->success('', url('admin/wechat/reply'));
	}

	public function edit($id)
	{
		$reply = WechatReply::find($id);
		if (empty($reply))
			return $this->failure_notexists();

		$keys = 'keywords,match_type,wdid,reply_count';
		$this->_validates = $this->getScriptValidate('wechat-reply.store', $keys);
		$this->_data = $reply;
		return $this->view('wechat::admin.wechat.reply.edit');
	}

	public function update(Request $request, $id)
	{
		$reply = WechatReply::find($id);
		if (empty($reply))
			return $this->failure_notexists();

		$keys = 'keywords,match_type,wdid,reply_count';
		$data = $this->autoValidate($request, 'wechat-reply.store', $keys);
		$wdid = $data['wdid'];unset($data['wdid']);
		$reply->update($data);
		$reply->depots()->sync($wdid);
		return $this->success();
	}

	public function destroy(Request $request, $id)
	{
		empty($id) && !empty($request->input('id')) && $id = $request->input('id');
		$ids = array_wrap($id);
		
		DB::transaction(function() use ($ids) {
			WechatReply::destroy($ids);
		});
		return $this->success('', count($id) > 5, compact('id'));
	}
}
