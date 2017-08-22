<?php
namespace Plugins\Wechat\App\Http\Controllers\Admin\Wechat;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Addons\Core\ApiTrait;

use Plugins\Wechat\App\WechatMenu;
use Plugins\Wechat\App\WechatAccount;
use Plugins\Wechat\App\Tools\Account;
use Plugins\Wechat\App\Tools\API;

class MenuController extends Controller
{
	use ApiTrait;
	public $permissions = ['wechat-menu'];

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request, Account $account)
	{
		$menu = new WechatMenu;
		$builder = $menu->newQuery()->with('children')->where('waid', $account->getAccountID())->where('pid', 0)->orderBy('order','ASC');

		//view's variant
		$this->_table_data = $this->_getPaginate($request, $builder, ['*']);
		return $this->view('wechat::admin.wechat.menu.list');
	}

	public function data(Request $request, Account $account)
	{
		$menu = new WechatMenu;
		$builder = $menu->newQuery()->with('children')->where('waid', $account->getAccountID())->where('pid', 0)->orderBy('order','ASC');
		$total = $this->_getCount($request, $builder, FALSE);
		$data = $this->_getData($request, $builder);
		$data['recordsTotal'] = $total;
		$data['recordsFiltered'] = $data['total'];

		return $this->api($data);
	}

	public function show($id)
	{
		return '';
	}

	public function store(Request $request, Account $account)
	{
		$pid = $request->input('pid');
		$menus = WechatMenu::with('children')->where('waid', $account->getAccountID())->where('pid', $pid)->orderBy('order','ASC')->get();
		if ((empty($pid) && count($menus) >= 3) || (!empty($pid) && count($menus) >= 5)) //已经超出了
			return $this->failure('wechat.failure_menu_overflow');

		$keys = 'title,pid,type,event,url,wdid';
		$data = $this->censor($request, 'wechat::wechat-menu.store', $keys);

		$menu = WechatMenu::create($data + ['waid' => $account->getAccountID(), 'order' => intval($menus->max('order')) + 1]);
		$menu->event_key = 'key-' . $menu->getKey();$menu->save();
		return $this->success('', FALSE, $menu->toArray());
	}

	public function update(Request $request, $id)
	{
		$menu = WechatMenu::find($id);
		if (empty($menu))
			return $this->failure_notexists();

		$keys = 'title,type,event,url,wdid';
		$data = $this->censor($request, 'wechat::wechat-menu.store', $keys);

		$menu->update($data);
		return $this->success('', FALSE, $menu->toArray());
	}

	public function destroy(Request $request, $id)
	{
		empty($id) && !empty($request->input('id')) && $id = $request->input('id');
		$ids = array_wrap($id);

		DB::transaction(function() use ($ids) {
			WechatMenu::destroy($ids);
		});
		return $this->success(null, true, ['id' => $ids]);
	}

	public function publishQuery(Request $request, Account $account)
	{
		if (!empty($request->input('id')))
		{
			$id = $request->input('id');
			$id = (array) $id;
			foreach ($id as $v)
				WechatMenu::destroy($v);
		}

		return $this->publishToWechat($account);
	}

	public function readJson(Account $account)
	{
		$account = WechatAccount::findOrFail($account->getAccountID());
		$api = new API($account->toArray(), $account->getKey());
		$data = $api->getMenu();
		if (empty($data))
			return $this->failure('wechat::wechat.menu_get_failure', FALSE, ['error_no' => $api->errCode, 'error_message' => $api->errMsg]);
		else
			return $this->success('', false, $data);
	}

	public function publishToWechat(Account $account)
	{
		$menu_data = ['button'=>[]];
		$menulist = WechatMenu::with('children')->newQuery()->where('waid', $account->getAccountID())->where('pid', 0)->orderBy('order', 'ASC')->get();

		foreach ($menulist as $menu)
		{
			$menu_item_data = [];
			if($menu->children->count() > 0) //有子项
			{
				$menu_item_data['name'] = $menu->title;
				foreach ($menu->children as $sub_menu)
					$menu_item_data['sub_button'][] = $this->getMenuData($sub_menu);
			}
			else
				$menu_item_data = $this->getMenuData($menu);

			$menu_data['button'][]= $menu_item_data;
		}

		$account = WechatAccount::findOrFail($account->getAccountID());
		$api = new API($account->toArray(), $account->getKey());

		if($menulist->count() <= 0 ? $api->deleteMenu() : $api->createMenu($menu_data))
			return $this->success('wechat::wechat.menu_created_success', TRUE, $menu_data);
		else
			return $this->failure('wechat::wechat.menu_created_failure', FALSE, ['error_no' => $api->errCode, 'error_message' => $api->errMsg]);
	}

	public function publishJson(Request $request, Account $account)
	{
		$keys = 'content';
		$data = $this->censor($request, 'wechat::wechat-menu.store', $keys);

		$json = json_decode($data['content'], true);
		if (empty($json) || empty($json['button']))
			return $this->failure('wechat::wechat.menu_json_failure');
		else {
			$account = WechatAccount::findOrFail($account->getAccountID());
			$api = new API($account->toArray(), $account->getKey());

			if($api->createMenu($json))
				return $this->success('wechat::wechat.menu_created_success', TRUE, $json);
			else
				return $this->failure('wechat::wechat.menu_created_failure', FALSE, ['error_no' => $api->errCode, 'error_message' => $api->errMsg]);
		}
	}

	public function deleteAll(Account $account)
	{
		$account = WechatAccount::findOrFail($account->getAccountID());
		$api = new API($account->toArray(), $account->getKey());
		if ($api->deleteMenu())
			return $this->success('wechat::wechat.menu_deleted_success');
		else
			return $this->failure('wechat::wechat.menu_deleted_failure', FALSE, ['error_no' => $api->errCode, 'error_message' => $api->errMsg]);
	}

	private function getMenuData(WechatMenu $menu)
	{
		$result = [
			'name' => $menu->title,
			'type' => $menu->type,
		];
		switch($menu->type) {
			case 'view':
				$result['url'] = $menu->url;
				break;
			case 'click':
				$result['key'] = $menu->event_key;
				break;
			case 'event':
				$result['key'] = $menu->event_key;
				$result['type'] = $menu->event;
				break;
		}
		return $result;
	}
}
