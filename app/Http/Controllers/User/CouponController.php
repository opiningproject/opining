<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use App\Models\DishFavorites;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Coupon;
use App\Models\CouponTransaction;
use Response;
use DB;

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
        $user = Auth::user();

        $coupons = Coupon::where(
            [
                ['start_expiry_date', '<=', date('Y-m-d')],
                ['end_expiry_date', '>=', date('Y-m-d')],
            ]
//        )->withActive()->whereNotNull('points')->orderBy('id', 'desc')->get();
        )->withActive()->orderBy('id', 'desc')->get();

        return view('user.coupons', ['coupons' => $coupons, 'user' => $user]);
    }

    public function apply(Request $request)
    {
        $coupon = Coupon::where([
            ['status', '1'],
            ['promo_code', $request->couponCode]
        ])->first();

        if (!empty($coupon)) {
            $user = Auth::user();

            $userCoupon = $user->coupons()->where([
                ['coupon_id', $coupon->id],
                ['is_redeemed', '0'],
            ])->first();

            if ($userCoupon) {
                if (strtotime(now()) > strtotime($coupon->end_expiry_date . ' 23:59:59')) {
                    return Response::json([
                        'status' => 401,
                        'message' => trans('user.message.coupon_expired'),
                    ]);
                }

                if (strtotime(now()) < strtotime($coupon->start_expiry_date . ' 00:00:00')) {
                    return Response::json([
                        'status' => 401,
                        'message' => trans('user.coupons.not_applicable'),
                    ]);
                }

                if ($request->orderAmount < $coupon->price) {
                    return response()->json([
                        'status' => 401,
                        'message' => trans("user.message.coupon_min_order_price", ['min_order_amount' => $coupon->price]),
                    ], 200);
                }

                $discount_amount = $request->orderAmount * ($coupon->percentage_off / 100);

                $user->cart()->update([
                    'coupon_id' => $coupon->id,
                    'coupon_code' => $coupon->promo_code,
                ]);

                return Response::json([
                    'status' => 200,
                    'message' => trans('user.message.coupon_applied'),
                    'data' => [
                        'coupon_id' => $coupon->id,
                        'discount_amount' => $discount_amount,
                        'coupon_percent' => ($coupon->percentage_off / 100)
                    ]
                ]);
            } else {

                if(is_null($coupon->points) || $coupon->points >= 0){

                    if (strtotime(now()) > strtotime($coupon->end_expiry_date . ' 23:59:59')) {
                        return Response::json([
                            'status' => 401,
                            'message' => trans('user.message.coupon_expired'),
                        ]);
                    }

                    if (strtotime(now()) < strtotime($coupon->start_expiry_date . ' 00:00:00')) {
                        return Response::json([
                            'status' => 401,
                            'message' => trans('user.coupons.not_applicable'),
                        ]);
                    }

                    if ($request->orderAmount < $coupon->price) {
                        return response()->json([
                            'status' => 401,
                            'message' => trans("user.message.coupon_min_order_price", ['min_order_amount' => $coupon->price]),
                        ], 200);
                    }

                    $discount_amount = $request->orderAmount * ($coupon->percentage_off / 100);

                    $user->cart()->update([
                        'coupon_id' => $coupon->id,
                        'coupon_code' => $coupon->promo_code,
                    ]);

                    return Response::json([
                        'status' => 200,
                        'message' => trans('user.message.coupon_applied'),
                        'data' => [
                            'coupon_id' => $coupon->id,
                            'discount_amount' => $discount_amount,
                            'coupon_percent' => ($coupon->percentage_off / 100)
                        ]
                    ]);

                }else{
                    return response()->json([
                        'status' => 500,
                        'message' => trans('user.message.invalid_coupon'),
                    ], 200);
                }
            }
        } else {
            return response()->json([
                'status' => 500,
                'message' => trans('user.message.invalid_coupon'),
            ], 200);
        }
    }

    public function confirm(Request $request)
    {
        $user = Auth::user();
        $coupon = Coupon::find($request->id);

        User::where('id', $user->id)->update(array(
            'collected_points' => DB::raw('collected_points -' . $coupon->points)
        ));

        CouponTransaction::create(['user_id' => $user->id, 'coupon_id' => $coupon->id]);

        return response::json(['status' => 1, 'message' => '']);
    }

    public function removeCoupon(Request $request)
    {
        try {
            $user = Auth::user();
            $user->cart->update([
                'coupon_id' => null,
                'coupon_code' => '',
                'coupon_discount' => '',
            ]);
            return Response::json([
                'status' => 200,
                'message' => '',
            ]);
        } catch (Exception $e) {
            return response::json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }

}
