<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DishFavorites;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
Use App\Models\User;
Use App\Models\Coupon;
Use App\Models\Order;
Use App\Models\OrderDetail;
use App\Enums\OrderStatus;
use App\Enums\OrderType;

class OrderController extends Controller
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
        $user_id = Auth::user()->id;

        $active_orders = Order::where('user_id',$user_id)->where('is_cart','0')->where('order_status','<>',OrderStatus::Delivered)->orderBy('id','desc')->get();
        $orders = Order::where('user_id',$user_id)->where('is_cart','0')->where('order_status',OrderStatus::Delivered)->orderBy('id','desc')->get();

        $order_detail = '';
        if(count($active_orders))
        {
            $order_detail = $active_orders[0];
        }
        else if(count($orders))
        {
            $order_detail = $orders[0];
        }

        /*echo "<pre>";
        //print_r($orders->dishDetails);
        print_r($active_orders);
        exit;*/

        return view('user.orders.orders',['orders' => $orders, 'active_orders' => $active_orders,'order_detail' => $order_detail]);
    }

    public function orderLocation()
    {
        return view('user.orders.order-location');
    }


}
