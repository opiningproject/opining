<?php

namespace App\Http\Middleware;

use Closure;

class WebLocalization
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
		$available_lang = config('params.available_lang');

		if($request->session()->has('Accept-Language'))
		{
			//Check session request and determine localizaton
			$local = session('Accept-Language');
		}
		else
		{
			$local = 'en';
		}

		if(in_array($local, $available_lang))
		{
			//set localization
			app()->setLocale($local);
		}
		else
		{
			//set default localization
			app()->setLocale('en');
		}

        return $next($request);
    }
}
