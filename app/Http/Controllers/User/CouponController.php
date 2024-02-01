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
        $coupon = Coupon::where('status','1')->where('promo_code', $request->couponCode)->first();

        if(!empty($coupon))
        {
            $user = Auth::user();
            if(strtotime(now()) > strtotime($coupon->expiry_date.' 23:59:59'))
            {
                 return Response::json([
                    'status' => '401',
                    'message' => trans('message.coupon.expired'),

                ]);
            }

            if($request->orderAmount < $coupon->price)
            {
                return response()->json([
                    'status' => '0',
                        'message' => trans('message.coupon.min_order_amount',['min_order_amount'=>$coupon->price]),
                    ], 200);
            }

            $discount_amount = $request->orderAmount * ($coupon->percentage_off/100);

            $user->cart()->update([
                'coupon_id' => $coupon->id,
                'coupon_code' => $coupon->promo_code,
                'coupon_discount' => $discount_amount
            ]);

            return Response::json([
                'status' => '200',
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
                'status' => '401',
                    'message' => trans('message.coupon.invalid_coupon'),
                ], 200);
        }
    }

}
