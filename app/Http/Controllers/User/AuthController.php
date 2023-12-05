<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
Use App\Models\User;
use App\Enums\UserType;
use Laravel\Socialite\Facades\Socialite;
use Validator,Redirect,Response;
use Illuminate\Support\Facades\Password;
use Carbon\Carbon;

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

        if(!empty($user) && $user->email_verified_at)
        {
            return response::json(
                [
                  'status' => 0, 
                  'message' => 'Please verify your email to login'
                ]
            );
        }

        if(!empty($user) && $user->social_id != '' && empty($user->password))
        {
            return response::json(
                [
                  'status' => 0, 
                  'message' => 'This email is registered with gmail login'
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

    public function signup(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if(!empty($user) && !empty($user->password) && $user->email_verified_at)
        {
            return response::json(
                [
                  'status' => 0, 
                  'message' => 'Entered email id is already registered with us'
                ]
            );
        }
        
        if(!empty($user) && !$user->email_verified_at)
        {
            $user->forceDelete();
        }

        if(empty($user))
        {
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'user_role' => '0',
                'email' => $request->email,
                'password' => bcrypt($request->password),

            ])->sendEmailVerificationNotification();
        }
        else
        {
            User::where('email', '=', $user->email)
                ->update([
                    'first_name' => $user->first_name,
                    'last_name' => $user->last_name,
                    'password' => bcrypt($request->password),
                ]);
        }

        return response::json(
                [
                  'status' => 1, 
                  'message' => 'sign up success'
                ]
            );
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $google_user = Socialite::driver('google')->user();
 
        $user = User::updateOrCreate([
            'email' => $google_user->email,
        ], [
            'first_name' => $google_user->user['given_name'],
            'last_name' => $google_user->user['family_name'],
            'email' => $google_user->email,
            'social_id' => $google_user->id,
            'email_verified_at' => date('Y-m-d H:i:s'),
        ]);
     
        Auth::login($user);
     
        return redirect('/dashboard');
    }

    public function forgotPassword(Request $request)
    {
        $user = User::where('email', '=', $request->input('email'))->where('user_role', UserType::User)->first();

        if(!$user || empty($user->email))
        {
            return response::json(
                [
                  'status' => 0, 
                  'message' => 'Entered email id is not registered with us'
                ]
            );
        }

        if(!empty($user->social_id) && empty($user->password))
        {
            return response::json(
                [
                  'status' => 0, 
                  'message' => 'Entered email id is registered with gmail login'
                ]
            );
        }

        $broker = $this->getPasswordBroker();
        $sendingResponse = $broker->sendResetLink(['email' => $user->email]);

        if($sendingResponse !== Password::RESET_LINK_SENT)
        {
            return response::json(
                [
                  'status' => 0, 
                  'message' => 'something went wrong'
                ]
            );
        }

        return response::json(
                [
                  'status' => 0, 
                  'message' => 'We have sent reset password link to your email'
                ]
            );
    }
    
    private function getPasswordBroker()
    {
        return Password::broker();
    }
}
