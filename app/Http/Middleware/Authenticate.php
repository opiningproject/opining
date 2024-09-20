<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if($request->route()->action['prefix'] == '/user'){
            return $request->expectsJson() ? null : route('user.home');
        }else{
            return $request->expectsJson() ? null : route('login');
        }
//        dd( $request->route()->action['prefix']);
    }
}
