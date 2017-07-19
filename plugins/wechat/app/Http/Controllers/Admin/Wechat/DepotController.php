<?php
namespace Plugins\Wechat\App\Http\Controllers\Admin\Wechat;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Plugins\Wechat\App\WechatAccount;
use Plugins\Wechat\App\WechatDepot;
use Plugins\Wechat\App\Tools\Account;
use Addons\Core\ApiTrait;

class DepotController extends Controller
{
	use ApiTrait;
	public $permissions = ['wechat-depot'];
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	private $types = ['news','text','image','callback','video','voice','music'];

	public function index(Request $request, Account $account)
	{
		return $this->view('wechat::admin.wechat.depot.list');
	}

	public function data(Request $request, Account $account)
	{
		$type = $request->input('f.type') ?: ['news','text','image','callback','video','voice','music'];
		$depot = new WechatDepot;
		$builder = $depot->newQuery()->with($type)->where('waid', $account->getAccountID());
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
		$keys = 'type';
		$data = $this->censor($request, 'wechat-depot.store', $keys);

		$depot = WechatDepot::create($data + ['waid' => $account->getAccountID()]);

		if ($data['type'] == 'news')
			$this->storeNews($request, $depot, $data['type']);
		else
			$this->storeOther($request, $depot, $data['type'], true);
		return $this->success('', FALSE, ['isCreated' => true, 'type' => $depot->type]);
	}

	public function update(Request $request, $id)
	{
		$depot = WechatDepot::find($id);
		if (empty($depot))
			return $this->failure_notexists();

		if ($depot->type == 'news')
			$this->storeNews($request, $depot, $depot->type, false);
		else
			$this->storeOther($request, $depot, $depot->type, false);
		return $this->success('', FALSE, ['isCreated' => false, 'type' => $depot->type]);
	}

	private function storeNews(Request $request, WechatDepot &$depot, $type)
	{
		$keys = 'wdnid';
		$data = $this->censor($request, 'wechat-depot.store', $keys);
		$depot->news()->detach();
		$depot->news()->sync($data['wdnid']);
		//$depot->news; //read relation
	}

	private function storeOther(Request $request, WechatDepot &$depot, $type, $create)
	{
		$keys = '';
		switch ($type) {
			case 'callback':
				$keys = 'callback';
				break;
			case 'text':
				$keys = 'content';
				break;
			case 'music':
			case 'video':
				$keys = 'title,description,size,aid,thumb_aid,format';
				break;
			case 'voice':
				$keys = 'title,size,aid,format';
			case 'image':
				$keys = 'title,size,aid';
				break;
		}
		$data = $this->censor($request, 'wechat-depot.store', $keys);
		$create ? $depot->$type()->create($data) :  $depot->$type()->update($data);
		//$depot->$type;//read relation
	}

	public function destroy(Request $request, $id)
	{
		empty($id) && !empty($request->input('id')) && $id = $request->input('id');
		$ids = array_wrap($id);
		
		DB::transaction(function() use ($ids) {
			WechatDepot::destroy($ids);
		});
		return $this->success('', FALSE);
	}
}
