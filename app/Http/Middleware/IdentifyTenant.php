<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Domain;
use Symfony\Component\HttpFoundation\Response;

class IdentifyTenant
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $domain = $request->getHost();
        $domainRecord = Domain::where('domain', $domain)->first();
      
        if ($domainRecord) {
            $tenant = $domainRecord->tenant;
            tenancy()->initialize($tenant);
      
        } else {
            // Handle the case where the domain does not match any tenant
            //abort(404, 'Tenant not found for the given domain');
         
        }
/*         dd('here'); */
        return $next($request);
    }
}
