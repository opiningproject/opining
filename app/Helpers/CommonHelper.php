<?php

use App\Models\Address;
use App\Models\Dish;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\RestaurantOperatingHour;
use App\Models\Zipcode;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image as Image;
use App\Models\RestaurantDetail;
use App\Models\User;
use App\Enums\OrderStatus;
use App\Enums\OrderType;

if (!function_exists('activeMenu')) {
    function activeMenu($path)
    {
        $path = explode('.', $path);
        $segment = 1;
        foreach ($path as $p) {
            if (request()->segment($segment) != $p) {
                return '';
            }
            $segment++;
        }
        return 'active';
    }
}

if (!function_exists('uploadImageToBucket')) {
    function uploadImageToBucket($request, $type, $deleteImg = '')
    {
        if (!empty($deleteImg) && Storage::disk('s3')->exists($type . '/' . $deleteImg)) {
            Storage::disk('s3')->delete($type . '/' . $deleteImg);
            Storage::disk('s3')->delete($type . '/thumb/' . $deleteImg);
        }

        $file = $request->file('image');
        $file_name = time() . '_' . $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();

        if ($extension == 'jpg' || $extension == 'jpeg' || $extension == 'png') {
            $image = Image::make($file)->resize(300, 300);
            Storage::disk('s3')->put('/' . $type . '/thumb/' . $file_name, $image->stream());
        }

        $filePath = $type . '/' . $file_name;
        Storage::disk('s3')->put($filePath, file_get_contents($file));

        return $file_name;
    }
}

if (!function_exists('uploadAttachmentToBucket')) {
    function uploadAttachmentToBucket($request, $type, $deleteImg = '')
    {
        if (!empty($deleteImg) && Storage::disk('s3')->exists($type . '/' . $deleteImg)) {
            Storage::disk('s3')->delete($type . '/' . $deleteImg);
            Storage::disk('s3')->delete($type . '/thumb/' . $deleteImg);
        }

        $file = $request->file('file');
        $file_name = $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();

        if ($extension == 'jpg' || $extension == 'jpeg' || $extension == 'png') {
            $image = Image::make($file)->resize(300, 300);
            Storage::disk('s3')->put('/' . $type . '/thumb/' . $file_name, $image->stream());
        }

        $filePath = $type . '/' . $file_name;
        Storage::disk('s3')->put($filePath, file_get_contents($file));

        return $file_name;
    }
}

if (!function_exists('uploadPermitDocImageToBucket')) {
    function uploadPermitDocImageToBucket($request, $type, $deleteImg = '')
    {
        if (!empty($deleteImg) && Storage::disk('s3')->exists($type . '/' . $deleteImg)) {
            Storage::disk('s3')->delete($type . '/' . $deleteImg);
            Storage::disk('s3')->delete($type . '/thumb/' . $deleteImg);
        }

        $file = $request->file('permit-doc');
        $file_name = time() . '_' . $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();

        if ($extension == 'jpg' || $extension == 'jpeg' || $extension == 'png') {
            $image = Image::make($file)->resize(300, 300);
            Storage::disk('s3')->put('/' . $type . '/thumb/' . $file_name, $image->stream(), 'public');
        }

        $filePath = $type . '/' . $file_name;
        Storage::disk('s3')->put($filePath, file_get_contents($file));

        return $file_name;
    }
}


if (!function_exists('uploadFooterLogoToBucket')) {
    function uploadFooterLogoToBucket($request, $type, $deleteImg = '')
    {
        if (!empty($deleteImg) && Storage::disk('s3')->exists($type . '/' . $deleteImg)) {
            Storage::disk('s3')->delete($type . '/' . $deleteImg);
            Storage::disk('s3')->delete($type . '/thumb/' . $deleteImg);
        }

        $file = $request->file('footer-img');
        $file_name = time() . '_' . $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();

        if ($extension == 'jpg' || $extension == 'jpeg' || $extension == 'png') {
            $image = Image::make($file)->resize(300, 300);
            Storage::disk('s3')->put('/' . $type . '/thumb/' . $file_name, $image->stream(), 'public');
        }

        $filePath = $type . '/' . $file_name;
        Storage::disk('s3')->put($filePath, file_get_contents($file));

        return $file_name;
    }
}

if (!function_exists('checkValidation')) {
    function checkValidation($request, $validate)
    {
        $validator = Validator::make($request->all(), $validate);
        if ($validator->fails()) {
            return $validator->messages()->first();
        } else {
            return '';
        }
    }
}

if (!function_exists('getRestaurantDetail')) {
    function getRestaurantDetail()
    {
        $rest = RestaurantDetail::findOrFail(1);

        return $rest;
    }
}

if (!function_exists('getOrderDishIngredients')) {
    function getOrderDishIngredients($dish)
    {
        $ingredients = '';

        $dishData = Dish::withTrashed()->find($dish->dish_id);

        if($dish->orderDishFreeIngredients->count() != $dishData->freeWithoutTrashIngredients->count()){
            $ingredients .= '-';
            $ingArray = $dish->orderDishFreeIngredients->pluck('dish_ingredient_id')->all();

            foreach ($dishData->freeWithoutTrashIngredients as $freeIngredient) {
                if(!in_array($freeIngredient->id, $ingArray)){
                    $ingredients .= $freeIngredient->ingredient->name.', ';
                }
            }
        }

        if (count($dish->orderDishPaidIngredients)>0) {
            $ingredients .= '+';
            foreach ($dish->orderDishPaidIngredients as $key => $ingredient) {
                $ingredients .= $ingredient->dishIngredient->ingredient->name;

                $ingredients .= "($ingredient->quantity" . "x), ";

            }
        }

        return trim($ingredients, ', ');

    }
}

if (!function_exists('getDeliveryCharges')) {
    function getDeliveryCharges($zipcode)
    {
        $zip =substr($zipcode, 0, 4);
        $zipcode = Zipcode::whereRaw("LEFT(zipcode,4) = '$zip'")->where('status','1')->first();

        return $zipcode;
    }
}

if (!function_exists('getOrderTotalPrice')) {
    function getOrderTotalPrice($itemPrice, $order)
    {
        return number_format((float)($itemPrice + ($order->platform_charge + $order->delivery_charge) - $order->coupon_discount),2);
    }
}

if (!function_exists('createStripeCustomer')) {
    function createStripeCustomer($name, $email)
    {
        try {
            $stripe = new \Stripe\StripeClient(config('params.stripe.sandbox.secret_key'));

            return $stripe->customers->create([
                'name' => $name,
                'email' => $email,
            ]);
        } catch (Exception $e) {
            return response::json(['status' => 0, 'message' => 'Something went wrong.']);
        }
    }
}

if (!function_exists('createPaymentIntent')) {
    function createPaymentIntent($stripe_cust_id, $price)
    {
        $stripe = new \Stripe\StripeClient(config('params.stripe.sandbox.secret_key'));

        return $stripe->paymentIntents->create([
            'payment_method_types' => ['ideal', 'card'],
            'amount' => $price,
            'currency' => 'eur',
            'customer' => $stripe_cust_id
        ]);

    }
}

if (!function_exists('getCartTotalAmount')) {
    function getCartTotalAmount()
    {
        $user = Auth::user();
        $cartTotal = $user->cart->dishDetails()->get()->sum('dish_price');
        $cartIngredient = $user->cart->dishDetails()->get()->sum('paid_ingredient_total');
        return (float)($cartTotal + $cartIngredient);
    }

}

if (!function_exists('orderTotalPayAmount')) {
    function orderTotalPayAmount()
    {
        $user = Auth::user();
        $cartTotal = $user->cart->dishDetails()->get()->sum('dish_price');
        $cartIngredient = $user->cart->dishDetails()->get()->sum('paid_ingredient_total');
        $cartTotal = $cartTotal + $cartIngredient;
        $serviceCharge = getRestaurantDetail()->service_charge;
        $zipcode = session('zipcode');
        $deliveryCharges = 0.00;

        if ($zipcode) {
            $deliveryCharges = getDeliveryCharges($zipcode)->delivery_charge;
        }
        $couponDiscount = isset($user->cart->coupon) ? ($user->cart->coupon->percentage_off / 100) * $cartTotal : 0;

        return number_format((float)(($cartTotal + $serviceCharge + $deliveryCharges) - $couponDiscount),2);
    }
}

if (!function_exists('getAddressDetails')) {
    function getAddressDetails($addressId)
    {
        $addressData = Address::find($addressId);

        return $addressData;
    }
}


if (!function_exists('getOrderGrossAmount')) {
    function getOrderGrossAmount($order)
    {
        return (float)$order->total_amount - (float)$order->platform_charge - (float)$order->delivery_charge + (float)$order->coupon_discount;
    }
}

if (!function_exists('getRestaurantOpenTime')) {
    function getRestaurantOpenTime()
    {
        $today = date('l');

        $openingHours = RestaurantOperatingHour::where('day', $today)->first();
        return $openingHours;
    }
}

if (!function_exists('isEmpty')) {
    function isEmpty($data)
    {
        foreach ($data as $val)
        {
          if($val == '')
          {
             $is_empty = true;
             break;
          }
          else
          {
             $is_empty = false;
          }
        }

        return $is_empty;
    }
}

if (!function_exists('getProfile')) {
    function getProfile($user_id)
    {
        $user = User::select('id','user_role','social_id','first_name','last_name','email','image','phone_no','password')->find($user_id);
        $user->country_code = '+'.$user->country_code;
        return $user;
    }
}
if (!function_exists('logs')) {
    function logs($data)
    {
        $myfile = fopen('log.txt', "a") or die("Unable to open file!");
        fwrite($myfile, json_encode($data)."\r\n");
        fclose($myfile);
    }
}



if (!function_exists('getOrderStatus')) {
    function getOrderStatus($order)
    {
        if($order->order_type == OrderType::Delivery)
        {
            if($order->order_status == OrderStatus::Accepted)
            {
                $order->order_status = OrderStatus::InKitchen;
            }
            else if($order->order_status == OrderStatus::InKitchen)
            {
                $order->order_status = OrderStatus::Ready;
            }
            else if($order->order_status == OrderStatus::Ready)
            {
                $order->order_status = OrderStatus::OutForDelivery;
            }
            else
            {
                $order->order_status = OrderStatus::Delivered;
            }
        }
        else
        {
            if($order->order_status == OrderStatus::Accepted)
            {
                $order->order_status = OrderStatus::InKitchen;
            }
            else if($order->order_status == OrderStatus::InKitchen)
            {
                $order->order_status = OrderStatus::ReadyForPickup;
            }
            else if($order->order_status == OrderStatus::ReadyForPickup)
            {
                $order->order_status = OrderStatus::Delivered;
            }
        }

        return $order;
    }
}

if (!function_exists('restaurantDeliveringOption')) {
    function restaurantDeliveringOption()
    {
        return RestaurantDetail::find(1)->online_order_accept;
    }
}

if (!function_exists('getAdminUser')) {
    function getAdminUser () {
        return User::where('user_role', '1')->first();
    }
}
