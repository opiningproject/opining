<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Enums\OrderStatus;
use App\Enums\RefundStatus;
class OrderController extends Controller
{
    public function getOrders(Request $request){
        
        $user_id=Auth::user()->id;

        $orders = Order::where('user_id', $user_id)->with(['dishDetails','dishDetails.orderDishDetails','orderUserDetails'])->where('is_cart', '0')->orderBy('id', 'desc')->get();
        
        if ($request->order_id) {

            $order=$orders->find($request->order_id);

            return response()->json([
                    'status' => '1',
                    'message' => trans('api.order_detail_data'),
                    'data' => $order,
                ], 200);

        } else {

            return response()->json([
                    'status' => '1',
                    'message' => trans('api.order_data'),
                    'data' => $orders,
                ], 200);
        }

    }
    public function refundRequest(Request $request)
    {
        $data = $request->all('order_id');

        if(isEmpty($data) == 1)
        {
            return response()->json([
            'status' => '0',
            'message' => trans('api.something_wrong'),
            ], 200);
        }

        $order = Order::find($request->order_id);
        $order->refund_status = RefundStatus::Pending;
        $order->refund_description = $request->description;
        $order->save();

        return response()->json(['status' => 1, 'message' => 'api.status_change_sucess']);
        
    }
}
