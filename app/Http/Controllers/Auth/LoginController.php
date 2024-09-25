<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Enums\UserType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    protected function authenticated(Request $request, $user)
    {   
        $rediection = "dashboard";
        if(!empty($user) && $user->user_role == UserType::SuperAdmin){
            $rediection = "/super-admin/dashboard";
        }
        return redirect()->intended($rediection); // Adjust the route as needed
    }

    protected function attemptLogin(Request $request)
    {
        $email = $request->input('email');
        $user = User::where('email', $email)->first();
        $userType = UserType::Admin;
        if(!empty($user) && $user->user_role == UserType::SuperAdmin){
            $userType =  UserType::SuperAdmin;
        }

        return $this->guard()->attempt(
            ['email' => $request->input('email'), 'password' => $request->input('password'), 'user_role' => [$userType]], $request->has('remember')
        );
    }

    public function logout(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            User::where('id',$user->id)->update(['is_online'=>'0']);
        }
        $this->guard()->logout();
        Session::forget('myFinanceIsValidate');
        $request->session()->invalidate();

        if($user->user_role == UserType::Admin)
        {
            return redirect()->route('login');
        }
        else
        {
            return redirect()->route('user.home');
        }

    }
}
