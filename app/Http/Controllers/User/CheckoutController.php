<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Dish;
use Auth;
use Illuminate\Support\Facades\DB;
use Session;

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

}
