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
		$keys = 'password';
		$this->_validates = $this->getScriptValidate('member.store', $keys);
		$this->_data = $this->user;
		return $this->view('system::admin.profile.password');
	}

	public function update(Request $request, $id)
	{
		$data = $this->autoValidate($request, 'member.store', 'password');
		$data['password'] = bcrypt($data['password']);
		$this->user->update($data);
		Auth::logout();
		return $this->success('', 'auth');
	}
}
