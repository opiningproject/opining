<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
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
        $coupons = Coupon::orderBy('id', 'desc')->get();

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
        $date = date('Y-m-d', strtotime($request->expiry_date. ' 00:00:00'));
        $request->merge(['expiry_date' => $date]);

        try {

            Coupon::updateOrCreate(
                ['id' => $request->id],
                $request->all()
            );
        } catch (Exception $e) {
            return response::json(['status' => 0, 'message' => 'Something went wrong.']);
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
            return response::json(['status' => 0, 'message' => 'Something went wrong.']);
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
        } catch (Exception $e) {
            return response::json(['status' => 0, 'message' => 'Something went wrong.']);
        }
    }

    public function changeStatus(Request $request)
    {
        try {
            $coupon = Coupon::find($request->id);
            $coupon->status = $request->status;
            $coupon->save();
        } catch (Exception $e) {
            return response::json(['status' => 0, 'message' => 'Something went wrong.']);
        }
    }

    public function claimHistoryLog()
    {
        $orders = Order::where('payment_status', PaymentStatus::Success)->where('order_status', OrderStatus::Delivered)->orderBy('id', 'desc')->get();

        return view('admin.coupons.claim_history', ['orders' => $orders]);
    }
}
