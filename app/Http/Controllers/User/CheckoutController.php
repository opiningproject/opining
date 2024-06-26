<?php

namespace App\Http\Controllers\User;

use App\Enums\OrderType;
use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Order;
use App\Models\User;
use App\Notifications\Admin\AdminOrderReceived;
use App\Notifications\User\OrderAccepted;
use Exception;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\CouponTransaction;
use App\Models\Dish;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Session, Response;
use Twilio\Rest\Client;

class CheckoutController extends Controller
{
    protected $twilioClient, $twilioNumber;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $account_sid = getenv("TWILIO_SID");
        $auth_token = getenv("TWILIO_AUTH_TOKEN");
        $this->twilioNumber = getenv("TWILIO_NUMBER");
        $this->twilioClient = new Client($account_sid, $auth_token);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        $cartTotal = $user->cart->dishDetails()->select(DB::raw('sum(qty * price) as total'))->get()->sum('total');

        return view('user.checkout.index', ['user' => $user, 'cartAmount' => $cartTotal]);
    }

    public function idealPayment()
    {
        $user = Auth::user();

        $payableAmount = orderTotalPayAmount();
        $paymentIntent = createPaymentIntent($user->stripe_cust_id, ($payableAmount * 100));

        return view('user.checkout.ideal-payment', ['paymentIntent' => $paymentIntent]);
    }

    public function placeOrderData(Request $request)
    {
        try {
            $user = Auth::user();
            $admin = User::whereUserRole('1')->first();
            $orderId = $user->cart->id;
            $textBody = trans('email.text.order_placed', ['order_no' => $orderId]);;

            $serviceCharges = getRestaurantDetail()->service_charge;
            $cartTotal = getCartTotalAmount();
            $deliveryCharges = 0.00;
            $couponDiscount = 0.00;
            $pointsRedeemed = 0;
            $pointClaimed = 0;
            $orderTime = null;

            if ($cartTotal > 20.00) {
                $pointClaimed = 1;
                if ($cartTotal > 30.00) {
                    $pointClaimed = 2;
                }
            }

            if ($request->del_radio == 'customize-time') {
                $orderTime = date('H:i:s', strtotime($request->del_time));
            }

            if ($user->cart->order_type == '1' && session('zipcode')) {
                $deliveryCharges = getDeliveryCharges(session('zipcode'))->delivery_charge;
            }

            if ($user->cart->coupon_id != null) {
                $couponDiscount = $cartTotal * ($user->cart->coupon->percentage_off / 100);
                $pointsRedeemed = $user->cart->coupon->points;
            }

            $totalAmtPaid = ($cartTotal + $serviceCharges + $deliveryCharges) - $couponDiscount;

            if ($pointClaimed > 0) {
                $user->increment('collected_points', $pointClaimed);
            }

            if (session('zipcode')) {
                if ($request->is_address_elected == 0) {
                    $user->address()->create([
                        'company_name' => $request->company_name,
                        'house_no' => $request->house_no,
                        'street_name' => $request->street_name,
                        'city' => $request->city,
                        'zipcode' => $request->zipcode,
                        'latitude' => $request->latitude,
                        'longitude' => $request->longitude
                    ]);
                } else {

                    Address::find($request->is_address_elected)->update([
                        'company_name' => $request->company_name,
                        'house_no' => $request->house_no,
                        'street_name' => $request->street_name,
                        'city' => $request->city,
                        'zipcode' => $request->zipcode,
                        'latitude' => $request->latitude,
                        'longitude' => $request->longitude
                    ]);
                }
            }

            $user->cart->orderUserDetails()->create([
                'order_name' => $request->first_name . ' ' . $request->last_name,
                'order_contact_number' => $request->phone_no,
                'company_name' => $request->company_name,
                'order_email' => $request->email,
                'house_no' => $request->house_no ?? null,
                'street_name' => $request->street_name ?? null,
                'city' => $request->city ?? null,
                'zipcode' => $request->zipcode ?? null,
                'latitude' => $request->latitude ?? null,
                'longitude' => $request->longitude ?? null
            ]);

            $user->cart()->update([
                'payment_type' => $request->payment_type,
                'delivery_charge' => $deliveryCharges,
                'platform_charge' => $serviceCharges,
                'total_amount' => $totalAmtPaid,
                'order_status' => '1',
                'order_time' => date('H:i:s'),
                'delivery_time' => $orderTime,
                'order_type' => session('zipcode') ? OrderType::Delivery : OrderType::TakeAway,
                'delivery_date' => date('Y/m/d'),
                'delivery_note' => $request->instructions ?? null,
                'receive_update_emails' => isset($request->receive_mail) ? '1' : '0',
                'points_redeemed' => $pointsRedeemed,
                'coupon_discount' => $couponDiscount,
                'points_claimed' => $pointClaimed,
                'payment_status' => '0',
            ]);

            $user->update([
                'enable_email_notification' => isset($request->receive_mail) ? '1' : '0',
            ]);

            if ($request->payment_type == '2') {

               /* foreach ($user->cart->dishDetails as $dish) {
                    Dish::find($dish->dish_id)->decrement('qty', $dish->qty);
                }*/

                if(!empty($user->cart->coupon)){

                    $couponTransaction = CouponTransaction::where('coupon_id',$user->cart->coupon_id)
                        ->where('user_id',$user->id)->where('is_redeemed','0')->first();

                    if(!empty($couponTransaction)) {
                        $couponTransaction->update([
                            'is_redeemed' => '1'
                        ]);
                    }

                    // Commented as per new coupon flow June CR Points
                    // if(is_null($user->cart->coupon->points)){
                    //     $user->coupons()->create([
                    //         'coupon_id' => $user->cart->coupon_id,
                    //         'is_redeemed' => '1'
                    //     ]);
                    // }else{
                    //     $user->coupons()->where('coupon_id', $user->cart->coupon_id)->update([
                    //         'is_redeemed' => '1'
                    //     ]);
                    // }
                }

                $user->cart->dishDetails()->update([
                    'is_cart' => '0'
                ]);

                $user->cart()->update([
                    'is_cart' => '0'
                ]);

                //Notification New Order
                $order = Order::find($orderId);
                $user->notify(new OrderAccepted($order));
                $admin->notify(new AdminOrderReceived($order));

            } elseif ($request->payment_type == '1') {
                $expiryDate = explode('/', $request->exp_date);
                $paymentIntent = createPaymentIntent($user->stripe_cust_id, ($totalAmtPaid * 100));
                $stripe = new \Stripe\StripeClient(config('params.stripe.sandbox.secret_key'));

                $source = $stripe->customers->createSource($user->stripe_cust_id, [
                    'source' => [
                        'exp_month' => $expiryDate[0],
                        'exp_year' => $expiryDate[1],
                        'number' => $request->card_number,
                        'cvc' => $request->cvv,
                        'name' => $request->card_name,
                        'object' => 'card'
                    ]
                ]);
                /*  $source = $stripe->customers->createSource($user->stripe_cust_id, [
                      'source' => 'tok_visa'
                  ]);*/

                $cardPaymentResponse = $stripe->paymentIntents->confirm(
                    $paymentIntent->id,
                    [
                        'payment_method' => $source->id,
                        'return_url' => url('/').'/user/redirect-online-payment'
                    ]
                );

                if ($cardPaymentResponse->status == 'succeeded') {
                    /*foreach ($user->cart->dishDetails as $dish) {
                        Dish::find($dish->dish_id)->decrement('qty', $dish->qty);
                    }*/
                    $user->cart->dishDetails()->update([
                        'is_cart' => '0'
                    ]);

                    if(!empty($user->cart->coupon)){

                        $couponTransaction = CouponTransaction::where('coupon_id',$user->cart->coupon_id)
                        ->where('user_id',$user->id)->where('is_redeemed','0')->first();

                        if(!empty($couponTransaction)) {
                            $couponTransaction->update([
                                'is_redeemed' => '1'
                            ]);
                        }

                        // Commented as per new coupon flow June CR Points
                        // $user->coupons()->where('coupon_id', $user->cart->coupon_id)->update([
                        //     'is_redeemed' => '1'
                        // ]);
                    }

                    $user->cart->update([
                        'transaction_id' => $cardPaymentResponse->id,
                        'is_cart' => '0',
                        'payment_status' => '1',
                    ]);
                    $response['cardPayment'] = 200;

                    //Notification New Order
                    $order = Order::find($orderId);

                    $this->twilioClient->messages->create('+91'.$request->phone_no,
                        ['from' => $this->twilioNumber, 'body' => $textBody] );

                    $user->notify(new OrderAccepted($order));
                    $admin->notify(new AdminOrderReceived($order));

                } else if ($cardPaymentResponse->status == 'requires_action'){
                    $response['cardPayment'] = 402;
                    $response['redirectionUrl'] = $cardPaymentResponse->next_action->redirect_to_url->url;
                }else{
                    $user->decrement('collected_points', $user->cart->points_claimed);

                    $user->cart->update([
                        'payment_status' => null,
                        'payment_type' => null,
                        'delivery_charge' => 0,
                        'platform_charge' => 0,
                        'total_amount' => 0,
                        'order_status' => null,
                        'order_time' => null,
                        'delivery_time' => null,
                        'delivery_date' => null,
                        'delivery_note' => '',
                        'receive_update_emails' => '0',
                        'points_redeemed' => 0,
                        'coupon_discount' => 0,
                        'points_claimed' => 0,
                    ]);

                    $user->cart->orderUserDetails->forceDelete();
                    $response['cardPayment'] = 500;
                }
            }elseif ($request->payment_type == '3'){
                if ($request->payment_type == '3') {
                    $response['paymentIntent'] = createPaymentIntent($user->stripe_cust_id, ($totalAmtPaid * 100));
                }
            }

            $response['data'] = trans('user.message.order_success');

            return response::json(['status' => 200, 'message' => $response]);
        } catch (Exception $e) {
            return response::json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }

    public function redirectedOnlinePayment(Request $request)
    {
        try {
            $user = Auth::user();
            $admin = User::whereUserRole('1')->first();
            $orderId = $user->cart->id;
            $textBody = trans('email.text.order_placed', ['order_no' => $orderId]);;

            if ($request->redirect_status == 'succeeded') {

                /*foreach ($user->cart->dishDetails as $dish) {
                    Dish::find($dish->dish_id)->decrement('qty', $dish->qty);
                }*/
                $user->cart->dishDetails()->update([
                    'is_cart' => '0'
                ]);

                if(!empty($user->cart->coupon)){

                    $couponTransaction = CouponTransaction::where('coupon_id',$user->cart->coupon_id)
                    ->where('user_id',$user->id)->where('is_redeemed','0')->first();

                    if(!empty($couponTransaction)) {
                        $couponTransaction->update([
                            'is_redeemed' => '1'
                        ]);
                    }


                    // Commented as per new coupon flow June CR Points
                    // $user->coupons()->where('coupon_id', $user->cart->coupon_id)->update([
                    //     'is_redeemed' => '1'
                    // ]);
                }

                $user->cart->update([
                    'transaction_id' => $request->payment_intent,
                    'is_cart' => '0',
                    'payment_status' => '1',
                ]);

                $order = Order::find($orderId);

                $this->twilioClient->messages->create('+91'.$order->orderUserDetails->order_contact_number,
                    ['from' => $this->twilioNumber, 'body' => $textBody] );

                $user->notify(new OrderAccepted($order));
                $admin->notify(new AdminOrderReceived($order));

                return redirect()->route('user.orders');

            } else if($request->redirect_status == 'failed'){
                $user->decrement('collected_points', $user->cart->points_claimed);

                $user->cart->update([
                    'payment_status' => null,
                    'payment_type' => null,
                    'delivery_charge' => 0,
                    'platform_charge' => 0,
                    'total_amount' => 0,
                    'order_status' => null,
                    'order_time' => null,
                    'delivery_time' => null,
                    'delivery_date' => null,
                    'delivery_note' => '',
                    'receive_update_emails' => '0',
                    'points_redeemed' => 0,
                    'coupon_discount' => 0,
                    'points_claimed' => 0,
                ]);

                $user->cart->orderUserDetails->forceDelete();

                return redirect()->route('user.checkout');
            }else{
                if(isset($request->payment_intent)){

                    $stripe = new \Stripe\StripeClient(config('params.stripe.sandbox.secret_key'));
                    $paymentIntent = $stripe->paymentIntents->retrieve($request->payment_intent, []);

                    if($paymentIntent->status == 'requires_payment_method'){
                        $user->decrement('collected_points', $user->cart->points_claimed);

                        $user->cart->update([
                            'payment_status' => null,
                            'payment_type' => null,
                            'delivery_charge' => 0,
                            'platform_charge' => 0,
                            'total_amount' => 0,
                            'order_status' => null,
                            'order_time' => null,
                            'delivery_time' => null,
                            'delivery_date' => null,
                            'delivery_note' => '',
                            'receive_update_emails' => '0',
                            'points_redeemed' => 0,
                            'coupon_discount' => 0,
                            'points_claimed' => 0,
                        ]);

                        $user->cart->orderUserDetails->forceDelete();

                        return redirect()->route('user.checkout');
                    }else{
                        /*foreach ($user->cart->dishDetails as $dish) {
                            Dish::find($dish->dish_id)->decrement('qty', $dish->qty);
                        }*/

                        $user->cart->dishDetails()->update([
                            'is_cart' => '0'
                        ]);

                        if(!empty($user->cart->coupon)){


                            $couponTransaction = CouponTransaction::where('coupon_id',$user->cart->coupon_id)
                            ->where('user_id',$user->id)->where('is_redeemed','0')->first();
        
                            if(!empty($couponTransaction)) {
                                $couponTransaction->update([
                                    'is_redeemed' => '1'
                                ]);
                            }

                            // Commented as per new coupon flow June CR Points
                            // $user->coupons()->where('coupon_id', $user->cart->coupon_id)->update([
                            //     'is_redeemed' => '1'
                            // ]);
                        }

                        $user->cart->update([
                            'transaction_id' => $request->payment_intent,
                            'is_cart' => '0',
                            'payment_status' => '1',
                        ]);

                        $order = Order::find($orderId);

                        $this->twilioClient->messages->create('+91'.$order->orderUserDetails->order_contact_number,
                            ['from' => $this->twilioNumber, 'body' => $textBody]);

                        $user->notify(new OrderAccepted($order));
                        $admin->notify(new AdminOrderReceived($order));

                        return redirect()->route('user.orders');
                    }
                }
            }
        } catch (Exception $e) {
            return response::json([500, 'message' => $e->getMessage()]);
        }
    }
}
