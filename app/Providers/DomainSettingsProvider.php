<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Request;
use App\Models\Domain;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

class DomainSettingsProvider extends ServiceProvider
{

    protected function extractDomainCode($request)
    {
        $path = $request->path();
        // Split the path into segments
        $segments = explode('/', trim($path, '/'));
        // Get the first segment after the domain
        return $domain_code = isset($segments[0]) ? $segments[0] : null;
    }


    protected function initializeCustomFunction()
    {
        
      // Access the request using the helper
        $request = request();
        $host = $request->getHost();
        $fullUrl = $request->fullUrl();
        $domain_code = $this->extractDomainCode($request);
        $domain = $request->getHost();
/*         $domainRecord = Domain::where('domain', $domain)->first(); */
        $admin_domain = config('app.admin_domain');
        $main_domain = config('app.main_domain');
        Log::info('Site Hosted Domain ' . $domain);
        if($domain == $admin_domain){
            $domainRecord = Domain::where('domain_code', $domain_code)->first();
            Log::info('Main Domain ' . $domain_code);
            if ($domainRecord) {
                $tenant = $domainRecord->tenant;
                tenancy()->initialize($tenant);
                $siteUrl = 'http://' . $admin_domain . '/' . $domain_code;
                Log::info('Site Url ' . $siteUrl);
              /*   config(['app.site_url' => $siteUrl]); */
               /*  dd(url());
                return redirect()->to($siteUrl); */
                dd('here');
            } 
        }
        else{
            Log::info('Not Found Main Domain');
        }
    }

    protected function stopInvalidUrls()
    {

         // This will be executed after routes are initialized
         if (Route::current()) {
            $currentRouteName = Route::currentRouteName();
            // Your logic here
        }
        $flag = 0;
        $request = request();
        $host = $request->getHost();
        $fullUrl = $request->fullUrl();
        $domain_code = $this->extractDomainCode($request);
        $domain = $request->getHost();
        $admin_domain = config('app.admin_domain');
        $main_domain = config('app.main_domain');
        if($domain == $admin_domain){
           
            // Using Request to check the URL
            if (Request::is('login')) {
                $flag = 1;
            }
            else if(Request::is('/')) {
                $flag = 1;
            }
            if($flag == 1){
                if (Route::has('loginNotice')) {
                    return redirect()->route('loginNotice');
                } else {
                    return abort(404, 'Route not found.');
                }

            }
/*             dd('outer'); */
        }
        else if (strpos($domain, $main_domain) !== false) {
            // The string contains 'store.opiningstore.com'
                  // Using Request to check the URL
                if($domain == $main_domain){
                    if(Request::is('/')) {
                        $flag = 1;
                    }
                }
                if (Request::is('login')) {
                    $flag = 1;
                }
                if($flag == 1){
                    if (Route::has('loginNotice')) {
                        return redirect()->route('loginNotice');
                    } else {
                        return abort(404, 'Route not found.');
                    }

                }
            $domain = $request->getHost();
            $domainRecord = Domain::where('domain', $domain)->first();
            if (empty($domainRecord)) {
                return abort(404, 'Route not found.');
            }
        }
    }
        

     

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
       $this->stopInvalidUrls();
    }
}
