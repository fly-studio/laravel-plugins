<?php

namespace Plugins\Socialite\App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FeedController extends Controller {

	use AddonsTrait;

	public function index(Request $request, $name)
	{
		$user = $this->getSocialite($name)->user();
		dd($user);

		$accessTokenResponseBody = $user->accessTokenResponseBody;
	}
}
