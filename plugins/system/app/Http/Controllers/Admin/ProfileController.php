<?php
namespace Plugins\System\App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use Auth;
use App\User;
use Addons\Core\ApiTrait;

class ProfileController extends Controller
{
	use ApiTrait;

	public function index()
	{
		$keys = ['nickname', 'realname', 'gender', 'email', 'phone', 'idcard', 'avatar_aid'];
		$this->_data = Auth::user();
		$this->_validates = $this->censorScripts('member.store', $keys);
		return $this->view('system::admin.profile.profile');
	}

	public function update(Request $request, $id)
	{
		$user = Auth::user();
		$keys = ['nickname', 'realname', 'gender', 'email', 'phone', 'idcard', 'avatar_aid'];
		$data = $this->censor($request, 'member.store', $keys, $user);
		$user->update($data);
		return $this->success();
	}

}
