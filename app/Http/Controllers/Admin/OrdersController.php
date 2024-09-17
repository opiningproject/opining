<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Dish;
use App\Models\Order;
use App\Models\TrackOrder;
use App\Models\User;
use App\Notifications\Admin\DeliveryTypeUpdate;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Enums\OrderStatus;
use App\Enums\OrderType;
use Illuminate\Support\Facades\Date;
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
    public function index(Request $request, $id = null)
    {
//        $orders = Order::where('is_cart', '0')->orderBy('id', 'desc')->where('order_status','<>',OrderStatus::Delivered)->orWhere('updated_at', '>=', Carbon::now()->subHours(12));
        $orders = Order::where('is_cart', '0')
            ->where(function($query) {
                $query->where('order_status', '<>', OrderStatus::Delivered)
                    ->orWhere('updated_at', '>=', Carbon::now()->subHours(12));
            })->orderBy('id', 'desc');

        $openOrders = Order::where('is_cart', '0')->where('order_status','<>',OrderStatus::Delivered)->orderBy('id', 'desc')->get();

        $pageNumber = request()->input('page', 1);

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
        $orders = $orders->paginate(10, ['*'], 'page', $pageNumber);
        if (count($orders) > 0) {
            if ($id) {
                $order = Order::find($id);
            } else {
                $order = $orders[0];
            }
        }
        if ($request->ajax()) {
            return view('admin.orders.orders-list', ['orders' => $orders, 'activeId' => $request->activeId ?? 0]);
        }
        return view('admin.orders.orders', ['openOrders' => $openOrders, 'allOrders' => $orders,'order' => $order,'lastPage' => $orders->lastPage()]);
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
        $orderStatus = 0;
        $clok_gray_svg = '';
        if ($order->save()) {
            $order->user->notify(new DeliveryTypeUpdate($order));
//            $this->sendMail($order);

            if($order->order_status == OrderStatus::Delivered) {

                $delivery_time = $order->delivery_time ?? 'ASAP';
                $clok_gray_svg = '<svg width="29" height="29" viewBox="0 0 29 29" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g id="Group 3113">
                <circle id="Ellipse 91" cx="14.5" cy="14.5" r="14.5" fill="#949494"/>
                <path id="Line 85" d="M15 9V15" stroke="#292929" stroke-width="2" stroke-linecap="round"/>
                <path id="Line 86" d="M19.0859 18.6406L15.0017 14.9959" stroke="#292929" stroke-width="2" stroke-linecap="round"/>
                </g>
                </svg><div class="text">'.$delivery_time.'</div>';
                $orderStatus = OrderStatus::Delivered;
            }
        }
        if ($order->order_type == "1") {
            $addTrackOrder = TrackOrder::create([
                'order_id' => $order->id,
                'order_status' => $order->order_status
            ]);
        }
        $orderData = Order::find($request->id);
        $trackOrderData = TrackOrder::where('order_id', $orderData->id)->where('order_status', $orderData->order_status)->first();
        $dishesHTML = view('admin.orders.order-detail', ['order' => $order,'clok_gray_svg' => $clok_gray_svg])->render();
        return response()->json(['status' => 1, 'data' =>  $dishesHTML, 'orderStatus' =>  $orderStatus, 'orderId' =>  $orderData->id, 'orderDate' =>  $trackOrderData ? $trackOrderData->created_at :'', 'updatedStatus' =>  $orderData->order_status, 'clok_gray_svg' => $clok_gray_svg]);
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

        $taxedValue = 0.09 * (float)$order->total_amount;
        $differenceValue = $order->total_amount - $taxedValue;

        $order->sub_total = $differenceValue;
        $order->tax_amount = $taxedValue;
        return view('admin.orders.orders-print-label', ['order' => $order]);
    }

    public function searchOrder(Request $request)
    {
        try {
            $pageNumber = request()->input('page', 1);
            $orderExist = false;
            $orders = Order::orderBy('id', 'desc');
//            $orders = Order::where('is_cart', '0')
//                ->where(function($query) {
//                    $query->where('order_status', '<>', OrderStatus::Delivered)
//                        ->orWhere('updated_at', '>=', Carbon::now()->subHours(12));
//                });
            if ($request->has('search')) {

                $orders->where(function ($query) use ($request) {
                    $query->whereHas('orderUserDetails', function ($query) use ($request) {
                        $query->where('order_name', 'like', '%' . $request->search . '%')
                            ->orWhere('house_no', 'like', '%' . $request->search . '%')
                            ->orWhere('street_name', 'like', '%' . $request->search . '%')
                            ->orWhere('city', 'like', '%' . $request->search . '%');
                    })
                        ->orWhere('id', 'like', '%' . $request->search . '%');
                });
            }

            $orderListIds = $orders->pluck('id')->toArray();
            if (isset($request->activeId)) {
                $orderExist = in_array($request->activeId, $orderListIds);
            }
            $orders = $orders->paginate(10, ['*'], 'page', $pageNumber);
            return view('admin.orders.orders-list', ['orders' => $orders, 'activeId' => $request->activeId ?? 0, 'orderExist' => $orderExist]);

        } catch (Exception $exception) {
            return response::json(['status' => 400, 'message' => $exception->getMessage()]);
        }
    }

    public function getRealTimeOrder(Request $request)
    {
        try {
            $orders = Order::with('orderUserDetails')->where('is_cart', '0')->orderBy('id', 'desc')->first();
            $html = '<div class="foodorder-box-list-item d-flex order-' . $orders->id . '"
                     onclick="orderDetail(' . $orders->id . ')" id="order-' . $orders->id . '" data-id="' . $orders->id . '">
                    <div class="details w-100 d-flex flex-column gap-3">
                        <div class="title">' . trans('rest.food_order.order') . ' #'. $orders->id .' | ' . $orders->created_at . '</div>
                        <div class="icontext-grp d-flex align-items-center justify-content-between">
                            <div class="icontext-item d-flex align-items-center gap-1">
                                <img src="' . asset('images/fork-knife-icon.svg') . '"
                                     class="img-fluid svg" alt="" height="22" width="22">
                                <div class="text">' . ($orders->order_type == OrderType::Delivery ? trans('rest.food_order.delivery') : trans('rest.food_order.pickup')) . '</div>
                            </div>
                            <div class="icontext-item d-flex align-items-center gap-1">
                                <img src="' . asset('images/hand-money-icon.svg') . '" alt=""
                                     class="img-fluid svg" width="30" height="29">
                                <div class="text total_amount">€' . number_format($orders->total_amount, 2) . '</div>
                            </div>
                        </div>
                    </div>
                    <div class="time d-flex flex-column align-items-center justify-content-center text-center gap-1 order-status-' . $orders->id . '">
                        <img src="' . ($orders->order_status >= OrderStatus::Delivered ? asset('images/clock-gray.svg') : asset('images/clock-gray.svg')) . '"
                            alt="time" class="img-fluid svg" width="29" height="29">
                        <div class="text">' . $orders->delivery_time . '</div>
                    </div>
                </div>';
            return response()->json(['data' => $html]);

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


    public function archiveOrders(Request $request, $id = null)
    {
        $orders = Order::where('order_status', '6')
            ->where('updated_at', '<=', Carbon::now()->subHours(12))
            ->orderBy('id', 'desc');

        $openOrders = Order::where('is_cart', '0')->where('order_status','<>',OrderStatus::Delivered)->orderBy('id', 'desc')->get();

        $pageNumber = request()->input('page', 1);

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
        $orders = $orders->paginate(10, ['*'], 'page', $pageNumber);
//        $orders = $orders->get();
        if (count($orders) > 0) {
            if ($id) {
                $order = Order::find($id);
            } else {
                $order = $orders[0];
            }
        }
        if ($request->ajax()) {
            return view('admin.archive.orders-list', ['orders' => $orders, 'activeId' => $request->activeId ?? 0]);
        }
        return view('admin.archive.orders', ['openOrders' => $openOrders, 'allOrders' => $orders,'order' => $order,'lastPage' => $orders->lastPage()]);
    }



    public function archiveOrderDetail(Request $request)
    {
        $order = Order::find($request->order_id);

        return view('admin.archive.order-detail', ['order' => $order]);
    }

    public function archiveSearchOrder(Request $request)
    {
        try {
            $pageNumber = request()->input('page', 1);
            $orderExist = false;
            $orders = Order::where('order_status', '6')
                ->where('updated_at', '<=', Carbon::now()->subHours(12))
                ->orderBy('id', 'desc');
            if ($request->has('search')) {

                $orders->where(function ($query) use ($request) {
                    $query->whereHas('orderUserDetails', function ($query) use ($request) {
                        $query->where('order_name', 'like', '%' . $request->search . '%')
                            ->orWhere('house_no', 'like', '%' . $request->search . '%')
                            ->orWhere('street_name', 'like', '%' . $request->search . '%')
                            ->orWhere('city', 'like', '%' . $request->search . '%');
                    })
                        ->orWhere('id', 'like', '%' . $request->search . '%');
                });
            }

            $orderListIds = $orders->pluck('id')->toArray();
            if (isset($request->activeId)) {
                $orderExist = in_array($request->activeId, $orderListIds);
            }
            $orders = $orders->paginate(10, ['*'], 'page', $pageNumber);
            return view('admin.archive.orders-list', ['orders' => $orders, 'activeId' => $request->activeId ?? 0, 'orderExist' => $orderExist]);

        } catch (Exception $exception) {
            return response::json(['status' => 400, 'message' => $exception->getMessage()]);
        }
    }

    /**
     * @param Request $request
     * @param null $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function newOrderPage(Request $request, $id = null)
    {
        return view('admin.orders.orders-new');
    }
}
