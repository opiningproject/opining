<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\DelivererUser;
use App\Models\Dish;
use App\Models\Order;
use App\Models\RestaurantDetail;
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
//        $perPage = request()->input('per_page', 24);
        $perPage = session('per_page', 24);

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
                $start_date = date('Y-m-d') . ' 00:00:00';
                $end_date = date('Y-m-d', strtotime($end_date)) . ' 23:59:59';

                $orders->whereBetween('orders.created_at', array($start_date, $end_date));
            }

        $orders = $orders->paginate($perPage, ['*'], 'page', $pageNumber);
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
        $delivererUser = DelivererUser::where('status', '1')->get();
        $orderDeliveryTime = (int) Str::between(getRestaurantDetail()->delivery_time, '-', ' Min');
        $orderDetailHTML = view('admin.orders.order-detail-popup', ['order' => $order, 'orderDeliveryTime' => $orderDeliveryTime, 'delivererUser' => $delivererUser ])->render();

        return response()->json(['status' => 1, 'data' =>  $orderDetailHTML, 'order' => $order]);
    }

    public function changeStatusNew(Request $request)
    {
        $order = Order::find($request->id);
        $order = getOrderStatus($order);
        $orderStatus = 0;
        if ($order->save()) {
            $order->user->notify(new DeliveryTypeUpdate($order));
//            $this->sendMail($order);
        }
        if ($order->order_type == "1") {
            $addTrackOrder = TrackOrder::create([
                'order_id' => $order->id,
                'order_status' => $order->order_status
            ]);
        }
        if($order->order_status == OrderStatus::Delivered) {
            $orderStatus = OrderStatus::Delivered;
        }
        $orderData = Order::find($request->id);
        $trackOrderData = TrackOrder::where('order_id', $orderData->id)->where('order_status', $orderData->order_status)->first();
        $color = orderStatusBox($order)->color;
        $text = orderStatusBox($order)->text;
        return response()->json([
            'status' => 1,
            'orderStatus' => $orderStatus,
            'orderId' =>$orderData->id,
            'orderDate' => $trackOrderData ? $trackOrderData->created_at :'',
            'updatedStatus' =>$orderData->order_status,
            'text' =>$text,
            'color' =>$color
        ]);
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

    public function orderSearchFilter(Request $request) {
        $orderDeliveryTime = (int) Str::between(getRestaurantDetail()->delivery_time, '-', ' Min');
        $pageNumber = request()->input('page', 1);
//        $perPage = request()->input('per_page', 24);
        $perPage = session('per_page', 24);
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
                        $query->where('order_contact_number', $searchTerm);
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
                        // Search within the orders table for 'id'
                        $query->where('id', $searchTerm)
                            // Search within the 'orderUserDetails' relationship
                            ->orWhereHas('orderUserDetails', function ($query) use ($searchTerm) {
                                $query->where('order_name', 'like', '%' . $searchTerm . '%')
                                    ->orWhere('house_no', 'like', '%' . $searchTerm . '%')
                                    ->orWhere('street_name', 'like', '%' . $searchTerm . '%')
                                    ->orWhere('city', 'like', '%' . $searchTerm . '%')
                                    ->orWhere('zipcode', 'like', '%' . $searchTerm . '%')
                                    ->orWhere('order_contact_number', $searchTerm);
                            })
                            // Search within the 'dishDetails' and the related 'dish' relationship
                            ->orWhereHas('dishDetails', function ($query) use ($searchTerm) {
                                $query->whereHas('dish', function ($subQuery) use ($searchTerm) {
                                    $subQuery->where('name_en', 'like', '%' . $searchTerm . '%')
                                        ->orWhere('name_nl', 'like', '%' . $searchTerm . '%');
                                });
                            });
                    });

                    break;
            }
        }
        $filters = $request->filters;

        if (!empty($filters)) {
            $orders->where(function($query) use ($filters) {
                // Apply filters based on the selected checkboxes within a group
                if (in_array('online', $filters)) {
                    $query->orWhere('is_online_order', '1');
                }

                if (in_array('manual', $filters)) {
                    $query->orWhere('is_online_order', '0');
                }

                if (in_array('delivery', $filters)) {
                    $query->orWhere('order_type', OrderType::Delivery)->where('order_status', '!=', OrderStatus::Delivered);
                }

                if (in_array('takeaway', $filters)) {
                    $query->orWhere('order_type', OrderType::TakeAway)->where('order_status', '!=', OrderStatus::Delivered);
                }

                if (in_array('open', $filters)) {
                    $query->orWhere('order_status', '!=', OrderStatus::Delivered)->where('order_status', '!=', OrderStatus::Delivered);
                }

                if (in_array('delivered', $filters)) {
                    $query->orWhere('order_status', OrderStatus::Delivered);
                }
            });
        }
        $orders = $orders->paginate($perPage, ['*'], 'page', $pageNumber);

        return [
            'orders' => $orders
        ];
    }

    /**
     * @param $request
     * @return array
     */
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

        $orders = $orders->paginate(24, ['*'], 'page', $pageNumber);
        return [
            'orders' => $orders,
        ];
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getRealTimeOrder(Request $request)
    {
        try {
            $orders = Order::with('orderUserDetails')->where('is_cart', '0')->orderBy('id', 'desc')->first();
            $userDetails = $orders->orderUserDetails;
            $address = getRestaurantDetail()->rest_address;
            $order_type = trans('rest.food_order.take_away');
            if ($orders->order_type == OrderType::Delivery) {
                $address = $userDetails->house_no . ', ' . $userDetails->street_name;
                $order_type = trans('rest.food_order.delivery');
            }
            $iconImage = asset('images/cod_icon.png');
            if($ord->payment_type == \App\Enums\PaymentType::Card){
                $iconImage = asset('images/paid-deal.svg');
            }
            if($ord->payment_type == \App\Enums\PaymentType::Ideal) {
                $iconImage = asset('images/paid-deal.svg');
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
                                    </div>

                                    <div class="actions">
                                        <h5 class="mb-0 price_status"><b>€'. number_format($orders->total_amount, 2) .'</b>&nbsp;&nbsp;|<img src="'.$iconImage .'" class="svg" height="20" width="20"/></h5>
                                        <button href="#" class="orderDetails order-status-'.$orders->id.' btn '. orderStatusBox($orders)->color .'" onclick="orderDetailNew('.$orders->id.')">'. orderStatusBox($orders)->text .'</button>
                                    </div>
                                </div>
                            </div>';
            return response()->json(['data' => $html]);

        } catch (Exception $exception) {
            return response::json(['status' => 400, 'message' => $exception->getMessage()]);
        }
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
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

    /**
     * @param $order_id
     * @param $deliverer_id
     * @return mixed
     */
    public function addDeliverer($order_id, $deliverer_id)
    {
        try {
            // Perform the update
            Order::where('id', $order_id)->update(['deliverer_id' => $deliverer_id]);
            return response::json(['status' => 1, 'message' => 'Deliverer added successfully']);

        } catch (Exception $exception) {
            return response::json(['status' => 400, 'message' => '']);
        }
    }

    public function updateOrderSetting(Request $request)
    {
        $value = [
            'expiry_date' => $request->expiry_date,
            'timezone_setting' => $request->timezone_setting ? $request->timezone_setting : null,
            'order_setting_type' => $request->order_setting_type,
        ];
        $restaurant = RestaurantDetail::findOrFail(1); // Fetch the restaurant detail

        $params = json_decode($restaurant->params, true);

        if (is_null($params)) {
            $params = [];
        }
        $params['order_settings'] = $value; // Store all request data under 'order_settings'
        $restaurant->params = json_encode($params);
        $restaurant->save();

        return response()->json(['status' => 'success', 'message' => trans('rest.settings.checkout_setting.payment_setting_updated')]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateDeliveryTime(Request $request)
    {
        $getOrderData = Order::find($request->orderId);
        $updatedDeliveryTime = \Carbon\Carbon::parse($request->curruntTime)->addMinutes($request->getMinute);
        $getOrderData->expected_delivery_time = $updatedDeliveryTime->format('H:i:s');
        $getOrderData->save();
        $expected_delivery_time = date('H:i', strtotime($getOrderData->expected_delivery_time));
        return response()->json(['status' => 'success', 'orderId'=>$getOrderData->id,'expected_time_order'=>$expected_delivery_time, 'message' => trans('rest.settings.checkout_setting.payment_setting_updated')]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getOrderSetting(Request $request)
    {
        $getOrderData = Order::find($request->orderId);
        $updatedDeliveryTime = \Carbon\Carbon::parse($getOrderData->expected_delivery_time)->addMinutes($request->getMinute);
        $getOrderData->expected_delivery_time = $updatedDeliveryTime->format('H:i:s');
        $getOrderData->save();
        $expected_delivery_time = date('H:i', strtotime($getOrderData->expected_delivery_time));
        return response()->json(['status' => 'success', 'orderId'=>$getOrderData->id,'expected_time_order'=>$expected_delivery_time, 'message' => trans('rest.settings.checkout_setting.payment_setting_updated')]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function cancelOrder(Request $request)
    {
        $getOrderData = Order::find($request->order_id);
        $getOrderData->order_status = $request->status;
        if ($getOrderData->save()) {
            $color = orderStatusBox($getOrderData)->color;
            $text = orderStatusBox($getOrderData)->text;
            return response()->json([
                'status' => 1,
                'orderId' =>$getOrderData->id,
                'updatedStatus' =>$getOrderData->order_status,
                'text' =>$text,
                'color' =>$color
            ]);
        }
    }
}
