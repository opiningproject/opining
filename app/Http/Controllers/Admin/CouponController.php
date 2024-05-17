<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\Admin\NewCoupon;
use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Models\Order;
use Response;
use Illuminate\Support\Facades\Auth;
use App\Enums\PaymentStatus;
use App\Enums\OrderStatus;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $coupons = Coupon::orderBy('id', 'desc')->whereNotNull('points')->get();

        return view('admin.coupons.index', ['coupons' => $coupons]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $date = date('Y-m-d', strtotime($request->expiry_date . ' 00:00:00'));
        $request->merge(['expiry_date' => $date]);

        try {
            $coupon = Coupon::updateOrCreate(
                ['id' => $request->id],
                $request->all()
            );

            $users = User::where([
                ['user_role', '0'],
                ['enable_email_notification', '1']
            ])->get();

            if($request->id == ''){
                foreach ($users as $user){
                    $user->notify(new NewCoupon($coupon));
                }
            }

            $message = $request->id ? trans('rest.message.coupon_update_success') : trans('rest.message.coupon_add_success');

            return response::json(['status' => 1, 'message' => $message]);
        } catch (Exception $e) {
            return response::json(['status' => 0, 'message' => trans('rest.message.went_wrong')]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $coupon = Coupon::find($id);

            return response::json(['status' => 1, 'data' => $coupon]);
        } catch (Exception $e) {
            return response::json(['status' => 0, 'message' => trans('rest.message.went_wrong')]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Coupon::where('id', $id)->delete();

            return response::json(['status' => 1, 'message' => trans('rest.message.coupon_delete_success')]);

        } catch (Exception $e) {
            return response::json(['status' => 0, 'message' => trans('rest.message.went_wrong')]);
        }
    }

    public function changeStatus(Request $request)
    {
        try {
            $coupon = Coupon::find($request->id);
            $coupon->status = $request->status;
            $coupon->save();

            return response::json(['status' => 1, 'message' => trans('rest.message.coupon_status_success')]);

        } catch (Exception $e) {
            return response::json(['status' => 0, 'message' => trans('rest.message.went_wrong')]);
        }
    }

    public function claimHistoryLog(Request $request)
    {
        $perPage = isset($request->per_page) ? $request->per_page : 5;

        $orders = Order::where('payment_status', PaymentStatus::Success)->where('order_status', OrderStatus::Delivered)->orderBy('id', 'desc')->paginate($perPage);

        return view('admin.coupons.claim_history', ['orders' => $orders, 'perPage' => $perPage]);
    }
}
