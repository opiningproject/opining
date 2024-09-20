<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Models\CouponTransaction;
use App\Models\User;
use Auth;
class CouponController extends Controller
{
    public function getCoupons()
    {
        $coupons = Coupon::where('expiry_date','>=',date('Y-m-d'))->withActive()->orderBy('id', 'desc')->get();

        if(!$coupons->count()){

            return response()->json([
            'status' => '1',
            'message' => trans('api.no_coupon_data_found')
        ], 200);

        }

        return response()->json([
            'status' => '1',
            'message' => trans('api.coupon_data'),
            'data' => $coupons,
        ], 200);

    }

    public function buyCouponCode(Request $request){

        $user = Auth::user();
        $coupon=Coupon::find($request->coupon_id);

        User::find($user->id)->decrement('collected_points',$coupon->points);

        $k=CouponTransaction::create(['user_id' => $user->id,'coupon_id' => $coupon->id]);

        return response()->json([
            'status' => '1',
            'message' => trans('api.coupon_data'),
            'data' => $k,
        ], 200);

    }
}
