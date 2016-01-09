<?php
namespace Plugins\Tools\App\Http\Middleware;

use Closure;
use Plugins\Tools\App;
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
		{
			return (new \Addons\Core\Controllers\Controller(false))->failure('tools::tools.failure_local', false, $request->all(), TRUE);
		}

		return $next($request);
	}
}
