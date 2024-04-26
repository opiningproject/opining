<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $guards = empty($guards) ? [null] : $guards;

//        dd($request->getRequestUri());
        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
//                if(!){
                    if($request->user()->user_role != '0'){
                        return redirect(url()->previous());
                    }
//                }
            }
        }

        return $next($request);
    }
}
