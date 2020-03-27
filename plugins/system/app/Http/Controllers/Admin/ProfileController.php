<?php

namespace Plugins\System\App\Http\Controllers\Admin;

use Auth;
use Addons\Core\ApiTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;

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
		$data = $this->censor($request, 'member.store', $keys, $user->toArray());
		$user->update($data);
		return $this->success();
	}

}
