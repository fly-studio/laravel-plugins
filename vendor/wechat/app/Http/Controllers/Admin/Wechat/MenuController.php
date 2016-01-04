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
	public $pid;
	
	public function __construct()
	{
		parent::__construct();
		$this->pid = session('wechat-menu-pid');
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request, Account $account)
	{
		$this->pid = $request->get('pid',0); 
		session(['wechat-menu-pid'=>$this->pid]);
		$menu = new WechatMenu;
		$builder = $menu->newQuery()->where('waid', $account->getAccountID())->where('pid',$this->pid)->orderBy('order','asc');
		$pagesize = $request->input('pagesize') ?: config('site.pagesize.admin.'.$menu->getTable(), $this->site['pagesize']['common']);
		$base = boolval($request->input('base')) ?: false;

		//view's variant
		$this->_base = $base;
		$this->_pagesize = $pagesize;
		$this->_filters = $this->_getFilters($request, $builder);
		$this->_table_data = $base ? $this->_getPaginate($request, $builder, ['*'], ['base' => $base]) : [];
		return $this->view('wechat::admin.wechat.menu.'. ($base ? 'list' : 'datatable'));
	}

	public function data(Request $request, Account $account)
	{
		$menu = new WechatMenu;
		$builder = $menu->newQuery()->where('waid', $account->getAccountID())->where('pid',$this->pid)->orderBy('order','asc');
		$_builder = clone $builder;$total = $_builder->count();unset($_builder);
		$data = $this->_getData($request, $builder);
		$data['recordsTotal'] = $total;
		$data['recordsFiltered'] = $data['total'];
		
		return $this->success('', FALSE, $data);
	}

	public function export(Request $request, Account $account)
	{
		$menu = new WechatMenu;
		$page = $request->input('page') ?: 0;
		$pagesize = $request->input('pagesize') ?: config('site.pagesize.export', 1000);
		$total = $menu::count();

		if (empty($page)){
			$this->_of = $request->input('of');
			$this->_table = $menu->getTable();
			$this->_total = $total;
			$this->_pagesize = $pagesize > $total ? $total : $pagesize;
			return $this->view('wechat::admin.wechat.menu.export');
		}

		$builder = $menu->newQuery()->where('waid', $account->getAccountID())->where('pid',$this->pid);
		$data = $this->_getExport($request, $builder);
		return $this->success('', FALSE, $data);
	}

	public function show($id)
	{
		return '';
	}

	public function create(Request $request)
	{
		$this->pid = $request->get('pid',0);
		session(['wechat-menu-pid'=>$this->pid]);
		$menu = WechatMenu::find($this->pid);

		$keys = 'title,url,order';
		$this->_data = $menu?['upname'=>$menu->title,'pid'=>$this->pid]:[];
		$this->_validates = $this->getScriptValidate('wechat-menu.store', $keys);
		return $this->view('wechat::admin.wechat.menu.create');
	}

	public function store(Request $request, Account $account)
	{
		$keys = 'title,url,order';
		$data = $this->autoValidate($request, 'wechat-menu.store', $keys);

		WechatMenu::create($data + ['waid' => $account->getAccountID(),'type' => 'view','pid' => $this->pid]);
		return $this->success('', url('admin/wechat/menu'));
	}

	public function edit($id)
	{
		$menu = WechatMenu::with(['parent'])->find($id);
		if (empty($menu))
			return $this->failure_noexists();

		$keys = 'title,url,order';
		$this->_validates = $this->getScriptValidate('wechat-menu.store', $keys);
		$this->_data = $menu;
		return $this->view('wechat::admin.wechat.menu.edit');
	}

	public function update(Request $request, $id)
	{
		$menu = WechatMenu::find($id);
		if (empty($menu))
			return $this->failure_noexists();

		$keys = 'title,url,order';
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
