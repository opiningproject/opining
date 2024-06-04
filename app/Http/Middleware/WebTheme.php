<?php

namespace App\Http\Middleware;

use Closure;

class WebTheme
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
		if($request->session()->has('theme'))
		{
			//Check session request and determine localizaton
			//session('currency');
		}
		else
		{

			\Session::put('theme', 'light');
		}

		//echo $request->session()->get('currency');
		//exit;
		
        return $next($request);
    }
}
