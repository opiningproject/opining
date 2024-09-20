<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class CheckMyFinanceValidate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
//        dd($request->get('myFinanceIsValidate'));
        if (Session::get('myFinanceIsValidate') == 1) {
//            return redirect('payments');
            return $next($request);

        } else {
            return redirect()->route('validateMyFinance');
        }

    }
}
