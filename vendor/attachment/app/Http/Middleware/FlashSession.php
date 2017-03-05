<?php

namespace Plugins\Attachment\App\Http\Middleware;

use Closure;
use Crypt, Session;

class FlashSession
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
		if(in_array($request->method(), array( 'POST', 'PUT', 'DELETE' )))
		{
			//解决flash上传的cookie问题
			if ($request->offsetExists('PHPSESSIONID'))
			{
				$session_id = Crypt::decrypt(trim($request->input('PHPSESSIONID')));
				if (!empty($session_id))
				{
					session_id($session_id);
					Session::setId($session_id);
				}
			}
		}
		return $next($request);
	}
}
