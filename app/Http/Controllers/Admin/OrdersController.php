<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Dish;
use App\Models\Order;
use App\Models\User;
use App\Notifications\Admin\DeliveryTypeUpdate;
use Exception;
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

        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');
       
            if (!empty($start_date) && !empty($end_date)) {

                $start_date = date('Y-m-d', strtotime($start_date)) . ' 00:00:00';
                $end_date = date('Y-m-d', strtotime($end_date)) . ' 23:59:59';

                $orders->whereBetween('orders.created_at', array($start_date, $end_date));
            } else if (!empty($start_date) && empty($end_date)) {
                $start_date = date('Y-m-d', strtotime($start_date)) . ' 00:00:00';
                $end_date = date('Y-m-d') . ' 23:59:59';

                $orders->whereBetween('orders.created_at', array($start_date, $end_date));
            } else if (empty($start_date) && !empty($end_date)) {
                $end_date = date('Y-m-d', strtotime($end_date)) . ' 23:59:59';
                $start_date = '2024-01-01 00:00:00';

                $orders->whereBetween('orders.created_at', array($start_date, $end_date));
            }

        $order = '';
        $orders = $orders->get();

        if (count($orders) > 0) {
            if ($request->date_filter) {
                $order = Order::find($request->date_filter);
            } else {
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

        if ($order->save()) {
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
        $data['delivery_charge'] = '€' . $order->delivery_charge;
        $data['platform_charge'] = '€' . $order->platform_charge;
        $data['total_amount'] = '€' . $order->total_amount;
        $data['sub_total'] = '€' . getOrderGrossAmount($order);
        $data['order_items'] = $order->dishDetails;
        $data['coupon_discount'] = '- €' . $order->coupon_discount;

        $order_status_key = OrderStatus::getKey($order->order_status);
        $order_status = strtolower(preg_replace('/(?<=\\w)(?=[A-Z])/', " $1", $order_status_key));

        $subject = trans('email.order_status.subject', ['order_id' => $order->id, 'order_status' => $order_status]);

        $data['mail_body'] = trans('email.order_status.content', ['order_id' => $order->id, 'order_status' => $order_status]);

        Mail::send('user.emails.order', $data, function ($message) use ($user, $subject) {
            $message->to($user->email, $user->full_name)->subject($subject);
            $message->from(config('mail.from.address'), config('mail.from.name'));
        });
    }

    public function orderPrintLabel(string $id)
    {
        $order = Order::find($id);

        return view('admin.orders.orders-print-label', ['order' => $order]);
    }

    public function searchOrder(Request $request)
    {
        try {
            $orderExist = false;
            $orders = Order::orderBy('id', 'desc');
            if ($request->has('search')) {

                $orders->whereHas('orderUserDetails', function ($query) use ($request) {
                    $query->where('order_name', 'like', '%' . $request->search . '%')
                        ->orWhere('house_no', 'like', '%' . $request->search . '%')
                        ->orWhere('street_name', 'like', '%' . $request->search . '%')
                        ->orWhere('city', 'like ', '%' . $request->search . '%');
                })->orWhere('id', 'like', '%' . $request->search . '%');
            }

            $orderListIds = $orders->pluck('id')->toArray();
            if (isset($request->activeId)) {
                $orderExist = in_array($request->activeId, $orderListIds);
            }

            return view('admin.orders.orders-list', ['orders' => $orders->get(), 'activeId' => $request->activeId ?? 0, 'orderExist' => $orderExist]);

        } catch (Exception $exception) {
            return response::json(['status' => 400, 'message' => $exception->getMessage()]);
        }
    }

    public function getNotNotifiedOrders(){
        try{
            $orderIds = Order::where([
                ['order_status', OrderStatus::Accepted],
               ['is_admin_notified', '0']
            ])->pluck('id');
         
            // Perform the update
            Order::whereIn('id', $orderIds)->update(['is_admin_notified' => '1']);

            // Fetch the updated records
            $orders = Order::whereIn('id', $orderIds)->orderBy('id', 'desc')->get();

            return view('admin.orders.new-order-popup', ['orders' => $orders]);

        }catch (Exception $exception){
            return response::json(['status' => 400, 'message' => '']);
        }
    }
}
