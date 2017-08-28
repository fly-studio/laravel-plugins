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
use Addons\Core\ApiTrait;

class MessageController extends Controller
{
	use ApiTrait;
	public $permissions = ['wechat-message'];
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request, Account $account)
	{
		$message = new WechatMessage;
		$size = $request->input('size') ?: config('size.models.'.$message->getTable(), config('size.common'));

		//view's variant
		$this->_size = $size;
		$this->_filters = $this->_getFilters($request);
		$this->_queries = $this->_getQueries($request);
		return $this->view('wechat::admin.wechat.message.list');
	}

	public function data(Request $request, Account $account)
	{
		$message = new WechatMessage;
//		$builder = $message->newQuery()->with(['account', 'user', 'depot', 'link', 'location', 'text', 'media'])->where('transport_type','receive')->where('waid', $account->getAccountID());
		$builder = $message->newQuery()->with(['account', 'user', 'depot', 'link', 'location', 'text', 'media'])->where('waid', $account->getAccountID());
		$total = $this->_getCount($request, $builder, FALSE);
		$data = $this->_getData($request, $builder);
		$data['recordsTotal'] = $total;
		$data['recordsFiltered'] = $data['total'];
		return $this->api($data);
	}

	public function export(Request $request, Account $account)
	{
		$message = new WechatMessage;
		$builder = $message->newQuery()->with(['account', 'user', 'depot', 'link', 'location', 'text', 'media'])->where('waid', $account->getAccountID());
		$size = $request->input('size') ?: config('size.export', 1000);

		$data = $this->_getExport($request, $builder);
		return $this->office($data);
	}

	public function show($id)
	{
		return '';
	}

	public function update(Request $request, $uid)
	{
		$user = WechatUser::find($uid);
		if (empty($user))
			return $this->failure_notexists();

		$keys = 'type,content';
		$data = $this->censor($request, 'wechat::wechat-message.store', $keys);

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
		$ids = array_wrap($id);

		DB::transaction(function() use ($ids) {
			WechatMessage::destroy($ids);
		});
		return $this->success(null, true, ['id' => $ids]);
	}
}
