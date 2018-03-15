<?php

namespace Plugins\Socialite\App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Plugins\Socialite\App\Repositories\SocialiteRepository;
use Plugins\Socialite\App\Repositories\SocialiteUserRepository;

class FeedbackController extends Controller {

	use AddonsTrait;

	public function index(Request $request, SocialiteRepository $repo, SocialiteUserRepository $userRepo, $id)
	{
		try {
			$socialite = $repo->findOrFail($id);
			$user = $this->getSocialite($id)->user();
		} catch (\Exception $e) {

		}

		if (empty($socialite))
			return $this->failure('socialite::socialite.not_exists');

		if (empty($user) || empty($user->id))
			return $this->failure('socialite::socialite.user_invalid');

		$socialiteUser = $userRepo->storeFrom($socialite, $user);
		$user = $userRepo->attachToUser($socialiteUser, $socialite->default_role);

		//login
		Auth::login($user, true);
		//redirect back
		return redirect()->intended('');
	}
}
