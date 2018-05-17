<?php

namespace Plugins\OAuth2\App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Lang
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		$session = session();
		$lang = session('locale');
		if (empty($lang) && $request instanceof Request)
		{
			$user = $request->user();
			if (!empty($user) && !empty($user->token())) // is API
				$lang = $user->token()->client->lang;
		}

		if (!empty($lang)) {
			$app = app();
			$locale = $app->getLocale();
			if ($locale == $lang)
				return $next($request);
			$app->setLocale($lang);
			$app['translator']->setFallback($locale);
			$app['ruler']->setFallback($locale);
		}

		return $next($request);
	}
}
