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

        $html = "<div class='row' id=cart-$dishId>
                <div class='col-xx-3 col-xl-3 col-lg-3 col-md-4 col-sm-4 col-4 cart-custom-w-col-img'>
                    <img src=" . $dish->image . " alt='burger image' class='img-fluid' width='86' height='74px' />
                    <div class='foodqty'>
                      <span class='minus'>
                        <i class='fas fa-minus align-middle' onclick=updateDishQty('-'," . $dish->qty . "," . $dishId . ")></i>
                      </span>
                      <input type='number' readonly class='count cart-amt' id='qty-$dishId' name='qty-$dishId' value=" . $cart->qty . "  data-id='$dishId'>
                      <input type='hidden' id='dish-price-$dishId' value='$dishPrice'/>
                      <span class='plus'>
                        <i class='fas fa-plus align-middle' onclick=updateDishQty('+'," . $dish->qty . "," . $dishId . ")></i>
                      </span>
                    </div>
                  </div>
                  <div class='col-xx-9 col-xl-9 col-lg-9 col-md-8 col-sm-12 col-8 cart-custom-w-col-detail'>
                    <div class='cart-item-detail'>
                      <div class='d-flex align-items-center justify-content-between'>
                        <p class='d-inline-block item-name mb-0'> $dish->name </p>
                        <span class='cart-item-price'>+€$dish->price</span>
                      </div>
                      <div class='d-flex'>
                        <p class='mb-0 item-options mb-0'> grilled, </p>
                        <span class='item-desc'>-$dish->description</span>
                        <p class='item-customize mb-0'> customize
                          <a href='javascript:void(0);' data-bs-toggle='modal' data-bs-target='#customisableModal'>
                            <svg xmlns='http://www.w3.org/2000/svg' width='14' height='13' viewBox='0 0 14 13' fill='none'>
                              <path d='M13.1001 3.52033L13.0949 3.53595C13.0859 3.5631 13.0792 3.58773 13.0718 3.61482C13.0667 3.63337 13.0614 3.65307 13.0547 3.67552L13.1001 3.52033ZM13.1001 3.52033L13.1 3.50387M13.1001 3.52033L13.1 3.50387M13.1 3.50387L13.0976 3.13698L13.0976 3.12826L13.096 3.11968C13.0163 2.68245 12.7333 2.38042 12.4418 2.11018C12.273 1.95355 12.1112 1.79323 11.9479 1.63143C11.8512 1.53562 11.754 1.43929 11.6544 1.34289C11.3536 1.04992 10.9956 0.899416 10.633 0.900002C10.2703 0.900587 9.91242 1.05226 9.61165 1.34627L9.61163 1.3463L8.21902 2.7087M13.1 3.50387L8.21902 2.7087M1.54192 9.49893C1.56189 9.39894 1.63588 9.29781 1.71193 9.22196L1.54192 9.49893ZM1.54192 9.49893C1.36537 10.389 1.19914 11.281 1.0329 12.1731L1.01987 12.243C0.968197 12.5283 1.00754 12.6056 1.25477 12.7493H1.46588L1.54192 9.49893ZM8.21902 2.7087C6.02469 4.85398 3.83231 7.00128 1.64189 9.15058L1.64131 9.15116C1.56032 9.23194 1.46962 9.35035 1.44386 9.47934L1.44383 9.47947C1.26717 10.3701 1.10085 11.2626 0.934644 12.1545L0.921564 12.2247L0.921474 12.2252C0.895629 12.3679 0.885663 12.4874 0.934728 12.5918C0.983606 12.6958 1.08157 12.7643 1.20453 12.8357L1.22782 12.8493H1.25477H1.46588H1.48903L1.50983 12.8391C1.52312 12.8326 1.53695 12.8271 1.55118 12.8229C1.79784 12.7779 2.04464 12.7331 2.29149 12.6884C2.96624 12.5661 3.64137 12.4437 4.31525 12.316L4.31525 12.316L4.31697 12.3156C4.44072 12.2899 4.55483 12.2306 4.64611 12.1441L4.64612 12.1441L4.64716 12.1431C7.32462 9.53059 9.99797 6.91428 12.6672 4.29415L12.6674 4.29393C12.791 4.17188 12.8817 4.01739 12.9626 3.87953C12.9719 3.86379 12.981 3.84826 12.99 3.83303L8.21902 2.7087ZM11.716 4.12079C11.755 4.08158 11.7938 4.04245 11.8325 4.0034C11.9193 3.91599 12.0056 3.82899 12.0924 3.7424L12.0203 2.95526C12.1437 3.07758 12.1962 3.2003 12.1962 3.31381C12.1963 3.42737 12.144 3.54981 12.0218 3.67157L12.0218 3.67158C11.9348 3.75837 11.8481 3.8457 11.7613 3.93322C11.7459 3.94876 11.7305 3.96431 11.715 3.97987M11.716 4.12079L11.786 4.04934L11.715 3.97987M11.716 4.12079L11.6451 4.05028C11.6684 4.02681 11.6917 4.00333 11.715 3.97987M11.716 4.12079L11.715 3.97987M11.715 3.97987L9.97698 2.27809C10.002 2.25142 10.0266 2.22484 10.0511 2.19844C10.1511 2.0904 10.2483 1.98545 10.3585 1.88975C10.5116 1.75709 10.7537 1.75855 10.9206 1.89231L10.9206 1.89233C11.0021 1.95756 11.0759 2.03034 11.1538 2.10722C11.1748 2.12791 11.1961 2.14889 11.2179 2.1701L11.2626 2.21359C11.5161 2.4603 11.7694 2.70676 12.0203 2.95524L11.715 3.97987ZM9.31214 2.92619L11.0378 4.61662L4.29695 11.2073L2.5731 9.52075L9.31214 2.92619ZM2.0037 11.3828C2.06179 11.0758 2.11937 10.7716 2.17678 10.4686L3.32474 11.5919L1.91565 11.848C1.94517 11.6921 1.9745 11.5371 2.0037 11.3828Z' fill='#FFC00B' stroke='#FFC00B' stroke-width='0.2' />
                            </svg>
                          </a>
                        </p>
                      </div>
                      <div class='from-group addnote-from-group mb-0'>
                        <div class='form-group'>
                          <label for='dishnameenglish' class='form-label'>Add notes</label>
                          <input type='text' class='form-control' placeholder='Type here...'/>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>";

        return $html;
    }

    public function updateDishQty(Request $request)
    {
        try {
            $coupon = false;
            $user = Auth::user();
            if ($request->current_qty >= 1) {
                $user->cart->dishDetails()->where('dish_id', $request->dish_id)->update([
                        'qty' => DB::raw('qty ' . $request->operator . '1')
                    ]
                );
                /*OrderDetail::where('dish_id', $request->dish_id)->update(array(
                    'qty' => DB::raw('qty ' . $request->operator . '1')
                ));*/
            } else {
                $user->cart->dishDetails()->where('dish_id', $request->dish_id)->forceDelete();
//                OrderDetail::where('dish_id', $request->dish_id)->forceDelete();
            }

            if(count($user->cart->dishDetails) == 0){
                $coupon = true;
                $user->cart()->update([
                    'coupon_id' => null,
                    'coupon_code' => null,
                    'coupon_discount' => 0.00
                ]);

            }

            return response::json(['status' => 1, 'message' => $coupon]);

        } catch (Exception $e) {
            return response::json(['status' => 0, 'message' => 'Something went wrong.']);
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
//            dd($order->toArray());
            $order->fresh();
            $dish = Dish::find($id);

            $dishDetail = $user->cart()->withWhereHas('dishDetails', function ($query) use ($id) {
                $query->whereDishId($id)->whereIsCart('1');
            })->first();

            if ($dishDetail && count($dishDetail->dishDetails) > 0) {
                $orderDetails = OrderDetail::find($dishDetail->dishDetails[0]->id);

                $orderDetails->orderDishDetails()->delete();

                $cartArr = [
                    "price" => $dish->price,
                    "qty" => $request->dishQty,
                    "dish_option_id" => $request->option ?? null,
                    "total_price" => $dish->price * $request->dishQty,
                ];

                $orderDetails->update(
                    $cartArr
                );

            } else {
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
                $response['cartHtml'] = $this->cartHtml($orderDetails);
            }

            if (isset($request->freeIng)) {
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
            $response['msg'] = 'Cart Added Successfully';
            $response['paidIngAmt'] = $paidIngAmt;
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

            if ($user->cart->coupon) {
                if (strtotime($user->cart->coupon->expiry_date . ' 23:59:59') < strtotime(now())) {
                    return response::json(['status' => 406, 'message' => "Coupon is expired."]);
                }
            }

            $outOfStockDishes = OrderDetail::with('dish')->whereHas('dish', function ($query) {
                $query->where('qty', 0)->orWhere('out_of_stock', '1');
            })->where([
                ['order_id', $user->cart->id],
                ['is_cart', '1']
            ])->get();

            if (count($outOfStockDishes) > 0) {
                return response::json(['status' => 412, 'message' => "Few items are out of stock. Please remove them to continue."]);
            }

            if ($now < $restaurantHours->start_time || $now > $restaurantHours->end_time) {
                return response::json(['status' => 412, 'message' => "The restaurant doesn't deliver at this time. Please try again after sometime."]);
            }

            if ($user->cart->order_type == OrderType::Delivery) {
                if (session('zipcode')) {

                    $zipcode = Zipcode::select('id')->where([
                        ['zipcode', session('zipcode')],
                        ['status', '1']
                    ])->first();

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
