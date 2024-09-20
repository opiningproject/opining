<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;
use PHPOpenSourceSaver\JWTAuth\Http\Middleware\BaseMiddleware;

class JwtMiddleware extends BaseMiddleware
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
        try 
        {
            $user = JWTAuth::parseToken()->authenticate();

            /*if($user->status == 0)
            {
                return response()->json(['status' => '3','message' => trans('api.user_account_inactive')], 401);
            }*/
        } 
        catch (Exception $e) 
        {
            if ($e instanceof \PHPOpenSourceSaver\JWTAuth\Exceptions\TokenInvalidException)
            {
                return response()->json(['status' => '2','message' => 'Token is Invalid']);
            }
            else if ($e instanceof \PHPOpenSourceSaver\JWTAuth\Exceptions\TokenExpiredException)
            {
                return response()->json(['status' => '2','message' => 'Token is Expired']);
            }
            else
            {
                return response()->json(['status' => '2','message' => 'Authorization Token not found']);
            }
        }
        return $next($request);
    }
}
