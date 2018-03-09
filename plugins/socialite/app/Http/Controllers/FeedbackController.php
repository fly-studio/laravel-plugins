<?php

namespace Plugins\Socialite\App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FeedController extends Controller {

	use AddonsTrait;

	public function index(Request $request, $nameOrId)
	{
		$user = $this->getSocialite($nameOrId)->user();
		dd($user);

		$accessTokenResponseBody = $user->accessTokenResponseBody;
	}
}
