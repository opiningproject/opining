<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DishFavorites;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
Use App\Models\User;
Use App\Models\Coupon;
use Response;

class CouponController extends Controller
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
    public function index()
    {
        $coupons = Coupon::orderBy('id', 'desc')->get();

        return view('user.coupons', ['coupons' => $coupons]);
    }

    public function apply(Request $request)
    {
        $coupon = Coupon::where('status','1')->where('promo_code', $request->coupon_code)->get()->first();

        if(!empty($coupon))
        {
            if(strtotime(now()) > strtotime($coupon->expiry_date.' 23:59:59'))
            {
                 return Response::json([
                    'status' => '0', 
                    'message' => trans('message.coupon.expired'),

                ]);   
            }

            if($request->order_amount < $coupon->price)
            {
                return response()->json([
                    'status' => '0',
                        'message' => trans('message.coupon.min_order_amount',['min_order_amount'=>$coupon->price]),
                    ], 200);
            }

            $discount_amount = $request->order_amount * $coupon->percentage_off/100;

            return Response::json([
                'status' => '1', 
                'message' => trans('message.coupon.applied'),
                'data' => [
                    'coupon_id' => $coupon->id,
                    'discount_amount' => $discount_amount,
                ]
            ]);
        }
        else
        {
            return response()->json([
                'status' => '0',
                    'message' => trans('message.coupon.invalid_coupon'),
                ], 200);
        }
    }

}
