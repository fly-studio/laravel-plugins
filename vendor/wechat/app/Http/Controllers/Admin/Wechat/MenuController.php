<?php
namespace Plugins\Wechat\App\Http\Controllers\Admin\Wechat;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Addons\Core\Controllers\AdminTrait;

use Plugins\Wechat\App\WechatMenu;
use Plugins\Wechat\App\WechatAccount;
use Plugins\Wechat\App\Tools\Account;
use Plugins\Wechat\App\Tools\API;

class MenuController extends Controller
{
	use AdminTrait;
	//public $RESTful_permission = 'wechat-menu';
	
	public function __construct()
	{
		parent::__construct();
	}
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
		$_builder = clone $builder;$total = $_builder->count();unset($_builder);
		$data = $this->_getData($request, $builder);
		$data['recordsTotal'] = $total;
		$data['recordsFiltered'] = $data['total'];
		
		return $this->success('', FALSE, $data);
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
		$data = $this->autoValidate($request, 'wechat-menu.store', $keys);

		$menu = WechatMenu::create($data + ['waid' => $account->getAccountID(), 'order' => count($menus) + 1]);
		$menu->event_key = 'key-' . $menu->getKey();$menu->save();
		return $this->success('', url('admin/wechat/menu'));
	}

	public function update(Request $request, $id)
	{
		$menu = WechatMenu::find($id);
		if (empty($menu))
			return $this->failure_noexists();

		$keys = 'title,type,event,url,wdid';
		$data = $this->autoValidate($request, 'wechat-menu.store', $keys);

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
	
	public function takeEffect(Account $account)
	{
// 	    $menu_data = array (
// 	        'button' => array (
// 	            0 => array (
// 	                'name' => '新品特惠',
// 	                'sub_button' => array (
// 	                    0 => array (
// 	                        'type' => 'view',
// 	                        'name' => '优惠列表',
// 	                        'url' => 'http://www.hanpaimall.com/m/classify',
// 	                    ),
// 	                ),
// 	            ),
// 	            1 => array (
// 	                'type' => 'view',
// 	                'name' => '汉派商城',
// 	                'url' => 'http://www.hanpaimall.com/m',
	                 
// 	            ),
// 	            2 => array (
// 	                'name' => '我的中心',
// 	                'sub_button' => array (
// 	                    0 => array (
// 	                        'type' => 'view',
// 	                        'name' => '管理中心',
// 	                        'url' => 'http://www.hanpaimall.com/auth',
// 	                    ),
// 	                    1 => array (
// 	                        'type' => 'view',
// 	                        'name' => '个人中心',
// 	                        'url' => 'http://www.hanpaimall.com/m/ucenter',
// 	                    )
// 	                )
// 	            )
// 	        )
// 	    );
	    $menu_data = ['button'=>[]];
	    $menulist = WechatMenu::with('children')->newQuery()->where('waid', $account->getAccountID())->where('pid',0)->orderBy('order','asc')->get();

	    foreach ($menulist as $menu)
	    {
	        $menu_item_data = [];
	        if($menu->children->count()>0){
	            $menu_item_data['name'] = $menu->title;
	            foreach ($menu->children as $sub_menu)
	            {
	                $menu_item_data['sub_button'][] = ['type'=>'view','name'=>$sub_menu->title,'url'=>$sub_menu->url];
	            } 
	        }else{
	            $menu_item_data = ['type'=>'view','name'=>$menu->title,'url'=>$menu->url];
	        }
	        $menu_data['button'][]= $menu_item_data;
	    }
//           var_export($menu_data);exit;
	    $account = WechatAccount::findOrFail($account->getAccountID());
	    $api = new API($account->toArray(), $account->getKey());
	    if($api->createMenu($menu_data)){
	        return $this->success('wechat::wechat.menu_create_succerss', url('admin/wechat/menu'));
	    }else{
	        return $this->failure('wechat::wechat.menu_create_failure', url('admin/wechat/menu'));
	    }
	}
}
