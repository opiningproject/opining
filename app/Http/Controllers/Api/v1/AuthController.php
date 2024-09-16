<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Validator;
use App\Models\User;
use JWTAuth;
use Illuminate\Support\Facades\Password;
use Carbon\Carbon;
use App\Enums\UserType;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('jwt.verify', ['except' => ['login','register','forgotPassword','socialSignup']]);
    }

    public function register(Request $request)
    {
        $data = $request->all('first_name','last_name','email','password');

        if(isEmpty($data) == 1)
        {
            return response()->json([
            'status' => '0',
                'message' => trans('api.something_wrong'),
            ], 200);
        }

        $user = User::where('email', $data['email'])->first();

        if(!empty($user) && $user->social_id != 0)
        {
            return response()->json([
                'status' => '0',
                    'message' => trans('api.email_registered_social_signup'),
                ], 200);
        }
        if(!empty($user) && $user->social_id == 0 && $user->email_verified_at)
        {
            return response()->json([
                'status' => '0',
                    'message' => trans('api.email_already_registered'),
                ], 200);
        }
        if(!empty($user) && !$user->email_verified_at)
        {
            $user->delete();
        }

        //Request is valid, create new user
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'user_role' => '0',
            'email' => $request->email,
            'password' => bcrypt($request->password),
            
        ])->sendEmailVerificationNotification();

        return response()->json([
                'status' => '1',
                'message' => trans('api.email_verification_link_sent'),
            ], 200);
    }

    /**
     * Get a JWT token via given credentials.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $data = $request->all('email', 'password','device_token','device_type');

        if(isEmpty($data) == 1)
        {
            return response()->json([
            'status' => '0',
                'message' => trans('api.something_wrong'),
            ], 200);
        }

        $credentials = $request->only('email', 'password');

        $user = User::where('email', '=', $data['email'])->where('user_role', UserType::User)->first();

        if(!empty($user) && $user->social_id != 0 && empty($user->password))
        {
            return response()->json([
            'status' => '0',
            'message' => trans('api.email_registered_social_signup')], 401);
        }

        if ($token = $this->guard()->attempt($credentials)) 
        {       
            $user = $this->guard()->user();

            if($user->user_role != UserType::User)
            {
                return response()->json([
                'status' => '0',
                'message' => trans('api.invalid_credentials')], 401);
            }

            if(!$user->email_verified_at)
            {
                return response()->json([
                'status' => '0',
                'message' => trans('api.email_verification_warning')], 401);
            }

            $is_first_login = $user->email_verified_at == $user->updated_at ? 1 : 0;
            $user->device_token = $request->input('device_token');
            $user->device_type  = $request->input('device_type');
            $user->api_token  = $token;
            $user->save();

            return response()->json([
                'status' => '1',
                'message' => '',
                'data'    => [
                    'token' => $token,
                    'is_first_login' => $is_first_login,
                    'user_data' => getProfile($user->id)
                ]
            ], 200);
        }

        return response()->json([
            'status' => '0',
            'message' => trans('api.invalid_credentials')], 401);
    }

    /**
     * Log the user out (Invalidate the token)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $user = $this->guard()->user();
        $user->device_token  = NULL;
        $user->save();

        $this->guard()->logout();

        return response()->json(['status' => '1', 'message' => '']);
    }

    public function forgotPassword(Request $request)
    {
        $user = User::where('email', '=', $request->input('email'))->where('user_role', UserType::User)->first();

        if(!$user || empty($user->email))
        {
            return response()->json([
                'status' => '0',
                'message' => trans('api.email_not_registered'),
            ], 200);
        }

        if(!empty($user->social_id) && empty($user->password))
        {
            return response()->json([
                'status' => '0',
                'message' => trans('api.email_registered_social_signup'),
            ], 200);
        }

        $broker = $this->getPasswordBroker();
        $sendingResponse = $broker->sendResetLink(['email' => $user->email]);

        if($sendingResponse !== Password::RESET_LINK_SENT)
        {
            return response()->json([
                'status' => '0',
                'message' => trans('api.something_wrong'),
            ], 200);
        }

        return response()->json([
            'status' => '1',
            'message' => trans('api.forgot_password_success'),
        ], 200);
    }
    
    private function getPasswordBroker()
    {
        return Password::broker();
    }

    public function socialSignup(Request $request)
    {
        $data = $request->all('social_id','social_type','device_type','device_token');

        if(isEmpty($data) == 1)
        {
            return response()->json([
            'status' => '0',
                'message' => trans('api.something_wrong'),
            ], 200);
        }

        if(!empty($request->email))
        {
            $user = User::where('email', $request->email)->first();

            if(!empty($user) && $user->social_id == 0)
            {
                return response()->json([
                    'status' => '0',
                        'message' => trans('api.email_already_registered'),
                    ], 200);
            }
        }


        if($request->email)
        {
            $userExist = User::where('email', $request->email)->first();
        }
        else
        {
            $userExist = User::where('social_id', $data['social_id'])->first();
        }

        if(!empty($userExist) && $userExist->status == '0')
        {
            return response()->json([
            'status' => '3',
            'message' => trans('api.user_account_inactive')], 401);
        }

        if($userExist)
        {
            $user = User::find($userExist->id);
            $user->social_id = $request->input('social_id');
            $user->email = $user->email ? $user->email : $request->input('email');
            $user->first_name     = $user->first_name;
            $user->last_name     = $user->last_name;
            $user->device_type     = $request->input('device_type');
            $user->device_token     = $request->input('device_token');
            $user->loggedin_at = Carbon::now();
            $user->save();
        }
        else
        {
            //Request is valid, create new user
            $user = User::create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'social_id' => $request->social_id,
                'social_type' => $request->social_type,
                'device_type' => $request->device_type,
                'device_token' => $request->device_token,
                'user_role' => 3,
                'status' => '1',
                'email' => $request->email,
                'email_verified_at' => date('Y-m-d H:i:s'),
                'loggedin_at' => Carbon::now() 
            ]);
        }

        $token = JWTAuth::fromUser($user);
        $user->api_token  = $token;
        $user->save();

        $is_first_login = $user->email_verified_at == $user->updated_at ? 1 : 0;
 
        return response()->json([
                'status' => '1',
                'message' => '',
                'data'    => [
                    'token' => $token,
                    'is_first_login' => $is_first_login,
                    'user_data' => getProfile($user->id)
                ]
            ], 200);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $this->guard()->factory()->getTTL() * 60
        ]);
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\Guard
     */
    public function guard()
    {
        return Auth::guard('api');
    }
}