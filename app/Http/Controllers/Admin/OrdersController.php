<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Dish;
use App\Models\Order;
use App\Models\User;
use App\Notifications\Admin\DeliveryTypeUpdate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Enums\OrderStatus;
use App\Enums\OrderType;
use Response;
use Mail;
use Carbon\Carbon;

class OrdersController extends Controller
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
    public function index(Request $request)
    {
        $orders = Order::where('is_cart', '0')->orderBy('id', 'desc');

        $today_date = date('Y-m-d');
        $dateFilterArray = [1,2,3];

        if($request->date_filter)
        {
            if(in_array($request->date_filter, $dateFilterArray)){
                if($request->date_filter == 1)  // Today
                {
                    $orders->whereBetween('created_at', [$today_date.' 00:00:00', $today_date.' 23:59:59']);

                }
                else if($request->date_filter == 2) // This week
                {
                    $orders->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                }
                else // This month
                {
                    $orders->whereBetween('created_at', [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()]);
                }
            }
        }

        $order = '';
        $orders = $orders->get();

        if (count($orders) > 0)
        {
            if($request->date_filter){
                if(in_array($request->date_filter, $dateFilterArray)){
                    $order = $orders[0];
                }else{
                    $order = Order::find($request->date_filter);
                }
            }else{
                $order = $orders[0];
            }
        }

        return view('admin.orders.orders', ['orders' => $orders, 'order' => $order]);
    }

    public function orderDetail(Request $request)
    {
        $order = Order::find($request->order_id);

        return view('admin.orders.order-detail', ['order' => $order]);
    }

    public function changeStatus(Request $request)
    {
        $order = Order::find($request->id);

        $order = getOrderStatus($order);

        if($order->save())
        {
            $order->user->notify(new DeliveryTypeUpdate($order));
//            $this->sendMail($order);
        }

        return response::json(['status' => 1, 'message' => '']);

    }

    public function sendMail($order)
    {
        $user = User::find($order->user_id);

        $data['name'] = $user->full_name;
        $data['order_id'] = $order->id;
        $data['delivery_charge'] = '€'.$order->delivery_charge;
        $data['platform_charge'] = '€'.$order->platform_charge;
        $data['total_amount'] = '€'.$order->total_amount;
        $data['sub_total'] = '€'.getOrderGrossAmount($order);
        $data['order_items'] = $order->dishDetails;
        $data['coupon_discount'] = '- €'.$order->coupon_discount;

        $order_status_key = OrderStatus::getKey($order->order_status);
        $order_status = strtolower(preg_replace('/(?<=\\w)(?=[A-Z])/'," $1", $order_status_key));

        $subject = trans('email.order_status.subject',['order_id' => $order->id, 'order_status' => $order_status]);

        $data['mail_body'] = trans('email.order_status.content',['order_id' => $order->id, 'order_status' => $order_status]);

        Mail::send('user.emails.order', $data, function($message) use($user,$subject)
        {
            $message->to($user->email, $user->full_name)->subject($subject);
            $message->from(config('mail.from.address'),config('mail.from.name'));
        });
    }
}
