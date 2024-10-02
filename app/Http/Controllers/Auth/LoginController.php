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

    protected function attemptLogin(Request $request)
    {
        return $this->guard()->attempt(
            ['email' => $request->input('email'), 'password' => $request->input('password'), 'user_role' => [UserType::Admin]], $request->has('remember')
        );
    }

    public function logout(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            User::where('id',$user->id)->update(['is_online'=>'0']);
        }

        $getSiteHost = getSiteHost($request);
     /*    dd($getSiteHost); */
        Session::forget('myFinanceIsValidate');
        Session::forget('tenancy_domain_code');
        Session::forget('tenancy_db_name');
        $this->guard()->logout();
   
        if($user->user_role == UserType::Admin)
        {
            $loginUrl = $getSiteHost . '/login';
            $request->session()->invalidate();
            return redirect($loginUrl);
/*             return redirect()->route('login'); */
        }
        else
        {
            $request->session()->invalidate();
            return redirect()->route('user.home');
        }

    }
}
