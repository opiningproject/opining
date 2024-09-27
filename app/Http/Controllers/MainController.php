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


class MainController extends Controller
{
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

    public function storePanelRegistration(Request $request)
    {
        // Validation rules
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'restaurant_name' => 'required|string|max:255|unique:restaurant_users',
            'user_email' => 'required|string|email|max:255|unique:restaurant_users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $randomNumberString = generateUniqueFourDigitNumber();
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
                $redirectUrl = 'http://' . $newDomain . '/dashboard';
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
