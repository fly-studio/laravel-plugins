<?php
namespace Plugins\Tools\App\Http\Controllers;

use Addons\Core\Controllers\Controller;
use Illuminate\Http\Request;
use Plugins\Tools\App\Manual;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Addons\Core\Validation\ValidatesRequests;
class ManualController extends Controller
{
	use DispatchesJobs, ValidatesRequests;
	public function index()
	{
		$this->_menu = (new Manual)->getNode(0)->getChildren();
		return $this->view('tools::manual.index');
	}

	public function create(Request $request)
	{
		$keys = 'title,content,pid';
		$this->_data = [];
		$this->_tree = (new Manual)->getNode(0)->getTree(['id','pid', 'title', 'level'], false);
		$this->_validates = $this->getScriptValidate('manual.store', $keys);
		return $this->view('tools::manual.create');
	}

	public function show(Request $request, $id)
	{
		$data = (new Manual)->getNode($id);
		if (empty($data)) return $this->failure_notexists();

		$this->_data = $data;
		$this->_parents = $this->_data->getParents(['id','pid','title']);
		$this->_root = $this->_data->getRoot(['id','pid','title']);
		$this->_tree = $this->_root->getTree(['id','pid','title'], false);
		return $this->view('tools::manual.show');
	}

	public function store(Request $request)
	{
		$keys = 'title,content,pid';
		$data = $this->autoValidate($request, 'manual.store', $keys);

		$manual = Manual::create($data);
		return $this->success('', url('manual/' . $manual->getKey()));
	}

	public function edit(Request $request, $id)
	{
		$keys = 'title,content,pid';
		$this->_data = Manual::findOrFail($id);
		$this->_tree = (new Manual)->getNode(0)->getTree(['id','pid', 'title', 'level'], false);
		$this->_validates = $this->getScriptValidate('manual.store', $keys);
		return $this->view('tools::manual.edit');
	}

	public function update(Request $request, $id)
	{
		$manual = Manual::findOrFail($id);
		$keys = 'title,content,pid';
		$data = $this->autoValidate($request, 'manual.store', $keys);

		$manual->update($data);
		return $this->success('', url('manual/' . $manual->getKey())); 
	}

	
}