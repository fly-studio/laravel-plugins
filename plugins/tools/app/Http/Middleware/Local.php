<?php
namespace Plugins\Tools\App\Http\Middleware;

use Closure;
use Addons\Core\Http\OutputResponseFactory;

class Local
{

	/**
	 * Create a new filter instance.
	 *
	 * @return void
	 */
	public function __construct()
	{

	}

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if ($_SERVER['REMOTE_ADDR'] != '127.0.0.1')
			return app(OutputResponseFactory::class)->failure('tools::tools.failure_local')->setRequest($request)->setStatusCode(403);

		return $next($request);
	}
}
