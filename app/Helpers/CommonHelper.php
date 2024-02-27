<?php

use App\Models\Address;
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

if (!function_exists('deleteImage')) {
    function deleteImage($type, $id)
    {
        $food_image = FoodImages::find($id);
        $image = $food_image->getRawOriginal('image');

        if (!empty($food_image) && Storage::disk('s3')->exists($type . '/' . $image)) {
            Storage::disk('s3')->delete($type . '/' . $image);
            Storage::disk('s3')->delete($type . '/thumb/' . $image);

            $food_image->delete();
        }
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
        /*echo "<pre>";
        print_r($dish->orderDishPaidIngredients->sum('total'));
        exit;*/

        $ingredients = '';

        if (!empty($dish->orderDishIngredients)) {
            foreach ($dish->orderDishIngredients as $key => $ingredient) {
                $ingredients .= $ingredient->dishIngredient->ingredient->name;

                $ingredients .= $ingredient->is_free ? ', ' : "($ingredient->quantity" . "x), ";

            }
        }

        return trim($ingredients, ', ');

    }
}

if (!function_exists('getDeliveryCharges')) {
    function getDeliveryCharges($zipcode)
    {
        $zipcode = Zipcode::where([
            ['zipcode', $zipcode],
            ['status', '1']
        ])->first();

        return $zipcode;
    }
}

if (!function_exists('getOrderTotalPrice')) {
    function getOrderTotalPrice($itemPrice, $order)
    {
        return $itemPrice + ($order->platform_charge + $order->delivery_charge) - $order->coupon_discount;
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
        return ($cartTotal + $cartIngredient);
    }

}

if (!function_exists('orderTotalPayAmount')) {
    function orderTotalPayAmount()
    {
        $user = Auth::user();
        $cartTotal = $user->cart->dishDetails()->select(DB::raw('sum(qty * price) as total'))->get()->sum('total');
        $cartIngredient = $user->cart->dishDetails()->get()->sum('paid_ingredient_total');
        $cartTotal = $cartTotal + $cartIngredient;
        $serviceCharge = getRestaurantDetail()->service_charge;
        $zipcode = session('zipcode');
        $deliveryCharges = 0.00;

        if ($zipcode) {
            $deliveryCharges = getDeliveryCharges($zipcode)->delivery_charge;
        }
        $couponDiscount = isset($user->cart->coupon) ? ($user->cart->coupon->percentage_off / 100) * $cartTotal : 0;

        return ($cartTotal + $serviceCharge + $deliveryCharges) - $couponDiscount;
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
        return ($order->total_amount - $order->platform_charge - $order->delivery_charge + $order->coupon_discount);
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
