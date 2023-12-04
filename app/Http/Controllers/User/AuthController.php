<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
Use App\Models\User;
use App\Enums\UserType;
use Validator,Redirect,Response;

class AuthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $user = User::where('email', $request->email)->get()->first();

        if(empty($user))
        {
          return response::json(
            [
              'status' => 0, 
              'message' => 'Email not registered with us'
            ]
          );
        } 
        
        if(!Hash::check($request->password, $user->password))
        {
          return response::json(
            [
              'status' => 0, 
              'message' => 'Incorrect password'
            ]
          );
        } 

        if($user->user_role != UserType::User)
        {
            return response::json(
                [
                  'status' => 0, 
                  'message' => 'Incorrect rights'
                ]
          );
        }  

        if (Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) 
        {
          return response::json(['status' => 1, 'message' => "Successfully login."]);
        }
    }

  
}
