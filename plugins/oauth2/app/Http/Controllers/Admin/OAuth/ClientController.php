<?php

namespace Plugins\OAuth2\App\Http\Controllers\Admin\OAuth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Plugins\OAuth2\App\Repositories\ClientRepository;

class ClientController extends Controller
{
	//public $permissions = ['oauth'];

	protected $keys = ['name', 'redirect', 'callback', 'user_id', 'personal_access_client', 'password_client', 'revoked'];
	protected $repo;

	public function __construct(ClientRepository $repo)
	{
		$this->repo = $repo;
	}
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$size = $request->input('size') ?: $this->repo->prePage();
		//view's variant
		$this->_size = $size;
		$this->_filters = $this->repo->_getFilters($request);
		$this->_queries = $this->repo->_getQueries($request);
		return $this->view('oauth2::admin.oauth.client.list');
	}

	public function data(Request $request)
	{
		$data = $this->repo->data($request);
		return $this->api($data);
	}

	public function export(Request $request)
	{
		$data = $this->repo->export($request);
		return $this->office($data);
	}

	public function show(Request $request, $id)
	{
		$oAuth = $this->repo->find($id);
		if (empty($oAuth))
			return $this->failure_notexists();

		$this->_data = $oAuth;
		return !$request->offsetExists('of') ? $this->view('oauth2::admin.oauth.client.show') : $this->api($oAuth->toArray());
	}

	public function create(Request $request)
	{
		$this->_data = [];
		$this->_uid = $request->input('uid', null);
		$this->_validates = $this->censorScripts('oauth2::client.store', $this->keys);
		return $this->view('oauth2::admin.oauth.client.create');
	}

	public function store(Request $request)
	{
		$data = $this->censor($request, 'oauth2::client.store', $this->keys);

		$oAuth = $this->repo->store($data);
		return $this->success('', url('admin/oauth/client'));
	}

	public function edit($id)
	{
		$oAuth = $this->repo->find($id);
		if (empty($oAuth))
			return $this->failure_notexists();

		$this->_validates = $this->censorScripts('oauth2::client.store', $this->keys);
		$this->_data = $oAuth;
		return $this->view('oauth2::admin.oauth.client.edit');
	}

	public function update(Request $request, $id)
	{
		$oAuth = $this->repo->find($id);
		if (empty($oAuth))
			return $this->failure_notexists();

		$data = $this->censor($request, 'oauth2::client.store', array_diff($this->keys, ['user_id']), $oAuth);

		$oAuth = $this->repo->update($oAuth, $data);
		return $this->success();
	}

	public function destroy(Request $request, $id)
	{
		empty($id) && !empty($request->input('id')) && $id = $request->input('id');
		$ids = array_wrap($id);

		$this->repo->destroy($ids);
		return $this->success(null, true, ['id' => $ids]);
	}
}
