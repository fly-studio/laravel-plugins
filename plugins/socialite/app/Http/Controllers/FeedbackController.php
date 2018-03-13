<?php

namespace Plugins\Socialite\App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Plugins\Socialite\App\Repositories\SocialiteUserRepository;

class FeedbackController extends Controller {

	use AddonsTrait;

	public function index(Request $request, SocialiteUserRepository $repo, Auth $guard, $id)
	{
		try {
			$user = $this->getSocialite($id)->user();
		} catch (\Exception $e) {

		}

		if (empty($user) || empty($user->id))
			return $this->failure('socialite::socialite.user_invalid');

		$socialiteUser = $repo->storeFrom($id, $user);
		$user = $repo->attachToUser($socialiteUser->getKey());

		//login
		Auth::login($user, true);
		//redirect back
		return redirect()->intended('');
	}
}
