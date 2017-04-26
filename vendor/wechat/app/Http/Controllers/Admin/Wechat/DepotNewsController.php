<?php
namespace Plugins\Wechat\App\Http\Controllers\Admin\Wechat;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Plugins\Wechat\App\WechatDepotNews;
use Plugins\Wechat\App\Tools\Account;
use Addons\Core\Controllers\ApiTrait;

class DepotNewsController extends Controller
{
	use ApiTrait;
	public $permissions = ['wechat-depot'];
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request, Account $account)
	{
		$news = new WechatDepotNews;
		$size = $request->input('size') ?: config('size.models.'.$news->getTable(), config('size.common'));

		//view's variant
		$this->_size = $size;
		$this->_filters = $this->_getFilters($request);
		$this->_queries = $this->_getQueries($request);
		return $this->view('wechat::admin.wechat.news.list');
	}

	public function data(Request $request, Account $account)
	{
		$news = new WechatDepotNews;
		$builder = $news->newQuery()->where('waid', $account->getAccountID());
		$total = $this->_getCount($request, $builder, FALSE);
		$data = $this->_getData($request, $builder);
		$data['recordsTotal'] = $total;
		$data['recordsFiltered'] = $data['total'];
		return $this->api($data);
	}

	public function export(Request $request, Account $account)
	{
		$news = new WechatDepotNews;
		$builder = $news->newQuery();
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
			return $this->failure_notexists();

		$keys = 'title,author,description,content,cover_aid,cover_in_content,redirect,url';
		$this->_validates = $this->getScriptValidate('wechat-news.store', $keys);
		$this->_data = $news;
		return $this->view('wechat::admin.wechat.news.edit');
	}

	public function update(Request $request, $id)
	{
		$news = WechatDepotNews::find($id);
		if (empty($news))
			return $this->failure_notexists();

		$keys = 'title,author,description,content,cover_aid,cover_in_content,redirect,url';
		$data = $this->autoValidate($request, 'wechat-news.store', $keys);
		$data['cover_in_content'] = isset($data['cover_in_content']) ? boolval($data['cover_in_content']): false;

		$news->update($data);
		return $this->success('', FALSE, $news->toArray());
	}

	public function destroy(Request $request, $id)
	{
		empty($id) && !empty($request->input('id')) && $id = $request->input('id');
		$ids = array_wrap($id);
		
		DB::transaction(function() use ($ids) {
			WechatDepotNews::destroy($ids);
		});
		return $this->success(null, true, ['id' => $ids]);
	}
}