<?php

use App\Models\Address;
use App\Models\Dish;
use App\Models\DishCategoryOption;
use App\Models\DishOption;
use App\Models\DishOptionCategory;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\RestaurantOperatingHour;
use App\Models\Zipcode;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image as Image;
use App\Models\RestaurantDetail;
use App\Models\User;
use App\Models\Chat;
use App\Enums\OrderStatus;
use App\Enums\OrderType;
use GuzzleHttp\Client;

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

if (!function_exists('getOrderDishIngredients1')) {
    function getOrderDishIngredients1($dish)
    {
        $ingredients = '';

        $dishData = Dish::withTrashed()->find($dish->dish_id);

        if($dish->orderDishFreeIngredients->count() != $dishData->freeWithoutTrashIngredients->count()){
            // $ingredients .= '-';
            $ingArray = $dish->orderDishFreeIngredients->pluck('dish_ingredient_id')->all();

            foreach ($dishData->freeWithoutTrashIngredients as $freeIngredient) {
                if(!in_array($freeIngredient->id, $ingArray)){
                    // $ingredients .= $freeIngredient->ingredient->name.', ';
                    $ingredients .= "<li>-" .$freeIngredient->ingredient->name. "</li>";

                }
            }
        }

        if (count($dish->orderDishPaidIngredients)>0) {

            foreach ($dish->orderDishPaidIngredients as $key => $ingredient) {

                $price = $ingredient->quantity * $ingredient->price;
                $ingredients .= "<li>+" .$ingredient->dishIngredient->ingredient->name. "(€" .number_format($price, 2) . ")" . "</li>";

            }
        }

        return trim($ingredients, ', ');

    }
}

if (!function_exists('getOrderDishIngredients2')) {
    function getOrderDishIngredients2($dish)
    {
        $ingredients = [];
        $dishData = Dish::withTrashed()->find($dish->dish_id);

        // Check for missing free ingredients
        if ($dish->orderDishFreeIngredients->count() != $dishData->freeWithoutTrashIngredients->count()) {
            $ingArray = $dish->orderDishFreeIngredients->pluck('dish_ingredient_id')->all();

            foreach ($dishData->freeWithoutTrashIngredients as $freeIngredient) {
                if (!in_array($freeIngredient->id, $ingArray)) {
                    // Add missing free ingredients with a minus sign
                    $ingredients[] = "-" . $freeIngredient->ingredient->name;
                }
            }
        }

        // Add paid ingredients with a plus sign and price
        if (count($dish->orderDishPaidIngredients) > 0) {
            foreach ($dish->orderDishPaidIngredients as $ingredient) {
                $price = $ingredient->quantity * $ingredient->price;
                $ingredients[] = "+" . $ingredient->dishIngredient->ingredient->name . " (€" . number_format($price, 2) . ")";
            }
        }

        // Join all ingredients with a comma and a space
        return implode(', ', $ingredients);
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
        $dishIds = $user->cart->dishDetails()->pluck('dish_id');
        $getDish = Dish::with('order')->whereIn('id',$dishIds)->get();
        $orderDetailsId = $user->cart->dishDetails()->first()->id;
        $getOrderDetailsData = \App\Models\OrderDishOptionDetails::where('order_detail_id', $orderDetailsId)->pluck('dish_option_id');
        $dishOptionCategoryTotalAmount = getDishOptionCategoryTotalAmount($getOrderDetailsData);
        return (float)($cartTotal + $cartIngredient + $dishOptionCategoryTotalAmount);
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
        $dishIds = $user->cart->dishDetails()->pluck('dish_id');
        $getDish = Dish::with('order')->whereIn('id',$dishIds)->get();
        $orderDetailsId = $user->cart->dishDetails()->first()->id;
        $getOrderDetailsData = \App\Models\OrderDishOptionDetails::where('order_detail_id', $orderDetailsId)->pluck('dish_option_id');
        $dishOptionCategoryTotalAmount = getDishOptionCategoryTotalAmount($getOrderDetailsData);
        $deliveryCharges = 0.00;

        if ($zipcode) {
            $deliveryCharges = getDeliveryCharges($zipcode)->delivery_charge;
        }
//        $couponDiscount = isset($user->cart->coupon) ? ($user->cart->coupon->percentage_off / 100) * $cartTotal : 0;
        $couponDiscount = isset($user->cart->coupon) ? ($user->cart->coupon->percentage_off / 100) * getCartTotalAmount() : 0;
        return number_format((float)(($cartTotal + $serviceCharge + $deliveryCharges + $dishOptionCategoryTotalAmount) - $couponDiscount),2);
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
            if ($order->order_status == OrderStatus::Accepted) {
                $order->order_status = OrderStatus::InKitchen;
            } else if ($order->order_status == OrderStatus::InKitchen) {
                $order->order_status = OrderStatus::OutForDelivery;
            } else {
                $order->order_status = OrderStatus::Delivered;
            }
//  comment on sept cr 16-09-2024
            /*if($order->order_status == OrderStatus::Accepted)
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
            }*/
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


if (!function_exists('uploadImageToLocal')) {
    function uploadImageToLocal($request, $type, $deleteImg = '')
    {
        if (!empty($deleteImg) && Storage::disk('public')->exists($type . '/' . $deleteImg)) {
            Storage::disk('public')->delete($type . '/' . $deleteImg);
            Storage::disk('public')->delete($type . '/thumb/' . $deleteImg);
        }

        $file = $request->file('image');
        $file_name = time() . '_' . $file->getClientOriginalName();
        $extension = $file->getClientOriginalExtension();

        if ($extension == 'jpg' || $extension == 'jpeg' || $extension == 'png') {
            $image = Image::make($file)->resize(300, 300);
            Storage::disk('public')->put('/' . $type . '/thumb/' . $file_name, $image->stream(), 'public');
        }

        $filePath = $type . '/' . $file_name;
        Storage::disk('public')->put($filePath, file_get_contents($file));

        return $file_name;
    }
}

if (!function_exists('getOpenOrders')) {
    function getOpenOrders()
    {
        $openOrders = Order::where('is_cart', '0')->whereNotIn('order_status', [OrderStatus::Delivered, OrderStatus::Cancelled])->get();

        return count($openOrders);
    }
}

if (!function_exists('getUnreadChatCount')) {
    function getUnreadChatCount()
    {
        $getUnreadChatCount = Chat::where('is_read', '0')->where('receiver_id', '1')->get();

        return count($getUnreadChatCount);
    }
}

if (!function_exists('validateAddressByPostCode')) {
    function validateAddressByPostCode ($data) {
//        $getLatLong = getLatLongFromZipcode($data['zipcode']);
        $curl = curl_init();
        $postCodeApiKey = config('params.postCodeApiKey');
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.postcodeapi.nu/v3/lookup/' . $data['zipcode'] . '/'. (int)$data['house_no'],
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                "x-api-key: " . $postCodeApiKey
            ),
        ));

        $response = curl_exec($curl);
//        dd($response);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        if ($httpcode == 400 || $httpcode == 404) {
            return null;
        }
        return $response;
    }
}

if (!function_exists('getDishOptionCategory')) {
    function getDishOptionCategory($dishId)
    {
        $dishOptionCategoryData = [];
        $getDishOptionCategory = DishOption::with('dishCategoryOption')->where('dish_id', $dishId)->get();
        $optionIds = $getDishOptionCategory->pluck('id');
        if (count($getDishOptionCategory) > 0) {
            $catId = $getDishOptionCategory->pluck('dishCategoryOption.cat_id');
            $dishCategoryOptionsId = $getDishOptionCategory->pluck('dish_category_options_id');
            $dishOptionCategoryData = DishOptionCategory::whereIn('id', $catId)
                ->with(['dishCategoryOption' => function ($query) use ($dishCategoryOptionsId) {
                    $query->whereIn('id', $dishCategoryOptionsId);
                }])->get();
        }

        return $dishOptionCategoryData;
    }
}

if (!function_exists('getDishOptionCategoryName')) {
    function getDishOptionCategoryName($optionIds)
    {
        $ingredients = '';
        $optionData = DishCategoryOption::whereIn('id',$optionIds)->get();
        if (count($optionData)>0) {

            foreach ($optionData as $key => $optionCategory) {
                $price = $optionCategory->price;
                $ingredients .= "<li><span class='plus'>+</span>" .$optionCategory->name. "(€" .number_format($price, 2) . ")" . "</li>";
            }
        }
        return trim($ingredients, ', ');
    }
}

if (!function_exists('getDishOptionCategoryName2')) {
    function getDishOptionCategoryName2($optionIds)
    {
        $ingredients = [];
        $optionData = DishCategoryOption::whereIn('id', $optionIds)->get();

        if ($optionData->count() > 0) {
            foreach ($optionData as $optionCategory) {
                $price = $optionCategory->price;
                // Format: +ingredient_name (€price)
                $ingredients[] = "+" . $optionCategory->name . " (€" . number_format($price, 2) . ")";
            }
        }

        // Join all ingredients with a comma and a space
        return implode(', ', $ingredients);
    }
}

if (!function_exists('getDishOptionCategoryTotalAmount')) {
    function getDishOptionCategoryTotalAmount($optionIds)
    {
        $dishOptionTotalAmount = '';
        // Assuming $optionIds is an array of IDs for which you want to sum the prices
        $dishOptionTotalAmount = DishCategoryOption::whereIn('id', $optionIds)->sum('price');
        return $dishOptionTotalAmount ? $dishOptionTotalAmount : 0;
    }
}

if (!function_exists('orderDishOptionDetails')) {
    function orderDishOptionDetails($optionIds)
    {
        $optionName ='';
        $option = DishCategoryOption::whereIn('id',$optionIds)->get();
        if(count($option) > 0) {
            $optionName = $option->pluck('name')->implode(', ');
        }
        return $optionName;
    }
}
// Order Dish Ingredients calculation
if (!function_exists('getOrderDishIngredientsTotal')) {
    function getOrderDishIngredientsTotal($dish)
    {
        $ingredients = '';
        $dishData = Dish::withTrashed()->find($dish->dish_id);
        $ingredientTotalAmount = 0;
        if (count($dish->orderDishPaidIngredients)>0) {
            foreach ($dish->orderDishPaidIngredients as $key => $ingredient) {
                $price = $ingredient->quantity * $ingredient->price;
                $ingredientTotalAmount = $ingredientTotalAmount += $price;
            }
        }
        return $ingredientTotalAmount;
    }
}

if (!function_exists('svg')) {
    function svg($path, $width = null, $height = null) {
        $svgContent = file_get_contents(public_path('images/' . $path));

        // Add dynamic width and height if provided
        if ($width && $height) {
            // Replace or add width and height attributes in the SVG tag
            $svgContent = preg_replace(
                '/<svg /',
                '<svg width="' . $width . '" height="' . $height . '" ',
                $svgContent
            );
        }

        return $svgContent;
    }
}

if (!function_exists('orderStatusBox')) {
    function orderStatusBox($order)
    {
        // Define status-color mappings
        $statusColors = [
            1 => 'outline-danger',        // New Order
            2 => 'outline-warning',       // In Kitchen
            4 => 'outline-success',       // Ready For Pickup
            5 => 'outline-success',       // Out For Delivery
            6 => 'btn-danger-outline',     // Delivered
            7 => 'btn-danger-outline',        // Cancelled
        ];

        // Define status-text mappings
        $orderText = [
            1 => 'New Order',
            2 => 'In Kitchen',
            4 => 'Ready',
            5 => 'Delivery',
            6 => 'Delivered',
            7 => 'Cancelled'
        ];

        // Get the color and text based on the status
        $order_status = $order->order_status;
        $order->color = $statusColors[$order_status] ?? 'outline-secondary'; // Fallback color
        $order->text = $orderText[$order_status] ?? 'Unknown Status';        // Fallback text

        // You could add more custom logic here if needed, based on the order type
        return $order;
    }
}

if (!function_exists('RoundUpEstimatedTime')) {
    function RoundUpEstimatedTime($expectedDeliveryTime, $addMinutes)
    {
        //$expectedDeliveryTime = $expectedDeliveryTime; // Replace this with your actual time value
        $timeParts = explode(':', $expectedDeliveryTime); // Split into hours and minutes
        $hours = $timeParts[0];
        $minutes = $timeParts[1];
        // Round up the minutes to the nearest multiple of 5
        $roundedMinutes = ceil($minutes / 5) * 5;

        // Handle overflow if minutes become 60
        if ($roundedMinutes == 60) {
            $roundedMinutes = '00';
            $hours = str_pad($hours + 1, 2, '0', STR_PAD_LEFT);
        }

        $expectedDeliveryTime = $hours . ':' . str_pad($roundedMinutes, 2, '0', STR_PAD_LEFT);
        $expectedDeliveryTime =  \Carbon\Carbon::parse($expectedDeliveryTime)->addMinutes($addMinutes)->format('H:i:s');
        return $expectedDeliveryTime;


    }
}

//if (!function_exists('getLatLongFromZipcode')) {
//    function getLatLongFromZipcode($zipcode)
//    {
//        $apiKey = config('services.google_place_key'); // Replace with your Google Maps API Key
//        $client = new Client();
//
//        $response = $client->get('https://maps.googleapis.com/maps/api/geocode/json', [
//            'query' => [
//                'address' => $zipcode,
//                'key' => $apiKey,
//            ]
//        ]);
//
//
//        $data = json_decode($response->getBody(), true);
//
//        if ($data['status'] === 'OK') {
//            // Extract latitude and longitude from the response
//            $lat = $data['results'][0]['geometry']['location']['lat'];
//            $lng = $data['results'][0]['geometry']['location']['lng'];
//            return ['lat' => $lat, 'lng' => $lng];
//        }
//
//        return null; // If no result is found
//    }
//}

