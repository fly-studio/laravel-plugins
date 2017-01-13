<?php
namespace Plugins\Wechat\App\Http\Controllers\Admin\Wechat;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Plugins\Wechat\App\WechatUser;
use Plugins\Wechat\App\Tools\Account;
use Addons\Core\Controllers\ApiTrait;

class UserController extends Controller
{
	use ApiTrait;
	public $permissions = ['wechat-user'];
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request, Account $account)
	{
		$user = new WechatUser;
		$size = $request->input('size') ?: config('size.models.'.$user->getTable(), config('size.common'));

		//view's variant
		$this->_size = $size;
		$this->_filters = $this->_getFilters($request);
		$this->_queries = $this->_getQueries($request);
		return $this->view('wechat::admin.wechat.user.list');
	}

	public function data(Request $request, Account $account)
	{
		$user = new WechatUser;
		$builder = $user->newQuery()->where('waid', $account->getAccountID());
		$total = $this->_getCount($request, $builder, FALSE);
		$data = $this->_getData($request, $builder);
		$data['recordsTotal'] = $total;
		$data['recordsFiltered'] = $data['total'];
		return $this->api($data);
	}

	public function export(Request $request, Account $account)
	{
		$user = new WechatUser;
		$builder = $user->newQuery()->where('waid', $account->getAccountID());
		$size = $request->input('size') ?: config('size.export', 1000);

		$data = $this->_getExport($request, $builder, function(&$v){
			$v['gender'] = !empty($v['gender']) ? $v['gender']['title'] : NULL;
		});
		return $this->api($data);
	}

	public function show($id, Account $account)
	{
		$user = WechatUser::find($id);
		if (empty($user))
			return $this->failure_noexists();

		$this->_data = $user;
		return $this->view('wechat::admin.wechat.user.show');
	}

	public function create()
	{
		$keys = 'openid,nickname,gender,avatar_aid,country,province,city,language,unionid,remark,is_subscribed,subscribed_at,uid';
		$this->_data = [];
		$this->_validates = $this->getScriptValidate('wechat-user.store', $keys);
		return $this->view('wechat::admin.wechat.user.create');
	}

	public function store(Request $request, Account $account)
	{
		$keys = 'openid,nickname,gender,avatar_aid,country,province,city,language,unionid,remark,is_subscribed,subscribed_at,uid';
		$data = $this->autoValidate($request, 'wechat-user.store', $keys);

		WechatUser::create($data + ['waid' => $account->getAccountID()]);
		return $this->success('', url('admin/wechat/user'));
	}

	public function edit($id)
	{
		$user = WechatUser::find($id);
		if (empty($user))
			return $this->failure_noexists();

		$keys = 'openid,nickname,gender,avatar_aid,country,province,city,language,unionid,remark,is_subscribed,subscribed_at,uid';
		$this->_validates = $this->getScriptValidate('wechat-user.store', $keys);
		$this->_data = $user;
		return $this->view('wechat::admin.wechat.user.edit');
	}

	public function update(Request $request, $id)
	{
		$user = WechatUser::find($id);
		if (empty($user))
			return $this->failure_noexists();

		$keys = 'openid,nickname,gender,avatar_aid,country,province,city,language,unionid,remark,is_subscribed,subscribed_at,uid';
		$data = $this->autoValidate($request, 'wechat-user.store', $keys);
		$user->update($data);
		return $this->success();
	}

	public function destroy(Request $request, $id)
	{
		empty($id) && !empty($request->input('id')) && $id = $request->input('id');
		$id = (array) $id;
		
		foreach ($id as $v)
			$user = WechatUser::destroy($v);
		return $this->success('', count($id) > 5, compact('id'));
	}
}
