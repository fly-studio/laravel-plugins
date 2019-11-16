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
		$schema = $request->input('schema');

		if (!empty($schema))
		{
			return redirect(url('socialite/app-redirect').'?'.$request->getQueryString());
		}

		try {
			$socialite = $repo->findOrFail($id);
			$user = $this->getSocialite($id)->user();
		} catch (\Exception $e) {

		}

		if (empty($socialite))
			return $this->error('socialite::socialite.not_exists');

		if (empty($user) || empty($user->id))
			return $this->error('socialite::socialite.user_invalid');

		$socialiteUser = $userRepo->storeFrom($socialite, $user);
		$user = $userRepo->attachToUser($socialiteUser, $socialite->default_role);

		//login
		Auth::login($user, true);
		//redirect back
		return redirect()->intended('');
	}

	public function appRedirect(Request $request)
	{
		$schema = $request->input('schema');
		$redirect_uri = $request->input('redirect_uri');

		$request->offsetUnset('schema');
		$request->offsetUnset('redirect_uri');

		$redirect_uri .= (strpos($redirect_uri, '?') === false ? '?' : '&') . http_build_query($request->query->all());

		if (empty($schema))
			abort(404, 'No schema');

		$this->_schema = $schema. (strpos($schema, '?') === false ? '?' : '&').'redirect_uri=' . urlencode($redirect_uri);

		return $this->view('socialite::app-redirect');
	}
}
