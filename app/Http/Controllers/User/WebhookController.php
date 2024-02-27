<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use Response, Mail;
use JWTAuth;
use Stripe;
use Stripe\StripeClient;

class WebhookController extends Controller
{
    public function __construct()
    {
        $this->stripe = new \Stripe\StripeClient(config('params.stripe.sandbox.secret_key')); 
        Stripe\Stripe::setApiKey(config('params.stripe.sandbox.secret_key'));
    }

   public function paymentCallback(Request $request)
   {
        $payload = @file_get_contents('php://input');
        $event = null;

        try 
        {
            $event = \Stripe\Event::constructFrom(
                json_decode($payload, true)
            );
        } 
        catch(\UnexpectedValueException $e) 
        {
            // Invalid payload
            http_response_code(400);
            exit();
        }

        //$myfile = fopen('payment_notification.txt', "a") or die("Unable to open file!");
        //fwrite($myfile, date("Y-m-d g:i:s a").":\r\n\n".json_encode($event)."\n\n");
        //fclose($myfile);

        switch ($event->type) 
        {
          case 'payment_intent.succeeded':

            $payment_intent = $event->data->object;

            $order = Order::where('transaction_id',$payment_intent->id)->first();

            $order->payment_status = '1';
            $order->payment_response = json_encode($event);
            $order->save();

            $this->onPaymentSuccess($order);
            
            break;

          case 'payment_intent.payment_failed':

            $payment_intent = $event->data->object;

            $order = Order::where('transaction_id',$payment_intent->id)->first();

            if(!empty($order->id))
            {
                $order->payment_status = '2';
                $order->payment_response = json_encode($event);
                $order->save();
            }
            
            break;

          case 'payment_intent.canceled':

            $payment_intent = $event->data->object;

            $order = Order::where('transaction_id',$payment_intent->id)->first();

            if(!empty($order->id))
            {
                $order->payment_status = '2';
                $order->payment_response = json_encode($event);
                $order->save();
            }

            break;

          default:
            echo 'Received unknown event type ' . $event->type;
        }

        http_response_code(200);
    }

    public function refundPayment($transaction_id,$amount)
    {
        try 
        {
            $result = $this->stripe->refunds->create([
              'payment_intent' => $transaction_id,
              'amount' => $amount * 100
            ]);

            if($result->status == 'pending')
            {
                return response::json(['status' => '1', 'message' => trans('message.something_wrong')]);
            }
            else
            {
                return $result;
            }
            
        }
        catch(\Stripe\Exception\ApiErrorException $e) 
        {
            //echo $e->getError()->message;
            return response::json(['status' => '0', 'message' => $e->getError()->message]);
        } 
    }

    public function cancelPaymentIntent($id)
    {
        try
        {
            $this->stripe->paymentIntents->cancel(
              $id,
              []
            );
        }
        catch(\Stripe\Exception\ApiErrorException $e) 
        {
            return response::json(['status' => '0', 'message' => $e->getError()->message]);
        }
    }


}
