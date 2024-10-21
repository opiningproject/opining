<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserType;
use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Category;
use App\Models\DelivererUser;
use App\Models\Dish;
use App\Models\DishIngredient;
use App\Models\DishOptionCategory;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderDishDetail;
use App\Models\OrderDishOptionDetails;
use App\Models\TrackOrder;
use App\Models\User;
use App\Models\Zipcode;
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
use function React\Promise\all;

class ManualOrdersController extends Controller
{
    /**
     * @param Request $request
     * @param null $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function index(Request $request, $id = null)
    {
        $couponCode = '';
        $couponDiscount = 0;
        $couponPercent = 0;
        $categories = Category::orderBy('sort_order', 'asc')->get();
        $users = User::where('user_role', UserType::User)->get();
        $category = '';
        $cart = OrderDetail::select('*')->orderBy('id', 'desc')->where([
            ['user_id', 0],
            ['is_cart', '1']
        ])->get();
        if ($request->cat_id) {
            $dishes = Dish::with('favorite')->where('category_id', $request->cat_id);
            $category = Category::find($request->cat_id);
        } else if(!$request->all) {
            $category = Category::orderBy('sort_order', 'asc')->first();
            if(!empty($category)){
                $dishes = Dish::with('favorite')->where('category_id', $category->id);
            }else{
                $dishes = Dish::with('favorite');
            }

        }else{
            $dishes = Dish::with('favorite');
        }

        if(count($dishes->get()) > 0){
            $dishes = ($request->all) ? $dishes->get() : $dishes->get();
            // $dishes = ($request->all) ? $dishes->get() : $dishes->limit(12)->get();
        }else{
            $dishes = [];

        }
//        if ($cart) {
//            if (isset($user->cart)) {
//                $couponCode = $user->cart->coupon_code;
//                $couponDiscount = $user->cart->coupon_discount;
//                if ($user->cart->coupon)
//                    $couponPercent = $user->cart->coupon->percentage_off/100;
//            }
//        }
        $serviceCharge = getRestaurantDetail()->service_charge;
        $deliveryTime = getRestaurantDetail()->delivery_time;
        $takeAwayTime = getRestaurantDetail()->take_away_time;
        return view('admin.manual-order.index', [
            'categories' => $categories,
            'cart' => $cart,
            'serviceCharge' => $serviceCharge,
            'deliveryTime' => $deliveryTime,
            'takeAwayTime' => $takeAwayTime,
            'couponCode' => $couponCode,
            'couponDiscount' => $couponDiscount,
            'couponDiscountPercent' => $couponPercent,
            'users' => $users,
            'dishes' => $dishes,
            'category' => $category,
            'cat_id' => $request->cat_id ?? '',
        ]);
    }

    /**
     * @param Request $request
     * @param $cat_id
     * @return \Illuminate\Http\JsonResponse
     */
    function getDishes(Request $request, $cat_id)
    {
        if ($cat_id) {
            $category = Category::find($cat_id);
            $dishes = Dish::with(['favorite', 'category'])->where('category_id', $cat_id);
            $dishesHTML = view('admin.manual-order.dish.dish-list', ['dishes' => $dishes->get()])->render();
            return response()->json(['status' => 1, 'data' => $dishesHTML, 'cat_name' => $category->name]);

        }
    }

    /**
     * @param $cart
     * @return string
     */
    public function cartHtml($cart)
    {
        $dish = $cart->dish;
        $dishId = $dish->id;
        $dishPrice = $dish->price;
        $cleanedDishOptionHtmlString= '';
        $optionTitle = "";
        if (request('option')) {
            $htmlStringDishOptionCategory = getDishOptionCategoryName(request('option')) ?? '' ;
            $cleanedDishOptionHtmlString = str_replace(
                '"',
                '',
                $htmlStringDishOptionCategory,
            );

            $optionTitle = "<b><span style='font-size: 14px'> Options </span></b>";

//            $optionName = getDishOptionCategoryName(request('option'));
        }
        $ingredientData = getOrderDishIngredients1($cart);
        $ingredientTotalAmount = getOrderDishIngredientsTotal($cart);
        $optionTotalAmount = 0;
        if (request('option')) {
            $optionTotalAmount = getDishOptionCategoryTotalAmount(request('option'));
            $optionTotalAmount = $optionTotalAmount * $cart->qty;
        }
        $totalDishAmount = $ingredientTotalAmount + $dish->price + $optionTotalAmount;

        // old code comment 12-08-2024
//        $option = $dish->option->where('id',request('option'))->where('dish_id',$dish->id)->first() ?? '';
//        if($option) {
//            $optionName= $option->option_en;
//        }

        $html ="<div class='order-dt-col' id=cart-$cart->id>
                    <div class='order-dt-box'>
                        <div class='order-title'>
                            <h2><a href='#'><b id='quantity-$cart->id' class='item-name pe-2 mb-0 item-order'>$cart->qty</b>
                            <span class='name item-name' onclick='customizeDish($dish->id, $cart->id);'>$dish->name</span>
                            </a>
                            </h2>
                            <h3 class='price cart-item-price' id='cart-item-price$cart->id'>+€$totalDishAmount</h3>
                        </div>
                        $optionTitle
                        <ul class='items-additional mb-2' id='dish-option-$cart->id'>
                        $cleanedDishOptionHtmlString
                        </ul>

                        <div class='order-footer dish-group' data-dish-id='$cart->id'>
                            <label for='dishnameenglish' class='form-label mb-0 dish-notes-label'>Add Notes</label>
                            <input type='text' data-id='$cart->id' maxlength='50' class='form-control dish-notes d-none' value='' placeholder='Type here'>

                            <div class='add-remove-item'>
                                <div class='foodqty'>
                                    <span class='minus' onclick=updateDishQty('-'," . $dish->qty . "," . $cart->id . ")>
                                        <i class='fas fa-minus align-middle'></i>
                                    </span>
                                    <input type='number' readonly class='count cart-amt' id='qty-$cart->id' name='qty-$cart->id' value=" . $cart->qty . " data-ing='$cart->paid_ingredient_total' data-id='$cart->id'>
                                    <input type='hidden' id='dish-price-$cart->id' value='$totalDishAmount'>

                                    <span class='plus' onclick=updateDishQty('+'," . $dish->qty . "," . $cart->id . ")>
                                        <i class='fas fa-plus align-middle'></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>";
        $ingredientTotalAmount = 0;
        return $html;
    }

    /**
     * @param Request $request
     * @param string $id
     * @return mixed
     */
    public function addCustomizedDish(Request $request, string $id)
    {
//        dd($request->all());
        if (!Auth::user()) {
            return response::json(['status' => 401, 'message' => '']);
        }

        try {
            $user = Auth::user();

            $user_id = $user->id;
            if ($user->id == 1) {
                $user_id = 0;
            }
            $order = $user->cart;
//            dump($order);
            $order_type = session('zipcode') == null ?  '2' : '1';
            if (empty($order)) {
                $order = $user->cart()->create([
                    'user_id'=> 0,
                    'is_cart' => 1,
                    'order_type' => $order_type
                ]);
            } else {
                $order->order_type = $order_type;
                $order->save();
            }
            if ($user->id == 1) {
                if ($order) {
                    $order->is_online_order = 0;
                    $order->user_id = 0;
                    $order->save();
                }
            }

//            dd($order);
            $order->fresh();
            $dish = Dish::find($id);

            $sameDish = 0;
            $addedDishId = 0;
            $paidIngAmt = 0.00;
            $IngListData = '';
            $selectedFreeIng = $request->freeIng ?? [];
            $selectedPaidIng = $request->paidIng ?? [];
            ksort($selectedPaidIng);
            sort($selectedFreeIng);

            if($request->doesExist == 0){
//                dump('in');
//                old option id code comment on 12-08-2024
//                $dishExist = $order->dishDetails()->with('orderDishIngredients')->whereDishId($id)->whereDishOptionId($request->option)->get();

                if ($request->option) {
                    $requestOptions = $request->option; // This is the array of option IDs
                    $dishExist = $order->dishDetails()->with('orderDishIngredients')->whereDishId($id)
                        ->whereDoesntHave('orderDishOptionDetails', function ($query) use ($requestOptions) {
                            $query->whereNotIn('dish_option_id', $requestOptions);
                        })->get();
                } else {
                    $dishExist = $order->dishDetails()->with('orderDishIngredients')->whereDishId($id)->get();
                }

                if ($dishExist) {

                    foreach ($dishExist as $item) {

                        $freeIngredientsExist = $item->orderDishFreeIngredients->pluck('dish_ingredient_id')->all();
                        $paidIngredientsExist = $item->orderDishPaidIngredients->pluck('quantity', 'dish_ingredient_id')->all();
                        ksort($paidIngredientsExist);
                        sort($freeIngredientsExist);
                        if ($selectedFreeIng == $freeIngredientsExist) {
                            if (count($paidIngredientsExist) == count($selectedPaidIng)) {
                                if (count(array_diff_assoc($paidIngredientsExist, $selectedPaidIng)) == 0) {
                                    $sameDish = $item->id;
                                    $item->qty += $request->dishQty;
                                    $item->total_price = $item->qty * $dish->price;
                                    $item->price = $dish->price;
                                    $item->save();
                                    break;
                                }
                            }
                        }
                    }
                }
                if ($sameDish == 0) {

                    $cartArr = [
                        "user_id" => $user_id,
                        "dish_id" => $id,
                        "price" => $dish->price,
                        "qty" => $request->dishQty,
//                        "dish_option_id" => $request->option ?? null, // old code comment on 13-08-2024
                        "total_price" => $dish->price * $request->dishQty,
                        "notes" => '',
                    ];

                    $orderDetails = $order->dishDetails()->create(
                        $cartArr
                    );

                    if ($request->option && count($request->option) > 0 ) {
                        foreach ($request->option as $optionKey => $optionValue) {
                            $addDishOption = OrderDishOptionDetails::create([
                                "order_detail_id"=>$orderDetails->id,
                                "dish_option_id"=>$optionValue
                            ]);
                        }
                    }
                    $orderDetails->fresh();

                    if (isset($request->freeIng)) {
                        foreach ($request->freeIng as $freeIng) {
                            $orderDetails->orderDishDetails()->create([
                                'dish_id' => $id,
                                'dish_ingredient_id' => $freeIng
                            ]);
                        }
                    }

                    if (isset($request->paidIng)) {
                        foreach ($request->paidIng as $key => $paidIng) {

                            $ing = DishIngredient::find($key);
                            $paidIngAmt += ((int)$paidIng * $ing->price);
                            $orderDetails->orderDishDetails()->create([
                                'dish_id' => $id,
                                'dish_ingredient_id' => $key,
                                'is_free' => '0',
                                'quantity' => $paidIng,
                                'price' => $ing->price
                            ]);
                        }
                    }

                    $response['cartHtml'] = $this->cartHtml($orderDetails);
                }
            } else {
                if($dish->option &&  $request->option) {
                    $optionName = $dish->option->where('id', $request->option)->where('dish_id',$dish->id)->first() ?? '';
                }
                $sameDish = $request->doesExist;
//                old code
                $orderDetails = OrderDetail::find($request->doesExist);
                $orderDetails->qty = $request->dishQty;
                $orderDetails->price = $dish->price;
                $orderDetails->total_price = $orderDetails->qty * $dish->price;

                // update dish option, if it comes in request ( CR: July )
                // old code comment on 13-08-2024
//                    $orderDetails->dish_option_id =  $request->option ?? null;
                $orderDetails->save();
                if ($request->option && count($request->option) > 0 ) {
                    OrderDishOptionDetails::where("order_detail_id",$orderDetails->id)->delete();
                    foreach ($request->option as $optionKey => $optionValue){
                        $addDishOption = OrderDishOptionDetails::create([
                            "order_detail_id"=>$orderDetails->id,
                            "dish_option_id"=>$optionValue
                        ]);
                    }
                }
//                ]);
                $orderDetails->orderDishDetails()->forceDelete();
                if (isset($request->freeIng)) {
                    foreach ($request->freeIng as $freeIng) {
                        $orderDetails->orderDishDetails()->create([
                            'dish_id' => $id,
                            'dish_ingredient_id' => $freeIng
                        ]);
                    }
                }

                if (isset($request->paidIng)) {
                    foreach ($request->paidIng as $key => $paidIng) {

                        $ing = DishIngredient::find($key);
                        $paidIngAmt += ($paidIng * $ing->price);
                        $orderDetails->orderDishDetails()->create([
                            'dish_id' => $id,
                            'dish_ingredient_id' => $key,
                            'is_free' => '0',
                            'quantity' => $paidIng,
                            'price' => $ing->price
                        ]);
                    }
                }
                $IngListData = getOrderDishIngredients1($orderDetails);
                // $IngListData = getOrderDishIngredients($orderDetails);
//                $paidIngAmt *= $request->dishQty;

            }
            if (request('option')) {
                $optionName = getDishOptionCategoryName(request('option'));
                $optionTotalAmount = getDishOptionCategoryTotalAmount(request('option'));
            }
            $response['msg'] = '';
            $response['paidIngAmt'] = $paidIngAmt;
            $response['ingListData'] = $IngListData;
            $response['addedDishId'] = $sameDish;
            $response['dishOption'] = $optionName ?? '';
            $response['optionTotalAmount'] = $optionTotalAmount ?? 0;
//            $response['totalAmount'] = $orderDetails->total_price ?? '';  // old code comment aug cr.
            $response['totalAmount'] = $dish->price ?? '';
            return response::json(['status' => 200, 'message' => $response]);


        } catch (Exception $e) {
            return response::json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }

    public function updateDishQty(Request $request)
    {
        try {
            $coupon = false;
            $user = Auth::user();
            if ($request->current_qty >= 1) {

                $user->cart->dishDetails()->find($request->dish_id)->update([
                        'qty' => DB::raw('qty ' . $request->operator . '1'),
                        'total_price' => DB::raw('qty * price'),
                    ]
                );
            } else {

                $dish = OrderDetail::find($request->dish_id);

                if($dish){
                    OrderDishDetail::whereOrderDetailId($request->dish_id)->forceDelete();
                    $user->cart->dishDetails()->find($request->dish_id)->forceDelete();
                }
            }

            if (count($user->cart->dishDetails) == 0) {
                $coupon = true;
                $user->cart()->update([
                    'coupon_id' => null,
                    'coupon_code' => null,
                    'coupon_discount' => 0.00
                ]);

            }

            return response::json(['status' => 1, 'message' => $coupon]);

        } catch (Exception $e) {
            return response::json(['status' => 0, 'message' => $e->getMessage()]);
        }
    }


    public function createCustomer(Request $request) {
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'user_role' => UserType::User,
            'status' => '1',
            'email_verified_at' => date('Y-m-d H:i:s'),
        ]);
        if ($user) {
            $addUserAddress = Address::create([
                'user_id' => $user->id,
                'house_no' => $request->house_number,
                'street_name' => $request->street,
                'city' => $request->city,
                'zipcode' => $request->postal_code,
                'latitude' => "51.9367749",
                'longitude' => "4.4855718",
            ]);
        }
        return response::json(['status' => 200, 'message' => "Customer Created Success"]);
    }
}
