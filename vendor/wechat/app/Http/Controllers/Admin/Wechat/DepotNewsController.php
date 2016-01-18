<?php
namespace Plugins\Wechat\App\Http\Controllers\Admin\Wechat;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Plugins\Wechat\App\WechatDepotNews;
use Plugins\Wechat\App\Tools\Account;
use Addons\Core\Controllers\AdminTrait;

class DepotNewsController extends Controller
{
	use AdminTrait;
	public $RESTful_permission = 'wechat-depot';
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request, Account $account)
	{
		$news = new WechatDepotNews;
		$builder = $news->newQuery()->where('waid', $account->getAccountID());
		$pagesize = $request->input('pagesize') ?: config('site.pagesize.admin.'.$news->getTable(), $this->site['pagesize']['common']);
		$base = boolval($request->input('base')) ?: false;

		//view's variant
		$this->_base = $base;
		$this->_pagesize = $pagesize;
		$this->_filters = $this->_getFilters($request, $builder);
		$this->_table_data = $base ? $this->_getPaginate($request, $builder, ['*'], ['base' => $base]) : [];
		return $this->view('wechat::admin.wechat.news.'. ($base ? 'list' : 'datatable'));
	}

	public function data(Request $request, Account $account)
	{
		$news = new WechatDepotNews;
		$builder = $news->newQuery()->where('waid', $account->getAccountID());
		$_builder = clone $builder;$total = $_builder->count();unset($_builder);
		$data = $this->_getData($request, $builder);
		$data['recordsTotal'] = $total;
		$data['recordsFiltered'] = $data['total'];
		return $this->success('', FALSE, $data);
	}

	public function export(Request $request, Account $account)
	{
		$news = new WechatDepotNews;
		$builder = $news->newQuery();
		$page = $request->input('page') ?: 0;
		$pagesize = $request->input('pagesize') ?: config('site.pagesize.export', 1000);
		$total = $this->_getCount($request, $builder);

		if (empty($page)){
			$this->_of = $request->input('of');
			$this->_table = $news->getTable();
			$this->_total = $total;
			$this->_pagesize = $pagesize > $total ? $total : $pagesize;
			return $this->view('wechat::admin.wechat.news.export');
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
		$keys = 'title,author,description,content,cover_aid,cover_in_content,redirect,url';
		$this->_data = [];
		$this->_validates = $this->getScriptValidate('wechat-news.store', $keys);
		return $this->view('wechat::admin.wechat.news.create');
	}

	public function store(Request $request, Account $account)
	{
		$keys = 'title,author,description,content,cover_aid,cover_in_content,redirect,url';
		$data = $this->autoValidate($request, 'wechat-news.store', $keys);

		$news = WechatDepotNews::create($data + ['waid' => $account->getAccountID()]);
		return $this->success('', url('admin/wechat/depot-news'), $news->toArray());
	}

	public function edit($id)
	{
		$news = WechatDepotNews::find($id);
		if (empty($news))
			return $this->failure_noexists();

		$keys = 'title,author,description,content,cover_aid,cover_in_content,redirect,url';
		$this->_validates = $this->getScriptValidate('wechat-news.store', $keys);
		$this->_data = $news;
		return $this->view('wechat::admin.wechat.news.edit');
	}

	public function update(Request $request, $id)
	{
		$news = WechatDepotNews::find($id);
		if (empty($news))
			return $this->failure_noexists();

		$keys = 'title,author,description,content,cover_aid,cover_in_content,redirect,url';
		$data = $this->autoValidate($request, 'wechat-news.store', $keys);
		$news->update($data);
		return $this->success('', FALSE, $news->toArray());
	}

	public function destroy(Request $request, $id)
	{
		empty($id) && !empty($request->input('id')) && $id = $request->input('id');
		$id = (array) $id;
		
		foreach ($id as $v)
			$news = WechatDepotNews::destroy($v);
		return $this->success('', count($id) > 5, compact('id'));
	}
}