<?php

namespace Plugins\Socialite\App\Http\Controllers\Admin;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Plugins\Socialite\App\Repositories\SocialiteRepository;

class SocialiteController extends Controller
{
	//public $permissions = ['oauth'];

	protected $keys = ['name', 'socialite_type', 'client_id', 'client_secret', 'client_extra', 'default_role_id'];
	protected $repo;

	public function __construct(SocialiteRepository $repo)
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
		return $this->view('socialite::admin.socialite.list');
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
		$socialite = $this->repo->find($id);
		if (empty($socialite))
			return $this->error('document.not_exists')->code(404);

		$this->_data = $socialite;
		return !$request->offsetExists('of') ? $this->view('socialite::admin.socialite.show') : $this->api($socialite->toArray());
	}

	public function create(Request $request)
	{
		$this->_data = [];
		$this->_uid = $request->input('uid', null);
		$this->_validates = $this->censorScripts('socialite::socialite.store', $this->keys);
		return $this->view('socialite::admin.socialite.create');
	}

	public function store(Request $request)
	{
		$data = $this->censor($request, 'socialite::socialite.store', $this->keys);

		$socialite = $this->repo->store($data);
		return $this->success()->action('redirect', url('admin/socialite'));
	}

	public function edit($id)
	{
		$socialite = $this->repo->find($id);
		if (empty($socialite))
			return $this->error('document.not_exists')->code(404);

		$this->_validates = $this->censorScripts('socialite::socialite.store', $this->keys);
		$this->_data = $socialite;
		return $this->view('socialite::admin.socialite.edit');
	}

	public function update(Request $request, $id)
	{
		$socialite = $this->repo->find($id);
		if (empty($socialite))
			return $this->error('document.not_exists')->code(404);

		$data = $this->censor($request, 'socialite::socialite.store', $this->keys, $socialite->toArray());

		$socialite = $this->repo->update($socialite, $data);
		return $this->success();
	}

	public function destroy(Request $request, $id)
	{
		empty($id) && !empty($request->input('id')) && $id = $request->input('id');
		$ids = Arr::wrap($id);

		$this->repo->destroy($ids);
		return $this->success(null, ['id' => $ids]);
	}
}
