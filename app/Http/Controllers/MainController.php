<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Tenant;
use App\Models\Domain;
use Illuminate\Support\Facades\Auth;
use Redirect,Response;
use Illuminate\Support\Facades\DB;


class MainController extends Controller
{
    public function panelRegistration(Request $request)
    {
        return view('auth.panel-registration', [
             ]);
    }

    public function storePanelRegistration(Request $request)
    {
        // Validation rules
        $validator = Validator::make($request->all(), [
            'domain' => 'required|string|max:255|unique:domains',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Check for validation errors
        if ($validator->fails()) {
            return redirect()->back()
                                ->withErrors($validator)
                                ->withInput();
        }
        // Attempt to create the user
        try {
            $user = [];
            $newDoamin = $request->domain;
            $tenant = Tenant::create(['id' => $newDoamin]);
            $tenant->domains()->create(['domain' => $newDoamin]);
            if(!empty($tenant)){
                $domain = $request->getHost();
                $domainRecord = Domain::where('domain', $newDoamin)->first();
                if ($domainRecord) {
                    $tenant = $domainRecord->tenant;
                    tenancy()->initialize($tenant);
                    $user = User::create([
                        'first_name' => $request->name,
                        'last_name' => '',
                        'email' => $request->email,
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
                    'restaurant_name' => 'Restaurant Name',
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

                if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')]))
                {
/*                     return redirect()->to('/dashboard'); */
                    return redirect()->to('https://' . $newDoamin . '/dashboard');
                }
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
