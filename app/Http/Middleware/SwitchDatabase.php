<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SwitchDatabase
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

/*         $getSiteHost = getSiteHost($request); */

        if (session()->has('tenancy_db_name')) {
            $tenancy_db_name = session('tenancy_db_name');

            // Update the tenant database connection details dynamically
            config(['database.connections.mysql.database' => $tenancy_db_name]);

            // Set the tenant connection as the default connection for the current session
            DB::purge('mysql'); // Clears any cached database configuration
            DB::reconnect('mysql'); // Reconnect to the tenant's database
            // Optionally, set the default connection for all queries
            DB::setDefaultConnection('mysql');
                }
        return $next($request);
    }
}
