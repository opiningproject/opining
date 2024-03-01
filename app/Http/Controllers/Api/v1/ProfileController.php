<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Validator;
use App\Models\User;
use App\Models\Address;
use App\Models\BankAccount;
use App\Models\Cart;
use App\Models\Orders;
use JWTAuth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image as Image;

class ProfileController extends Controller
{
    /**
     * Get the authenticated User
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProfile(Request $request)
    {
        $user = ($request->input('user_id')) ? User::find($request->input('user_id')) : JWTAuth::toUser($request->input('token'));

         return response()->json([
                'status' => '1',
                'message' => '',
                'data'    => [
                    'user_data' => getProfile($user->id)
                ]
            ], 200);

        return response()->json($this->guard()->user());
    }

    public function updateProfile(Request $request)
    {
        $user = JWTAuth::toUser($request->input('token'));

        $data = $request->all('first_name','last_name','phone_no');

        if(isEmpty($data) == 1)
        {
            return response()->json([
                'status' => '0',
                'message' => trans('api.something_wrong'),
            ], 200);
        }

        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->phone_no = $request->input('phone_no');

        if ($request->has('image')) 
        {
            $imageName = uploadImageToBucket($request, '/user');
            $user->image = $imageName;
        }
        
        if(!$user->save())
        {
            return response()->json([
                'status' => '0',
                'message' => trans('api.something_wrong'),
            ], 200);
        }
        
        return response()->json([
            'status' => '1',
            'message' => trans('api.profile_update_success'),
            'data' => [
                    'user_data' => getProfile($user->id)
                ]
        ], 200);

    }

    public function changePassword(Request $request)
    {
        $user = JWTAuth::toUser($request->input('token'));

        $data = $request->all('old_password','new_password');

        if(isEmpty($data) == 1)
        {
            return response()->json([
            'status' => '0',
            'message' => trans('api.something_wrong'),
            ], 200);
        }

        if(!empty($user->password) && !Hash::check($request->input('old_password'), $user->password))
        {
            return response()->json([
                'status' => '0',
                'message' => trans('api.enter_correct_password'),
            ], 200);
        }
        elseif(!empty($user->password) && Hash::check($request->input('new_password'), $user->password))
        {
            return response()->json([
                'status' => '0',
                'message' => trans('api.new_password_should_not_same'),
            ], 200);
        }
        else
        {
            $user->password = Hash::make($data['new_password']);

            if(!$user->save())
            {
                return response()->json([
                    'status' => '0',
                    'message' => trans('api.something_wrong'),
                ], 200);
            }
        }

        return response()->json([
            'status' => '1',
            'message' => trans('api.password_change_success'),
        ], 200);

    }

    public function uploadProfilePicture(Request $request)
    {
        $user = JWTAuth::toUser($request->input('token'));

        if($request->hasFile('image')) 
        {
            $oldImage = !empty($user->profile_img) ? $user->profile_img : '';
           
            $user->profile_img = uploadImageToBucket($request,'users',$oldImage);

            if(!$user->save())
            {
                return response()->json([
                    'status' => '0',
                    'message' => trans('api.something_wrong'),
                ], 200);
            }
            
            return response()->json([
                'status' => '1',
                'message' => trans('api.profile_pic_update_success'),
                'data' => [
                    'user_data' => getProfile($user->id)
                ]
            ], 200);
        }

        return response()->json([
            'status' => '0',
            'message' => trans('api.something_wrong'),
        ], 200);
        
    }

    public function getAndUpdateSettings(Request $request)
    {
        $user = JWTAuth::toUser($request->input('token'));

        $data = $request->all('update');

        if(isEmpty($data) == 1)
        {
            return response()->json([
                'status' => '0',
                'message' => trans('api.something_wrong'),
            ], 200);
        }

        if($request->input('update') == 1)
        {
            $user->settings = $request->settings;
            $user->save();
        }

        return response()->json([
            'status' => '1',
            'message' => trans('api.setting_update_success'),
            'data' => [
                    'settings_data' => getUserSettings($user->id)
                ]
        ], 200);
    }

    public function changeLanguage(Request $request)
    {
        $user = JWTAuth::toUser($request->input('token'));

        $data = $request->all('language');

        if(isEmpty($data) == 1)
        {
            return response()->json([
                'status' => '0',
                'message' => trans('api.something_wrong'),
            ], 200);
        }

        $user->language = $request->language;
        $user->save();

        return response()->json([
            'status' => '1',
            'message' => '',
        ], 200);
    } 

    public function deleteAccount(Request $request)
    {
        try 
        {
            $user = JWTAuth::user($request->token);
            $user->delete();
            JWTAuth::invalidate($request->token);

            return response()->json([
                'status' => '1',
                'message' => trans('api.account_deleted_successfully'),
            ], 200);
        } 
        catch (Exception $e) 
        {
            return response()->json([
                'status' => '0',
                'message' => trans('api.something_wrong'),
            ], 200);
        }
    }
}