<?php

namespace Plugins\OAuth2\App\Http\Middleware;

use Closure;

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

		if ($session->has('locale')) {
			$app = app();
			$locale = $app->getLocale();
			$app->setLocale(session('locale'));
			$app['translator']->setFallback($locale);
			$app['ruler']->setFallback($locale);
		}

		return $next($request);
	}
}
