<?php

namespace App\Http\Controllers\User;

use App\Enums\OrderType;
use App\Http\Controllers\Controller;
use App\Models\DishIngredient;
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

                if (count($dish->freeIngredients) > 0) {
                    foreach ($dish->freeIngredients as $ingredient) {
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
            return response::json(['status' => 0, 'message' => 'Something went wrong.']);
        }
    }

    public function cartHtml($cart)
    {
        $dish = $cart->dish;
        $dishId = $dish->id;
        $dishPrice = $dish->price;
        $optionName = $dish->dishOption->name ?? '';
        $ingredientData = getOrderDishIngredients($cart);

        $html = "<div class='row stock-card mb-0' id=cart-$cart->id>
 <div class='col-12'>
                                                                            <div class='d-flex cart-item-row'>
                                                                                <div class='cart-custom-w-col-img'>

                    <img src=" . $dish->image . " alt='$dish->name' class='img-fluid' width='86' height='74px' />
                    <div class='foodqty'>
                      <span class='minus'>
                        <i class='fas fa-minus align-middle' onclick=updateDishQty('-'," . $dish->qty . "," . $cart->id . ")></i>
                      </span>
                      <input type='number' readonly class='count cart-amt' id='qty-$cart->id' name='qty-$cart->id' value=" . $cart->qty . " data-ing='$cart->paid_ingredient_total' data-id='$cart->id'>
                      <input type='hidden' id='dish-price-$cart->id' value='$dishPrice'/>
                      <span class='plus'>
                        <i class='fas fa-plus align-middle' onclick=updateDishQty('+'," . $dish->qty . "," . $cart->id . ")></i>
                      </span>
                    </div>
                  </div>
                  <div class='cart-custom-w-col-detail'>
                    <div class='cart-item-detail'>
                      <div class='d-flex align-items-center justify-content-between'>
                        <p class='d-inline-block item-name mb-0'> $dish->name </p>
                        <span class='cart-item-price' id='cart-item-price$cart->id'>+€$dish->price</span>
                      </div>
                      <div class='d-flex align-items-center'>
                        <p class='mb-0 item-options mb-0'> $optionName </p>
                        <span class='item-desc'>+$ingredientData</span>



                        <p class='price-opt mb-0 text-nowrap' id='paid-ing-price$cart->id'>+€" . number_format((float)($cart->qty * $cart->paid_ingredient_total),2) . " </p>
                      </div>
                      <div class='from-group addnote-from-group mb-0'>
                        <div class='form-group'>
                          <label for='dishnameenglish' class='form-label'>Add notes</label>
                          <input type='text' class='form-control dish-notes' maxlength='50' placeholder='Type here...'/>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                </div></div>";

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
                OrderDishDetail::whereOrderDetailId($request->dish_id)->forceDelete();
                $user->cart->dishDetails()->find($request->dish_id)->forceDelete();
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
            $selectedFreeIng = $request->freeIng ?? [];
            $selectedPaidIng = $request->paidIng ?? [];
            ksort($selectedPaidIng);
            sort($selectedFreeIng);

            if($request->doesExist == 0){

                $dishExist = $order->dishDetails()->with('orderDishIngredients')->whereDishId($id)->whereDishOptionId($request->option)->get();

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
                        "dish_option_id" => $request->option ?? null,
                        "total_price" => $dish->price * $request->dishQty,
                        "notes" => '',
                    ];

                    $orderDetails = $order->dishDetails()->create(
                        $cartArr
                    );
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
                    $response['cartHtml'] = $this->cartHtml($orderDetails);
                }
            }else{
                $sameDish = $request->doesExist;
                $orderDetails = $order->dishDetails()->find($request->doesExist);
//                ->update([
                    $orderDetails->qty = $request->dishQty;
                    $orderDetails->price = $dish->price;
                    $orderDetails->total_price = $orderDetails->qty * $dish->price;
                    $orderDetails->save();
//                ]);
                $orderDetails->orderDishDetails()->delete();
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
                $paidIngAmt *= $request->dishQty;

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
            $response['msg'] = 'Cart Added Successfully';
            $response['paidIngAmt'] = $paidIngAmt;
            $response['addedDishId'] = $sameDish;
            return response::json(['status' => 200, 'message' => $response]);


        } catch (Exception $e) {
            return response::json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }

    public function updateDeliveryType(Request $request)
    {
        try {
            if ($request->type == OrderType::Delivery) {
                session()->forget('address');
                session(['zipcode' => $request->zipcode]);
                session(['house_no' => $request->houseNo]);

            } else {
                session()->forget(['house_no', 'zipcode', 'address']);
            }

            if (!Auth::user()) {
                return response::json(['status' => 401, 'message' => 'Unauthorized']);
            }

            $user = Auth::user();

            if ($user->cart) {
                $user->cart->update([
                    'order_type' => $request->type
                ]);

            }

            return response::json(['status' => 200, 'message' => 'Delivery type updated successfully']);

        } catch (Exception $e) {
            return response::json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }

    public function validateCart(Request $request)
    {
        try {
            $user = Auth::user();
            $restaurantHours = getRestaurantOpenTime();
            $now = date('H:i');
            $outOfStock = false;

            if ($user->cart->coupon) {
                if (strtotime($user->cart->coupon->expiry_date . ' 23:59:59') < strtotime(now())) {
                    return response::json(['status' => 406, 'message' => "Coupon is expired."]);
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
                return response::json(['status' => 412, 'message' => "Few items are out of stock. Please remove them to continue."]);
            }

            if ($now < $restaurantHours->start_time || $now > $restaurantHours->end_time) {
                return response::json(['status' => 412, 'message' => "The restaurant doesn't deliver at this time. Please try again after sometime."]);
            }

            if ($user->cart->order_type == OrderType::Delivery) {
                if (session('zipcode')) {

                    $zip = substr(session('zipcode'), 0, 4);
                    $zipcode = Zipcode::whereRaw("LEFT(zipcode,4) = $zip")->where('status', '1')->first();


                    if ($zipcode) {

                        $deliveryCharges = getDeliveryCharges(session('zipcode'));
                        if ($deliveryCharges) {
                            if ($request->totalAmt >= $deliveryCharges->min_order_price) {
                                return response::json(['status' => 200, 'message' => 'Delivery']);
                            } else {
                                return response::json(['status' => 412, 'message' => "The minimum order should be $deliveryCharges->min_order_price"]);
                            }
                        }
                    } else {
                        return response::json(['status' => 406, 'message' => 'Currently, we are not delivering food to this location.']);
                    }
                } else {
                    return response::json(['status' => 200, 'message' => 'Takeaway']);
                }
            } else {
                return response::json(['status' => 200, 'message' => 'Takeaway']);
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
            return response::json(['status' => 200, 'message' => 'Dish Deleted']);
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
                return response::json(['status' => 200, 'message' => 'Notes Added']);
            } else {
                return response::json(['status' => 500, 'message' => 'There was some error while updating. Please try again!']);
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
                return response::json(['status' => 200, 'message' => 'Notes Added']);
            } else {
                return response::json(['status' => 500, 'message' => 'There was some error while updating. Please try again!']);
            }
        } catch (Exception $e) {
            return response::json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }
}
