<?php
namespace Plugins\Wechat\App\Http\Controllers\Admin\Wechat;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Plugins\Attachment\App\Attachment;
use Plugins\Wechat\App\WechatAccount;
use Plugins\Wechat\App\WechatMessage;
use Plugins\Wechat\App\WechatDepot;
use Plugins\Wechat\App\WechatUser;
use Plugins\Wechat\App\Tools\Send;
use Plugins\Wechat\App\Tools\Account;
use Addons\Core\Controllers\AdminTrait;

class MessageController extends Controller
{
	use AdminTrait;
	public $RESTful_permission = 'wechat-message';
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request, Account $account)
	{
		$message = new WechatMessage;
		$pagesize = $request->input('pagesize') ?: config('site.pagesize.admin.'.$message->getTable(), $this->site['pagesize']['common']);

		//view's variant
		$this->_pagesize = $pagesize;
		$this->_filters = $this->_getFilters($request);
		return $this->view('wechat::admin.wechat.message.list');
	}

	public function data(Request $request, Account $account)
	{
		$message = new WechatMessage;
//		$builder = $message->newQuery()->with(['account', 'user', 'depot', 'link', 'location', 'text', 'media'])->where('transport_type','receive')->where('waid', $account->getAccountID());
		$builder = $message->newQuery()->with(['account', 'user', 'depot', 'link', 'location', 'text', 'media'])->where('waid', $account->getAccountID());
		$_builder = clone $builder;$total = $_builder->count();unset($_builder);
		$data = $this->_getData($request, $builder);
		$data['recordsTotal'] = $total;
		$data['recordsFiltered'] = $data['total'];
		return $this->api($data);
	}

	public function export(Request $request, Account $account)
	{
		$message = new WechatMessage;
		$builder = $message->newQuery()->with(['account', 'user', 'depot', 'link', 'location', 'text', 'media'])->where('waid', $account->getAccountID());
		$page = $request->input('page') ?: 0;
		$pagesize = $request->input('pagesize') ?: config('site.pagesize.export', 1000);
		$total = $this->_getCount($request, $builder);

		if (empty($page)){
			$this->_of = $request->input('of');
			$this->_table = $message->getTable();
			$this->_total = $total;
			$this->_pagesize = $pagesize > $total ? $total : $pagesize;
			return $this->view('wechat::admin.wechat.message.export');
		}

		$data = $this->_getExport($request, $builder);
		return $this->api($data);
	}

	public function show($id)
	{
		return '';
	}

	public function update(Request $request, $uid)
	{
		$user = WechatUser::find($uid);
		if (empty($user))
			return $this->failure_noexists();

		$keys = 'type,content';
		$data = $this->autoValidate($request, 'wechat-message.store', $keys);
	
		//发送消息
		$media = null;
		if ($data['type'] == 'text')
			$media = $data['content'];
		else if ($data['type'] == 'depot')
			$media = WechatDepot::findOrFail($data['content']);
		else
			$media = Attachment::findOrFail($data['content']);
		(new Send($user))->add($media)->send();
		return $this->success();
	}

	public function destroy(Request $request, $id)
	{
		empty($id) && !empty($request->input('id')) && $id = $request->input('id');
		$id = (array) $id;
		
		foreach ($id as $v)
			$message = WechatMessage::destroy($v);
		return $this->success('', count($id) > 5, compact('id'));
	}
}
