<?php

namespace Plugins\Socialite\App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller {

	use AddonsTrait;

	public function index(Request $request, $id)
	{
		return $this->getSocialite($id)->redirect();
	}
}
