<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Tenant;
use App\Models\Domain;
use App\Models\RestaurantUser;
use Illuminate\Support\Facades\Auth;
use Redirect,Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
// Using the Session facade
use Illuminate\Support\Facades\Session;


class MainController extends Controller
{
    public function loginNotice(Request $request)
    {
       /*  dd('here'); */
        /* abort(404, 'Please Login your admin panel.'); */
        return view('errors.loginNotice', [
        ]);
    }


    public function panelRegistration(Request $request)
    {
        $domain = $request->getHost();
        $main_domain = config('app.main_domain');
        /* dd($domain); */
        if($domain == $main_domain){
           
            return view('auth.panel-registration', [
            ]);
        }
        else{
            abort(404, 'Tenant not found for the given domain');
        }
    }


    protected function extractDomainCode($request)
    {
        $path = $request->path();
        // Split the path into segments
        $segments = explode('/', trim($path, '/'));
        // Get the first segment after the domain
        return $domain_code = isset($segments[0]) ? $segments[0] : null;
    }


    protected function configureTenantDatabase($databaseName)
{
    // Update the tenant database connection details dynamically
    config(['database.connections.mysql.database' => $databaseName]);

    // Set the tenant connection as the default connection for the current session
    DB::purge('mysql'); // Clears any cached database configuration
    DB::reconnect('mysql'); // Reconnect to the tenant's database
    // Optionally, set the default connection for all queries
    DB::setDefaultConnection('mysql');
}


    public function restaurantAdminLogin(Request $request,$domain_code)
    {
        // if (Auth::check()) {
        //     return redirect('/dashboard'); // Adjust this path as needed
        // } elseif($request->input('token')) {
        //     $authToken = $request->input('token');
        //     $authData = json_decode(base64_decode($authToken), true);
        //     if(isset($authData['email'])) {
        //         $tuser = User::where('email', $authData['email'])->first();
        //         if ($tuser) {
        //             Auth::login($tuser);
        //             return redirect('/dashboard');
        //         }
        //     }
        // }
        $host = $request->getHost();
        $domain_code = $this->extractDomainCode($request);
        $admin_domain = config('app.admin_domain');
        $tenancy_db_name = '';
        Log::info('Site Hosted Domain: ' . $host);
        // Check if the request is to the admin domain
       /*  if ($host == $admin_domain) { */
            // Look for the domain record using the domain code
            $domainRecord = Domain::where('domain_code', $domain_code)->first();
            Log::info('Main Domain: ' . $domain_code);
            if ($domainRecord) {
                Log::info('Domain ID : ' . $domainRecord->id);
                $tenant = $domainRecord->tenant;
                $tenancy_db_name = $tenant->tenancy_db_name;
                Log::info('tenancy_db_name ' . $tenancy_db_name);
                $this->configureTenantDatabase($tenancy_db_name);
                tenancy()->initialize($tenant);
                // Optionally set the site URL
                $siteUrl = 'http://' . $admin_domain . '/' . $domain_code;
                Log::info('Site Url: ' . $siteUrl);
            } else {
                // Handle case when domain record is not found
                Log::error('No tenant found for domain code: ' . $domain_code);
          
            }
       /*  } else {
            // Handle case when the domain does not match the admin domain
            Log::warning('Request to non-admin domain: ' . $host);
        } */
  
        if ($request->isMethod('post')) {
            // Validate the login credentials
            $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);
            $user = User::where('email', $request->email)->first();
            Log::info('Login Email ' . $request->email);
            if ($user) {
                if (Auth::attempt(['email' => $user->email, 'password' => $request->input('password')])) {
                    Auth::login($user);
                    Session::put('tenancy_db_name', $tenancy_db_name);
                    Session::put('tenancy_domain_code', $domain_code);
                    return redirect()->intended('dashboard'); // Redirect to intended page
                /*  $redirectUrl = 'http://' . $admin_domain . '/dashboard';
                    return redirect()->to($redirectUrl); */
                } else {
                    return back()->withErrors(['password' => 'Invalid credentials']);
                    Log::info('Invalid credentials');
                }
            } else {
                Log::info('User is not found');
                return back()->withErrors(['email' => 'Either the email or password is incorrect.']);
            }
        }   
        return view('auth.restaurant-admin-login', compact('domain_code'));
    }


/*     public function adminPanel(Request $request)
    {
        $domain = $request->getHost();
        $admin_domain = config('app.admin_domain');
      
        if($domain == $admin_domain){
           
            return view('auth.panel-registration', [
            ]);
        }
        else{
            abort(404, 'Tenant not found for the given domain');
        }
    } */

    public function storePanelRegistration(Request $request)
    {
        
        // Validation rules
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'restaurant_name' => 'required|string|max:255|unique:restaurant_users',
            'user_email' => 'required|string|email|max:255|unique:restaurant_users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $domain_code = $randomNumberString = generateUniqueFourDigitNumber();
        $main_domain = config('app.main_domain');
        $randomSubDomain = $randomNumberString . '.' . $main_domain;
        
        // Check for validation errors
        if ($validator->fails()) {
            return redirect()->back()
                                ->withErrors($validator)
                                ->withInput();
        }
        // Attempt to create the user
        try {
            $user = [];
            $newDomain = $randomSubDomain;
            $restaurant_name = $request->restaurant_name;
            $tenant = Tenant::create(['id' => $newDomain]);
            $tenant->domains()->create(['domain' => $newDomain]);
            if(!empty($tenant)){
                $domain = $request->getHost();
                $domainRecord = Domain::where('domain', $newDomain)->first();
                if ($domainRecord) {
                    $domainRecord->update([
                        'domain_code' => $domain_code
                    ]);
                    $tenant = $domainRecord->tenant;
                    tenancy()->initialize($tenant);
                    $user = User::create([
                        'first_name' => $request->name,
                        'last_name' => '',
                        'email' => $request->user_email,
                        'password' => Hash::make($request->password),
                        'user_role' => '1',
                        'created_at' => date('Y-m-d h:i:s'),
                        'updated_at' => date('Y-m-d h:i:s')
                    ]); 
                    
                } 
            }
            if(!empty($user)){

                DB::table('restaurant_details')->insert([
                    'user_id' => $user->id,
                    'restaurant_name' => $restaurant_name,
                    'permit_id' => '123',
                    'phone_no' => '123',
                    'rest_address' => '123',
                    'online_order_accept' => '1',
                    'service_charge' => '0',
                    'params' => json_encode([
                        "payment_settings" => [
                            "ideal" => 1,
                            "card" => 1,
                            "cod" => 1
                        ]
                    ]),
                    'created_at' => date('Y-m-d h:i:s'),
                    'updated_at' => date('Y-m-d h:i:s'),
                ]);
                if(!empty($tenant)){
                    tenancy()->end();
                }
                $restaurant_user = new RestaurantUser();
                $restaurant_user = $restaurant_user->fill([
                    'user_name' => $request->name,
                    'user_email' => $request->user_email,
                    'new_restaurant_user_id' => $user->id,
                    'domain_id' => $domainRecord->id,
                    'restaurant_name' => $restaurant_name,
                    'permit_id' => '123',
                    'phone_no' => '123',
                    'rest_address' => '123',
                    'online_order_accept' => '1',
                    'service_charge' => '0',
                    'params' => json_encode([
                        "payment_settings" => [
                            "ideal" => 1,
                            "card" => 1,
                            "cod" => 1
                        ]
                    ]),
                    'created_at' => date('Y-m-d h:i:s'),
                    'updated_at' => date('Y-m-d h:i:s'),
                ]);
           
                $restaurant_user->save();
                if(!empty($tenant)){
                    tenancy()->initialize($tenant);
                }
                $token = base64_encode(json_encode([
                    'email' => $request->user_email,
                    'timestamp' => time() + 300,  // Token valid for 5 minutes
                ]));
                $redirectUrl = 'http://' . $newDomain . '/login?token=' . urlencode($token);
                /* $redirectUrl = formatUrl($redirectUrl); */

         // Find the user by the provided user_email
            $user = User::where('email', $request->input('user_email'))->first();

            // Check if the user exists and the password matches
            if ($user && Auth::attempt(['email' => $user->email, 'password' => $request->input('password')])) {
          /*   return redirect()->intended('/dashboard'); */
        /*   dd($user); */
          return redirect()->to($redirectUrl);
            }
                
                return redirect()->to($redirectUrl);
            }

        
        } catch (\Exception $e) {
            // Handle exceptions such as database errors
           /*  dd($e); */
            return redirect()->back()
                                ->with('error', 'Registration failed. Please try again later.')
                                ->withInput();
        }

        // Redirect to a success page (e.g., home or dashboard)
        return redirect()->route('home')->with('success', 'Registration successful!');
    
    }
}
