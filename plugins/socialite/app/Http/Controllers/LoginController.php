<?php

namespace Plugins\Socialite\App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Plugins\Socialite\App\Socialite;

class LoginController extends Controller {

	use AddonsTrait;

	public function index(Request $request, $nameOrId)
	{
		return $this->getSocialite($nameOrId)->redirect();
	}
}
