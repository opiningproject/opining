<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Dish;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Session, Response;

class CheckoutController extends Controller
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
        $user = Auth::user();
        $cartTotal = $user->cart->dishDetails()->select(DB::raw('sum(qty * price) as total'))->get()->sum('total');
        return view('user.checkout.index', ['user' => $user, 'cartAmount' => $cartTotal]);
    }

    public function idealPayment()
    {
        $user = Auth::user();

        $paymentIntent = createPaymentIntent($user->stripe_cust_id,300);

        return view('user.checkout.ideal-payment',['paymentIntent' => $paymentIntent]);
    }

    public function cardPayment()
    {
        $user = Auth::user();

        $paymentIntent = createPaymentIntent($user->stripe_cust_id,400);
        $stripe = new \Stripe\StripeClient(config('params.stripe.sandbox.secret_key'));

        try
        {
            $source = $stripe->customers->createSource($user->stripe_cust_id, ['source' => 'tok_visa']);

            $chargeResult = $stripe->paymentIntents->confirm(
                  $paymentIntent->id,
                  ['payment_method' => $source->id],

                );
        }
        catch(\Stripe\Exception\ApiErrorException $e)
        {
            return response::json(['status' => 0, 'message' => $e->getError()->message]);
        }

        print_r($chargeResult);
        exit;
    }
    public function placeOrderCashOnDelivery(Request $request){
        try{
            $user = Auth::user();

            $serviceCharges = getRestaurantDetail()->service_charge;
            $cartTotal = getCartTotalAmount();

            $deliveryCharges = 0.00;
            $couponDiscount = 0.00;
            $pointsRedeemed = 0;
            $pointClaimed = 0;
            $orderTime = null;

            if($cartTotal > 20.00){
                $pointClaimed = 1;
                if($cartTotal > 30.00){
                    $pointClaimed = 2;
                }
            }

            if($request->del_radio == 'customize-time'){
                $orderTime = date('H:i:s', strtotime($request->del_time));
            }

            if($user->cart->order_type == '1'){
                $deliveryCharges = getDeliveryCharges(session('zipcode'))->delivery_charge;
            }
            if($user->cart->coupon_id != null){
                $couponDiscount = $cartTotal * ($user->cart->coupon->percentage_off/100);
                $pointsRedeemed = $user->cart->coupon->points;
            }

            $totalAmtPaid = ($cartTotal + $serviceCharges + $deliveryCharges) - $couponDiscount;

            $user->cart->dishDetails()->update([
                'is_cart' => '0'
            ]);

            if($pointClaimed > 0){
                $user->increment('collected_points', $pointClaimed);
            }

            $user->address()->create([
                'company_name' => $request->company_name,
                'house_no' => $request->house_no,
                'street_name' => $request->street_name,
                'city' => $request->city,
                'zipcode' => $request->zipcode,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude
            ]);

            $user->cart->orderUserDetails()->create([
                'order_name' => $request->first_name . ' '. $request->last_name,
                'order_contact_number' => $request->phone_no,
                'company_name' => $request->company_name,
                'house_no' => $request->house_no,
                'street_name' => $request->street_name,
                'city' => $request->city,
                'zipcode' => $request->zipcode,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude
            ]);

            $user->cart()->update([
                'payment_type' => $request->payment_type,
                'delivery_charge' => $deliveryCharges,
                'platform_charge' => $serviceCharges,
                'total_amount' => $totalAmtPaid,
                'order_status' => '1',
                'order_time' => $orderTime,
                'delivery_date' => date('Y/m/d'),
                'delivery_note' => $request->instructions,
                'receive_update_emails' => isset($request->receive_mail) ? '1' : '0',
                'points_redeemed' => $pointsRedeemed,
                'coupon_discount' => $couponDiscount,
                'points_claimed' => $pointClaimed,
                'is_cart' => '0'
            ]);
            return response::json(['status' => 200, 'message' => 'Order Places successfully']);
        }catch (Exception $e){
            return response::json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }

}
