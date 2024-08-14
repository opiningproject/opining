<?php

namespace App\Http\Controllers\User;

use App\Enums\OrderType;
use App\Http\Controllers\Controller;
use App\Models\DishCategoryOption;
use App\Models\DishIngredient;
use App\Models\DishOption;
use App\Models\DishOptionCategory;
use App\Models\OrderDishOptionDetails;
use App\Models\RestaurantDetail;
use App\Models\Zipcode;
use Exception;
use Illuminate\Http\Request;
use App\Models\DishFavorites;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Dish;
use App\Models\OrderDishDetail;
use Validator, Redirect, Response;
use DB;
use function Symfony\Component\String\s;

class CartController extends Controller
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
        //return view('user.home');
    }

    public function addToCart(Request $request)
    {
        if (!Auth::user()) {
            return response::json(['status' => 2, 'message' => '']);
        }

        try {
            $user_id = Auth::user()->id;
            $order = Order::where('user_id', $user_id)->where('is_cart', '1')->first();

            if (empty($order)) {
                $order = new Order();
                $order->user_id = $user_id;
                $order->order_type = session('zipcode') ? '1' : '2';
            }

            $order->is_cart = '1';
            $order->order_status = '1';

            if ($order->save()) {
                $dish = Dish::find($request->id);

                $cartArr = [
                    "user_id" => $user_id,
                    "order_id" => $order->id,
                    "dish_id" => $request->id,
                    "price" => $dish->price,
                    "qty" => 1,
                    "total_price" => $dish->price,
                    "notes" => '',
                ];

                $cartDetail = OrderDetail::create(
                    $cartArr
                );

                if (count($dish->freeWithoutTrashIngredients) > 0) {
                    foreach ($dish->freeWithoutTrashIngredients as $ingredient) {
                        $cartDetail->orderDishDetails()->create([
                            'dish_id' => $dish->id,
                            'dish_ingredient_id' => $ingredient->id
                        ]);
                    }
                }

                echo $this->cartHtml($cartDetail);
                exit;
            }

        } catch (Exception $e) {
            return response::json(['status' => 0, 'message' => trans('user.message.went_wrong')]);
        }
    }

    public function cartHtml($cart)
    {
        $dish = $cart->dish;
        $dishId = $dish->id;
        $dishPrice = $dish->price;
        $optionName= '';

        if (request('option')) {
            $optionName = getDishOptionCategoryName(request('option'));
        }
        $ingredientData = getOrderDishIngredients1($cart);
        // old code comment 12-08-2024
//        $option = $dish->option->where('id',request('option'))->where('dish_id',$dish->id)->first() ?? '';
//        if($option) {
//            $optionName= $option->option_en;
//        }

        $html = "<div class='row stock-card mb-0' id=cart-$cart->id>
    <div class='col-12 text-end d-flex align-items-center gap-2 mb-3 justify-content-end outof-stock-text d-none'>
        <strong>Out of stock</strong>
        <a class='remove-cart-dish' data-id='$cart->id' data-dish-id='$dish->id' href='javascript:void(0)'>
            <svg xmlns='http://www.w3.org/2000/svg' fill='#ff0000' viewBox='0 0 24 24' width='20px' height='20px'>
                <path d='M 10 2 L 9 3 L 4 3 L 4 5 L 5 5 L 5 20 C 5 20.522222 5.1913289 21.05461 5.5683594 21.431641 C 5.9453899 21.808671 6.4777778 22 7 22 L 17 22 C 17.522222 22 18.05461 21.808671 18.431641 21.431641 C 18.808671 21.05461 19 20.522222 19 20 L 19 5 L 20 5 L 20 3 L 15 3 L 14 2 L 10 2 z M 7 5 L 17 5 L 17 20 L 7 20 L 7 5 z M 9 7 L 9 18 L 11 18 L 11 7 L 9 7 z M 13 7 L 13 18 L 15 18 L 15 7 L 13 7 z'></path>
            </svg>
        </a>
    </div>
    <div class='col-12'>
        <div class='d-flex cart-item-row'>
            <div class='cart-custom-w-col-img cart-name-price'>
                <div class='d-flex align-items-start'>
                    <p id='quantity-$cart->id' class='item-name pe-2 mb-0'>$cart->qty</p>
                    <p class='d-inline-block item-name mb-0 text-decoration-underline' onclick='customizeDish($dish->id, $cart->id);'>
                        $dish->name
                    </p>
                    <span class='cart-item-price ms-auto' id='cart-item-price$cart->id'>+€$dish->price</span>
                </div>
            </div>";
            $html .=  "<ul class='items-additional mb-2' id='item-ing-desc$cart->id'>";
            $html .= $ingredientData;
            $html .= "</ul>";
            $html .= "<div class='cart-custom-w-col-img d-none'>
                <img src='https://gomeal.s3.eu-central-1.amazonaws.com/dish/thumb/1715626618_Middel%204%403x.png' alt='pepperoni' class='img-fluid' width='86' height='74px'>
            </div>
            <div class='cart-custom-w-col-detail'>
                <div class='cart-item-detail'>
                    <div class='d-flex align-items-center'>
                        <p class='mb-0 item-options mb-0' id='dish-option-$cart->id' data-dish-option='$optionName'>
                        $optionName
                        </p>
                    </div>
                    <div class='d-flex cart-item-bt'>
                        <div class='from-group addnote-from-group mb-0'>
                            <div class='form-group mb-0 dish-group' data-dish-id='$dish->id'>
                                <label for='dishnameenglish' class='form-label mb-0'>Add Notes</label>
                                <input type='text' data-id='$cart->id' maxlength='50' class='form-control dish-notes d-none' value='' placeholder='Type here'>
                            </div>
                        </div>
                        <div class='foodqty mt-0'>
                            <span class='minus' onclick=updateDishQty('-'," . $dish->qty . "," . $cart->id . ")>
                             <i class='fas fa-minus align-middle'></i>
                            </span>
                            <input type='number' readonly class='count cart-amt' id='qty-$cart->id' name='qty-$cart->id' value=" . $cart->qty . " data-ing='$cart->paid_ingredient_total' data-id='$cart->id'>
                            <input type='hidden' id='dish-price-$cart->id' value='$dishPrice'>
                            <span class='plus' onclick=updateDishQty('+'," . $dish->qty . "," . $cart->id . ")>
                           <i class='fas fa-plus align-middle'></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>";
        // $html = "<div class='row stock-card mb-0' id=cart-$cart->id>
        //             <div class='col-12'>
        //                 <div class='d-flex cart-item-row'>
        //                     <div class='cart-custom-w-col-img'>

        //             <img src=" . $dish->image . " alt='$dish->name' class='img-fluid' width='86' height='74px' />
        //             <div class='foodqty'>
        //               <span class='minus'>
        //                 <i class='fas fa-minus align-middle' onclick=updateDishQty('-'," . $dish->qty . "," . $cart->id . ")></i>
        //               </span>
        //               <input type='number' readonly class='count cart-amt' id='qty-$cart->id' name='qty-$cart->id' value=" . $cart->qty . " data-ing='$cart->paid_ingredient_total' data-id='$cart->id'>
        //               <input type='hidden' id='dish-price-$cart->id' value='$dishPrice'/>
        //               <span class='plus'>
        //                 <i class='fas fa-plus align-middle' onclick=updateDishQty('+'," . $dish->qty . "," . $cart->id . ")></i>
        //               </span>
        //             </div>
        //           </div>
        //           <div class='cart-custom-w-col-detail'>
        //             <div class='cart-item-detail'>
        //               <div class='d-flex align-items-center justify-content-between'>
        //                 <p class='d-inline-block item-name mb-0'> $dish->name </p>
        //                 <span class='cart-item-price' id='cart-item-price$cart->id'>+€$dish->price</span>
        //               </div>
        //               <div class='d-flex align-items-center'>
        //                 <p class='mb-0 item-options mb-0'> $optionName </p>
        //                 <span class='item-desc' id='item-ing-desc$cart->id'>$ingredientData</span>
        //                 <p class='item-customize mb-0 ms-auto justify-content-end'>
        //                     <a href='javascript:void(0);'
        //                        onclick='customizeDish($dish->id,$cart->id);'>
        //                         <img src='".asset('images/custom-dish.svg')."' alt='' class='svg edit-icon' height='13' width='14'/>
        //                     </a>
        //                     Edit
        //                 </p>";
        //                 if ($cart->qty * $cart->paid_ingredient_total > 0) {
        //                     $html .= "<p class='price-opt mb-0 text-nowrap' id='paid-ing-price$cart->id'>+€" . number_format((float)($cart->qty * $cart->paid_ingredient_total), 2) . " </p>";
        //                 }
        //              $html .= "</div> </div>
        //               <div class='from-group addnote-from-group mb-0'>
        //                 <div class='form-group'>
        //                   <label for='dishnameenglish' class='form-label'>".trans('user.cart.add_notes')."</label>
        //                   <input type='text' class='form-control dish-notes' data-id='$cart->id' maxlength='50' placeholder='".trans('user.cart.type_here')."'/>
        //                 </div>
        //               </div>
        //             </div>
        //           </div>
        //         </div>
        //         </div></div>";

        return $html;
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

    public function addCustomizedDish(Request $request, string $id)
    {
        if (!Auth::user()) {
            return response::json(['status' => 401, 'message' => '']);
        }

        try {
            $user = Auth::user();

            $user_id = $user->id;
            $order = $user->cart;

            if (empty($order)) {
                $order = $user->cart()->create([
                    'is_cart' => 1,
                    'order_type' => session('zipcode') ? '1' : '2'
                ]);
            }
//            dd($request->all());
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
                    /*$orderDetails = OrderDetail::find($request->doesExist);

                    $orderDetails->orderDishDetails()->delete();

                    $cartArr = [
                        "price" => $dish->price,
                        "qty" => $request->dishQty,
                        "dish_option_id" => $request->option ?? null,
                        "total_price" => $dish->price * $request->dishQty,
                    ];

                    $orderDetails->update(
                        $cartArr
                    );*/

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
            }else{

                if($dish->option &&  $request->option) {
                    $optionName = $dish->option->where('id', $request->option)->where('dish_id',$dish->id)->first() ?? '';
                }
                $sameDish = $request->doesExist;
                $orderDetails = $order->dishDetails()->find($request->doesExist);
//                ->update([
                    $orderDetails->qty = $request->dishQty;
                    $orderDetails->price = $dish->price;
                    $orderDetails->total_price = $orderDetails->qty * $dish->price;

                    // update dish option, if it comes in request ( CR: July )
                    // old code comment on 13-08-2024
//                    $orderDetails->dish_option_id =  $request->option ?? null;
                    $orderDetails->save();
                if (count($request->option) > 0 ) {
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

            /*if (isset($request->freeIng)) {
                foreach ($request->freeIng as $freeIng) {
                    $orderDetails->orderDishDetails()->create([
                        'dish_id' => $id,
                        'dish_ingredient_id' => $freeIng
                    ]);
                }
            }
            $paidIngAmt = 0.00;
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
            if ($cartData) {
                $response['cartHtml'] = $this->cartHtml($orderDetails);
            }*/
            if (request('option')) {
                $optionName = getDishOptionCategoryName(request('option'));
            }
//            dd($orderDetails->total_price);
            $response['msg'] = '';
            $response['paidIngAmt'] = $paidIngAmt;
            $response['ingListData'] = $IngListData;
            $response['addedDishId'] = $sameDish;
            $response['dishOption'] = $optionName ?? '';
            $response['totalAmount'] = $orderDetails->total_price ?? '';
            return response::json(['status' => 200, 'message' => $response]);


        } catch (Exception $e) {
            return response::json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }

    public function updateDeliveryType(Request $request)
    {
        try {

            // Commented as on july CR points
            // if ($request->type == OrderType::Delivery) {
            //     session()->forget('address');
            //     session()->forget('zipcode');
            //     session()->forget('house_no');
            //     // session(['zipcode' => $request->zipcode]);
            //     // session(['house_no' => $request->houseNo]);
            //     session()->forget('street_name');
            //     session()->forget('delivery_charge');

            // } else {
            //     session()->forget(['house_no', 'zipcode', 'address']);
            // }

            if (!Auth::user()) {
                return response::json(['status' => 401, 'message' => '']);
            }

            $user = Auth::user();

            if ($user->cart) {
                $user->cart->update([
                    'order_type' => $request->type
                ]);

            }

            return response::json(['status' => 200, 'message' => '']);

        } catch (Exception $e) {
            return response::json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }

    public function validateCart(Request $request)
    {
        try {
            $user = Auth::user();
            $restaurantHours = getRestaurantOpenTime();
            $restaurantDeliveringOption = restaurantDeliveringOption();
            $now = date('H:i');
            $outOfStock = false;

            if($restaurantDeliveringOption == '1'){
                if ($user->cart->coupon) {
                    if ( strtotime($user->cart->coupon->start_expiry_date . ' 00:00:00') > strtotime(now())) {
                        return response::json(['status' => 406, 'message' => trans('user.message.coupon_expired')]);
                    }else if(strtotime($user->cart->coupon->end_expiry_date . ' 23:59:59') < strtotime(now())){
                        return response::json(['status' => 406, 'message' => trans('user.message.not_applicable')]);
                    }
                }

                /*$outOfStockDishes = OrderDetail::with('dish')->where([
                    ['order_id', $user->cart->id],
                    ['is_cart', '1']
                ])->groupBy('dish_id')->get();

                 dd($user->cart->dishDetails()->with('dish')->whereHas('dish', function ($query) {
                    $query->where('qty', 0)->orWhere('out_of_stock', '1');
                })->groupBy('dish_id')->select('*', DB::raw('sum(qty) as total'))->get()->toArray());

    //            dd($outOfStockDishes->toArray());*/
//            dd($user->cart->dishDetails()->with('dish')->groupBy('dish_id')->select('*', DB::raw('sum(qty) as total'))->get()->toArray());

                $cartDishes = $user->cart->dishDetails()->with('dish')->groupBy('dish_id')->select('*', DB::raw('sum(qty) as total'))->get();

                foreach ($cartDishes as $outOfStockDish) {
                    if($outOfStockDish->dish->qty == 0 || $outOfStockDish->dish->out_of_stock == '1' || $outOfStockDish->dish->qty < $outOfStockDish->total){
                        $outOfStock = true;
                        break;
                    }
                }

                if ($outOfStock) {
                    return response::json(['status' => 412, 'message' => trans('user.message.cart_item_out_of_stock')]);
                }

                if ($now < $restaurantHours->start_time && $now > $restaurantHours->end_time) {
                    return response::json(['status' => 412, 'message' => trans('user.message.restaurant_closed')]);
                }

                if ($user->cart->order_type == OrderType::Delivery) {
                    if (session('zipcode')) {

                        $zip = substr(session('zipcode'), 0, 4);
                        $zipcode = Zipcode::whereRaw("LEFT(zipcode,4) = '$zip'")->where('status', '1')->first();

                        if ($zipcode) {

                            $deliveryCharges = getDeliveryCharges(session('zipcode'));
                            if ($deliveryCharges) {
                                if ($request->totalAmt >= $deliveryCharges->min_order_price) {
                                    return response::json(['status' => 200, 'message' => '']);
                                } else {
                                    return response::json(['status' => 412, 'message' => trans('user.message.min_order_price',['min_order_price' => number_format($deliveryCharges->min_order_price, 2)])]);
                                }
                            }
                        } else {
                            return response::json(['status' => 406, 'message' => trans('user.message.invalid_zipcode')]);
                        }
                    } else {
                        return response::json(['status' => 412, 'message' => trans('user.message.valid_address')]);
                    }
                } else {
                    return response::json(['status' => 200, 'message' => '']);
                }
            }else{
                return response::json(['status' => 412, 'message' => trans('user.message.restaurant_closed')]);
            }

        } catch (Exception $e) {
            return response::json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }

    public function removeCartDish(string $id)
    {
        try {
            $orderDish = OrderDetail::find($id);
            $orderDish->orderDishDetails()->forceDelete();
            $orderDish->forceDelete();
            return response::json(['status' => 200, 'message' => '']);
        } catch (Exception $e) {
            return response::json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }

    public function updateDishNotes(Request $request, string $id)
    {
        try {

            $orderDish = OrderDetail::find($id);
            $orderDish->notes = $request->notes;

            if ($orderDish->save()) {
                return response::json(['status' => 200, 'message' => '']);
            } else {
                return response::json(['status' => 500, 'message' => trans('user.message.went_wrong')]);
            }
        } catch (Exception $e) {
            return response::json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }

    public function updateDeliveryNotes(Request $request)
    {
        try {

            $order = Auth::user()->cart;
            $order->delivery_note = $request->delivery_notes;

            if ($order->save()) {
                return response::json(['status' => 200, 'message' => '']);
            } else {
                return response::json(['status' => 500, 'message' => trans('user.message.went_wrong')]);
            }
        } catch (Exception $e) {
            return response::json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }
}
