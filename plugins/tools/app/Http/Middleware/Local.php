<?php
namespace Plugins\Tools\App\Http\Middleware;

use Closure;
use Addons\Core\Http\OutputResponse;

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
			return (new OutputResponse)->setRequest($request)->setResult('failure')->setMessage('tools::tools.failure_local')->setStatusCode(403);

		return $next($request);
	}
}
