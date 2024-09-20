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
use Illuminate\Support\Str;
use Response;
use Mail;
use Carbon\Carbon;

class NewOrdersController extends Controller
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
        $orderDeliveryTime = (int) Str::between(getRestaurantDetail()->delivery_time, '-', ' Min');
       /* $orders = Order::where('is_cart', '0')
            ->where(function($query) {
                $query->where('order_status', '<>', OrderStatus::Delivered)
                    ->orWhere('updated_at', '>=', Carbon::now()->subHours(12));
            })->orderBy('id', 'desc');*/
        $orders = Order::where('is_cart', '0')->orderByRaw("(order_status = '6') ASC")->orderBy('created_at', 'desc');

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

        $orders = $orders->paginate(12, ['*'], 'page', $pageNumber);
        if ($request->ajax()) {
            $filters = $request->get('filters');
            if ($request->has('search') && $request->search != null || !empty($filters)) {
                $data = $this->orderSearchFilter($request);
            } else {
                $data['orders'] = $orders;
                $data['orderDeliveryTime'] = $orderDeliveryTime;
            }
            return view('admin.orders.search-orders', ['orders' => $data['orders'], 'orderDeliveryTime' => $orderDeliveryTime]);
        }
        return view('admin.orders.orders-new', ['orderDeliveryTime' => $orderDeliveryTime, 'allOrders' => $orders,'lastPage' => $orders->lastPage()]);
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

//    public function searchOrder(Request $request)
//    {
//       try {
//            $data = $this->orderSearch($request);
//           $orderDeliveryTime = (int) Str::between(getRestaurantDetail()->delivery_time, '-', ' Min');
//            return view('admin.orders.search-orders', ['orders' => $data['orders'], 'orderDeliveryTime' => $orderDeliveryTime]);
//
//        } catch (Exception $exception) {
//            return response::json(['status' => 400, 'message' => $exception->getMessage()]);
//        }
//    }
    public function orderSearchFilter(Request $request) {
        $orderDeliveryTime = (int) Str::between(getRestaurantDetail()->delivery_time, '-', ' Min');
        $pageNumber = request()->input('page', 1);
        $orders = Order::where('is_cart', '0')->orderByRaw("(order_status = '6') ASC")->orderBy('created_at', 'desc');
        // Check if the search term and search option are present
        if ($request->has('search') && $request->has('searchOption')) {
            $searchType = $request->input('searchOption');
            $searchTerm = $request->input('search');
            // Handle different search types
            switch ($searchType) {
                case 'name':
                    // Search by order user name
                    $orders->whereHas('orderUserDetails', function ($query) use ($searchTerm) {
                        $query->where('order_name', 'like', '%' . $searchTerm . '%');
                    });
                    break;

                case 'phone_number':
                    // Search by phone number
                    $orders->whereHas('orderUserDetails', function ($query) use ($searchTerm) {
                        $query->where('order_contact_number', 'like', '%' . $searchTerm . '%');
                    });
                    break;

                case 'order_number':
                    // Search by order ID (number)
                    $orders->where('id', 'like', '%' . $searchTerm . '%');
                    break;

                case 'address':
                    // Search by address fields
                    $orders->whereHas('orderUserDetails', function ($query) use ($searchTerm) {
                        $query->where('house_no', 'like', '%' . $searchTerm . '%')
                            ->orWhere('street_name', 'like', '%' . $searchTerm . '%')
                            ->orWhere('city', 'like', '%' . $searchTerm . '%')
                            ->orWhere('zipcode', 'like', '%' . $searchTerm . '%');
                    });
                    break;

                case 'zip_code':
                    // Search by zip code
                    $orders->whereHas('orderUserDetails', function ($query) use ($searchTerm) {
                        $query->where('zipcode', 'like', '%' . $searchTerm . '%');
                    });
                    break;

                case 'dish':
                    // Search by product (assuming orders have a relation to products)
                    $orders->whereHas('dishDetails', function ($query) use ($searchTerm) {
                        $query->whereHas('dish', function ($subQuery) use ($searchTerm) {
                            $subQuery->where('name_en', 'like', '%' . $searchTerm . '%');
                            $subQuery->orWhere('name_nl', 'like', '%' . $searchTerm . '%');
                        });
                    });
                    break;

                default:
                    // Default case for 'all' or when no valid search type is selected
                    $orders->where(function ($query) use ($searchTerm) {
                        $query->where('id', 'like', '%' . $searchTerm . '%')
                            ->orWhereHas('orderUserDetails', function ($query) use ($searchTerm) {
                                $query->where('order_name', 'like', '%' . $searchTerm . '%')
                                    ->orWhere('house_no', 'like', '%' . $searchTerm . '%')
                                    ->orWhere('street_name', 'like', '%' . $searchTerm . '%')
                                    ->orWhere('city', 'like', '%' . $searchTerm . '%')
                                    ->orWhere('zipcode', 'like', '%' . $searchTerm . '%');
                            });
                    });
                    break;
            }
        }
        $filters = $request->filters;

        if (!empty($filters)) {
            $orders->where(function($query) use ($filters) {
                // Apply filters based on the selected checkboxes within a group
//                if (in_array('online', $filters)) {
//                    $query->orWhere('order_type', 'online');
//                }
//
//                if (in_array('manual', $filters)) {
//                    $query->orWhere('order_type', 'manual');
//                }

                if (in_array('delivery', $filters)) {
                    $query->orWhere('order_type', OrderType::Delivery);
                }

                if (in_array('takeaway', $filters)) {
                    $query->orWhere('order_type', OrderType::TakeAway);
                }

                if (in_array('open', $filters)) {
                    $query->orWhere('order_status', '!=', OrderStatus::Delivered);
                }

                if (in_array('delivered', $filters)) {
                    $query->orWhere('order_status', OrderStatus::Delivered);
                }
            });
        }
        $orders = $orders->paginate(12, ['*'], 'page', $pageNumber);

        return [
            'orders' => $orders
        ];
    }

    public function filterOrders($request)
    {
        $pageNumber = request()->input('page', 1);
        $orders = Order::where('is_cart', '0')->orderByRaw("(order_status = '6') ASC")->orderBy('created_at', 'desc');
        $filters = $request->filters;

        if (!empty($filters)) {
            $orders->where(function($query) use ($filters) {
                // Apply filters based on the selected checkboxes within a group
//                if (in_array('online', $filters)) {
//                    $query->orWhere('order_type', 'online');
//                }
//
//                if (in_array('manual', $filters)) {
//                    $query->orWhere('order_type', 'manual');
//                }

                if (in_array('delivery', $filters)) {
                    $query->orWhere('order_type', OrderType::Delivery);
                }

                if (in_array('takeaway', $filters)) {
                    $query->orWhere('order_type', OrderType::TakeAway);
                }

                if (in_array('open', $filters)) {
                    $query->orWhere('order_status', '!=', OrderStatus::Delivered);
                }

                if (in_array('delivered', $filters)) {
                    $query->orWhere('order_status', OrderStatus::Delivered);
                }
            });
        }

        $orders = $orders->paginate(12, ['*'], 'page', $pageNumber);
        return [
            'orders' => $orders,
        ];
    }



    public function getRealTimeOrder(Request $request)
    {
        try {
            $orders = Order::with('orderUserDetails')->where('is_cart', '0')->orderBy('id', 'desc')->first();
            $userDetails = $orders->orderUserDetails;
            $address = getRestaurantDetail()->rest_address;
            if ($orders->order_type == OrderType::Delivery) {
                $address = $userDetails->house_no . ', ' . $userDetails->street_name . ', ' . $userDetails->city . ', ' . $userDetails->zipcode;
            }
            $orderDeliveryTime = (int) Str::between(getRestaurantDetail()->delivery_time, '-', ' Min');
            $html = '<div class="order-col">
                                <div class="order-box">
                                    <div class="timing">
                                        <h3>'. date('H:i',strtotime(\Carbon\Carbon::parse($orders->created_at)->addMinutes($orderDeliveryTime)))  .'</h3>
                                        <label class="success">'. $orders->delivery_time .'</label>
                                    </div>

                                    <div class="details">
                                        <div class="left">
                                            <h4>'. $userDetails->order_name .'</h4>
                                            <p class="mb-0">'. $address .'</p>
                                        </div>

                                        <div class="right text-end ps-2">
                                            <p class="mb-0">'. date('d-m-y H:i',strtotime($orders->created_at)) .'</p>
                                            <p class="mb-0">Web #'. $orders->id .'</p>
                                        </div>
                                    </div>

                                    <div class="actions">
                                        <h5 class="mb-0 price_status"><b>€'. number_format($orders->total_amount, 2) .'</b>&nbsp;&nbsp;|&nbsp;&nbsp;Paid</h5>
                                        <a href="#" class="orderDetails btn '. orderStatusBox($orders)->color .'">'. orderStatusBox($orders)->text .'</a>
                                    </div>
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
}
