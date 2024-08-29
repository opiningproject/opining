<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\TrackOrder;
use App\Notifications\User\RefundRequest;
use Illuminate\Http\Request;
use App\Models\DishFavorites;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderUserDetail;
use App\Enums\OrderStatus;
use App\Enums\OrderType;
use App\Enums\RefundStatus;
use \Mpdf\Mpdf as PDF;
use Illuminate\Support\Facades\Storage;
use Response;

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
    public function index(Request $request)
    {
        $user_id = Auth::user()->id;

        $active_orders = Order::where('user_id', $user_id)->where('is_cart', '0')->where('order_status', '<>', OrderStatus::Delivered)->orderBy('id', 'desc')->get();
        $orders = Order::where('user_id', $user_id)->where('is_cart', '0')->where('order_status', OrderStatus::Delivered)->orderBy('id', 'desc')->paginate(10);

        $order = '';

        if ($request->order_id) {
            $order = Order::find($request->order_id);
        } else {
            if (count($active_orders)) {
                $order = $active_orders[0];
            } else if (count($orders)) {
                $order = $orders[0];
            }
        }
        if ($request->ajax()) {
            return view('user.orders.overview-order-list', ['orders' => $orders, 'order' => $order]);
        }
        return view('user.orders.orders', ['orders' => $orders, 'active_orders' => $active_orders, 'order' => $order, 'lastPage' => $orders->lastPage()]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function ordersDetailMobile(Request $request)
    {
        $user_id = Auth::user()->id;

        $active_orders = Order::where('user_id', $user_id)->where('is_cart', '0')->where('order_status', '<>', OrderStatus::Delivered)->orderBy('id', 'desc')->get();
        $orders = Order::where('user_id', $user_id)->where('is_cart', '0')->where('order_status', OrderStatus::Delivered)->orderBy('id', 'desc')->paginate(10);

        $order = '';
        if ($request->order_id) {
            $order = Order::find($request->order_id);
        } else {
            if (count($active_orders)) {
                $order = $active_orders[0];
            } else if (count($orders)) {
                $order = $orders[0];
            }
        }
        if ($request->order_id) {
            return view('user.orders.order-detail-mobile', ['orders' => $orders, 'order' => $order]);
        }
        return view('user.orders.orders', ['orders' => $orders, 'active_orders' => $active_orders, 'order' => $order, 'lastPage' => $orders->lastPage()]);
    }

    public function orderLocation(Request $request)
    {
        $order = OrderUserDetail::where('order_id', $request->order_id)->first();

        return view('user.orders.order-location', ['order' => $order]);
    }

    // Cr aug new track order page controller
    public function orderLocationNew(Request $request)
    {
        $order = OrderUserDetail::where('order_id', $request->order_id)->first();
        $trackOrder = TrackOrder::where('order_id', $order->order_id)->get();
        if (count($trackOrder) == 0) {
            return redirect()->back();
        }
        return view('user.orders.order-location-new', ['order' => $order, 'trackOrder' => $trackOrder]);
    }

    public function orderDetail(Request $request)
    {
        $order = Order::find($request->order_id);

        return view('user.orders.order-detail', ['order' => $order]);
    }

    public function downloadInvoice(Request $request)
    {
        $order = Order::find($request->order_id);

        $documentFileName = "invoice" . $request->order_id . ".pdf";

        $document = new PDF([
            'mode' => 'utf-8',
            'format' => 'A4',
            'margin_header' => '3',
            'margin_top' => '20',
            'margin_bottom' => '20',
            'margin_footer' => '2',
        ]);

        // Set some header informations for output
        $header = [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $documentFileName . '"'
        ];

        // return view('user.orders.invoice',['order' => $order]);
        $output = $document->WriteHTML(view('user.orders.invoice', ['order' => $order]));
        $document->Output($documentFileName, 'D');
    }

    public function orderPrintLabel(string $id)
    {
        $order = Order::find($id);

        $taxedValue = 0.09 * (float)$order->total_amount;
        $differenceValue = $order->total_amount - $taxedValue;

        $order->sub_total = $differenceValue;
        $order->tax_amount = $taxedValue;
        return view('user.orders.orders-print-label', ['order' => $order]);
    }

    public function sendRefundRequest(Request $request)
    {
        try {

            $admin = User::whereUserRole('1')->first();

            $order = Order::find($request->order_id);
            $order->refund_status = RefundStatus::Pending;
            $order->refund_description = $request->description;
            $order->save();

            $admin->notify(new RefundRequest($order));

            return response::json(['status' => 1, 'message' => '']);
        } catch (Exception $e) {
            return response::json(['status' => 0, 'message' => $e->getMessage()]);
        }
    }


}
