<?php
namespace Plugins\System\App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
class PasswordController extends Controller
{
	public function index(Request $request)
	{
		$keys = ['password'];
		$this->_validates = $this->censorScripts('member.store', $keys);
		$this->_data = Auth::user();
		return $this->view('system::admin.profile.password');
	}

	public function update(Request $request, $id)
	{
		$keys = ['password'];
		$data = $this->censor($request, 'member.store', $keys);
		$data['password'] = bcrypt($data['password']);
		Auth::user()->update($data);
		Auth::logout();
		return $this->success('', 'auth');
	}
}
