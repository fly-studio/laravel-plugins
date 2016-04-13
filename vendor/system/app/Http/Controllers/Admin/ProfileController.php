<?php
namespace Plugins\System\App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use Addons\Core\Controllers\AdminTrait;

class ProfileController extends Controller
{
	use AdminTrait;

	public function index()
	{
		$keys = 'nickname,realname,gender,email,phone,idcard,avatar_aid';
		$this->_data = $this->user;
		$this->_validates = $this->getScriptValidate('member.store', $keys);
		return $this->view('system::admin.profile.profile');
	}

	public function update(Request $request, $id)
	{
		$keys = 'nickname,realname,gender,email,phone,idcard,avatar_aid';
		$data = $this->autoValidate($request, 'member.store', $keys, $this->user);
		$this->user->update($data);
		return $this->success();
	}

}
