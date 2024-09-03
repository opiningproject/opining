<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Coupon;
use App\Models\DishOption;
use App\Models\DishOptionCategory;
use App\Models\IngredientCategory;
use App\Models\Order;
use App\Models\OrderDishDetail;
use Illuminate\Http\Request;
use App\Models\DishFavorites;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Dish;
use App\Models\OrderDetail;
use Validator, Redirect, Response;

class DishController extends Controller
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

    public function getFavoriteDishes()
    {
        $dishes = DishFavorites::with('dish')->where('user_id', Auth::user()->id)->get();

        return view('user.favorite', ['dishes' => $dishes]);
    }

    public function unFavorite(Request $request)
    {
        try {
            $user_id = Auth::user()->id;
            DishFavorites::where([
                ['dish_id', $request->dish_id],
                ['user_id', $user_id]
            ])->delete();

        } catch (Exception $e) {
            return response::json(['status' => 0, 'message' => trans('user.message.went_wrong')]);
        }
    }

    public function favorite(Request $request)
    {

        if (!Auth::user()) {
            return response::json(['status' => 2, 'message' => '']);
        }

        try {
            $request->merge(["user_id" => Auth::user()->id]);

            DishFavorites::create(
                $request->all()
            );
        } catch (Exception $e) {
            return response::json(['status' => 0, 'message' => trans('user.message.went_wrong')]);
        }
    }

    public function getCollectedPoints()
    {

      // Coupons
        $user = Auth::user();

        $coupons = Coupon::where(
            [
                ['start_expiry_date', '<=', date('Y-m-d')],
                ['end_expiry_date', '>=', date('Y-m-d')],
            ]
        )->withActive()->orderBy('id', 'desc')->get();


        return view('user.points', ['coupons' => $coupons, 'user' => $user]);
    }

    public function getDishDetails(string $id, string $doesExist)
    {
        if (!Auth::user()) {
            return response::json(['status' => 2, 'message' => '']);
        }

        $user = Auth::user();

        $user_id = $user->id;
        $order = Order::where([
            ['user_id', $user_id],
            ['is_cart', '1']
        ])->first();

        if (empty($order)) {
            $order = new Order();
            $order->user_id = $user_id;
            $order->is_cart = '1';
            $order->save();
        }

        $dish = Dish::find($id);

        $dishOption = null;

        $options = $dish->optionWithoutTrashed;
        $freeIngredients = $dish->freeWithoutTrashIngredients;

        $paidIngredients = IngredientCategory::withWhereHas('ingredients', function ($query) use ($id) {
            $query->withWhereHas('paidDishIngredientWise', function ($q) use ($id) {
                $q->whereDishId($id);
            });
        })->orderBy('sort_order', 'asc')->get();

        $totalAmt = $dish->price;
        $freeSelectedIngredients = [];
        $paidSelectedIngredients = [];
        $selectedOption = '';

        $dishDetail = [];
        $optionTotalAmount = 0;
        if ($doesExist) {

            /*$dishDetail = $user->cart()
                ->with(['dishDetails' => function ($query) use ($doesExist){
                    $query->whereId($doesExist);
                }])->first();*/
            $dishDetail = OrderDetail::find($doesExist);

            $paidDishDetail = $order->dishDetails()->whereHas('orderDishPaidIngredients', function ($query) use ($doesExist) {
                $query->whereOrderDetailId($doesExist);
            })->with('orderDishPaidIngredients')->first();

            $freeDishDetail = $order->dishDetails()->whereHas('orderDishFreeIngredients', function ($query) use ($doesExist) {
                $query->whereOrderDetailId($doesExist);
            })->with('orderDishFreeIngredients')->first();


            $selectedOption = $dishDetail->orderDishOptionDetails ? $dishDetail->orderDishOptionDetails->pluck('dish_option_id') : [];
            if (count($selectedOption) > 0) {
                $optionTotalAmount = getDishOptionCategoryTotalAmount($selectedOption);
                $optionTotalAmount = $optionTotalAmount * $dishDetail->qty;
            }

            if ($paidDishDetail) {
                $paidSelectedIngredients = $paidDishDetail->orderDishPaidIngredients->pluck('quantity', 'dish_ingredient_id')->toArray();
            }

            if ($freeDishDetail) {
                $freeSelectedIngredients = $freeDishDetail->orderDishFreeIngredients->pluck('dish_ingredient_id')->toArray();
            }
        }

        $catId = null;

        $dishOptionCategoryData = getDishOptionCategory($dish->id);
        $html_options = '';
        if (count($dishOptionCategoryData) > 0) {
            foreach($dishOptionCategoryData as $key => $value) {
                    $html_options .= "<div class='row justify-content-center'>
                        <div class='col-sm-9'>
                          <div class='form-group mb-3'>
                            <div class='input-group w-100'>
                              <div class='dropdown w-100  ingredientslist-dp custom-default-dropdown'>
                              <label class='option_label'>$value->title</label>
                                <select name='dish_option' class='form-control bg-white dropdown-toggle d-flex align-items-center justify-content-between w-100 dish-option-select' id='dish-option$dish->id' onchange='addDishOptionPrice($dish->id, this.options[this.selectedIndex].getAttribute(\"data-price\"),this.options[this.selectedIndex].getAttribute(\"data-id\"))'>
                                <option disabled selected value=''>".trans('modal.dish.select_category')."</option>";
                                                foreach ($value->dishCategoryOption as $optionKey => $option) {
                                                    $selected = '';
                                                    $price = $option->price ? '+€'.number_format($option->price, 2) : '';
                                                    if ($selectedOption != '') {
                                                        $selected = in_array($option->id, $selectedOption->toArray()) ? 'selected' : '';
                                                    }
                                                    $html_options .= "<option value='$option->id' $selected data-price='$option->price' data-id='$option->id' >$option->name $price</option>";
                                                }
                                    $html_options .= "</select>
                                                        <label class='error dish-option-error d-none'>".trans('modal.dish.field_required')."</label>
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>
                                              </div>";
            }
        }

        $html_free_ingredients = '';
        if (count($freeIngredients) > 0) {
            $html_free_ingredients .= "<div class='customisable-table custom-table ingredients-table'>
                      <table class='w-100'>
                        <thead>
                          <tr>
                            <th colspan='3'>".trans('modal.dish.ingredients')."</th>
                          </tr>
                        </thead>
                        <tbody>";
            foreach ($freeIngredients as $ingredient) {
                $checked = in_array($ingredient->id, $freeSelectedIngredients) ? 'checked' : '';
                $defaultCheck = $doesExist ? '' : 'checked';

                $ingredient_name = $ingredient->ingredient->name;
                $ingredient_image = $ingredient->ingredient->image;

                $html_free_ingredients .= "<tr>
                                  <td width='16%'>
                                    <img src='$ingredient_image' class='img-fluid me-15px' alt='$ingredient_name' width='50' height='50'>
                                  </td>
                                  <td class='text-left'>$ingredient_name</td>
                                  <td width='5%'>
                                    <div class='form-check'>
                                      <input class='form-check-input from-check-input-yellow dishFreeIngQty' data-id='$ingredient->id' $checked type='checkbox' value='1' name='dishFreeIngQty[]' $defaultCheck>
                                    </div>
                                  </td>
                                </tr>";
            }
            $html_free_ingredients .= "</tbody>
                      </table>
                    </div>";
        }

        $html_paid_ingredients = '';

        if (count($paidIngredients) > 0) {
            $html_paid_ingredients .= "<div class='customisable-table custom-table mt-2'>
                      <table class='w-100'>
                        <thead>
                          <tr>
                            <th colspan='3'>".trans('modal.dish.extras')."</th>
                          </tr>
                        </thead>
                      </table>
                      <div class='accordion accordion-flush customisable-accordion' id='accordionExample'>";

            foreach ($paidIngredients as $key => $category) {
                $show = ($key == 0) ? ' show' : '';
                $collapsed = ($key != 0) ? ' collapsed' : '';
                // old code commented  on 27-08-2024
//                $html_paid_ingredients .= "<div class='accordion-item'>
//                          <h2 class='accordion-header'>
//                            <button class='accordion-button $collapsed' type='button' data-bs-toggle='collapse' data-bs-target='#collapse$category->id' aria-expanded='true' aria-controls='collapseOne'> $category->name </button>
//                          </h2>
//                          <div id='collapse$category->id' class='accordion-collapse collapse $show' data-bs-parent='#accordionExample'>
//                            <div class='accordion-body py-1'>
//                              <table>
//                                <tbody>";
                $html_paid_ingredients .= "<div class='accordion-item'>
                          <h2 class='accordion-header'>
                            <h2 class='paid_ingredients-list pb-0'> $category->name </h2>
                          </h2>
                          <div id='collapse$category->id' data-bs-parent='#accordionExample'>
                            <div class='accordion-body py-1'>
                              <table>
                                <tbody>";

                foreach ($category->ingredients as $ingredient) {
                    $paidQty = 0;

                    $ingredient_name = $ingredient->name;
                    $ingredient_image = $ingredient->image;
                    $ingredient_price = $ingredient->paidDishIngredientWise->price;
                    $ingredient_id = $ingredient->paidDishIngredientWise->id;
                    if (array_key_exists($ingredient_id, $paidSelectedIngredients)) {
                        $paidQty = $paidSelectedIngredients[$ingredient_id];
                        $totalAmt += ($paidQty * $ingredient_price);
                    }

                    $html_paid_ingredients .= "<tr>
                                    <td width='16%'>
                                      <img src='$ingredient_image' class='img-fluid me-15px' alt='$ingredient_name' width='50' height='50'>
                                    </td>
                                    <td class='text-left paid-ing-text'>$ingredient_name <span class='food-custom-price'>€<span id='ing-price-val$ingredient->id'>".number_format($ingredient_price,2)."</span></span>
                                    </td>
                                    <td width='7%'>
                                      <div class='foodqty mt-0'>
                                        <span class='minus' onclick=addSubDishIngredientQuantities($ingredient->id,'-',$dish->id)>
                                          <i class='fas fa-minus align-middle'></i>
                                        </span>
                                        <input type='number' class='count dishPaidIngQty' data-id='$ingredient_id' readonly id='dishIng$ingredient->id' data-price='$ingredient_price' value='$paidQty'>
                                        <span class='plus' onclick=addSubDishIngredientQuantities($ingredient->id,'+',$dish->id)>
                                          <i class='fas fa-plus align-middle'></i>
                                        </span>
                                      </div>
                                    </td>
                                  </tr>";
                }
                $html_paid_ingredients .= "</tbody>
                              </table>
                            </div>
                          </div>
                        </div>";
            }
            $html_paid_ingredients .= "</div>
                    </div>";
        }

        $addUpdateText = 'Add Item';
        $orderQty = 1;

            if ($doesExist) {
            $addUpdateText = 'Update Item';
            $orderQty = $dishDetail->qty;
        }

        $totalAmt *= $orderQty;
        $html = "<div class='modal-content'>
                  <div class='modal-header border-0 d-block pb-0'>
                    <button type='button' class='btn-close float-end' data-bs-dismiss='modal' aria-label='Close'></button>
                    </div>
                  <div class='modal-body pt-0 pb-0'>
                  <div class='customisable-item-detail mt-3 text-center'>
                      <div class='mb-3 text-center pro-image'>
                      <img src='$dish->image' alt='burger' width='100' height='100' id='dish_image'>
                      </div>
                      <h4>$dish->name</h4>
                      <p class='my-0'>$dish->description</p>
                      <span class='food-custom-price mb-3' id='dish_price'>€".number_format($dish->price,2)."</span>
                      <input type='hidden' id='dish-org-price' value='$dish->price'>
                      </div>
                  $html_options
                    $html_free_ingredients
                    $html_paid_ingredients
                  </div>
                  <div class='modal-footer border-top-0 d-block px-2 px-xxl-3'>
                    <div class='row align-items-center modal-footer-sticky'>
                      <div class='col qty-col'>
                        <div class='foodqty mt-1 mb-0'>
                          <span class='minus'>
                            <i class='fas fa-minus align-middle' onclick=addSubDishQuantities($dish->id,'-',$dish->qty)></i>
                          </span>
                          <input type='number' class='count' name='qty-$dish->id' value='$orderQty' id='totalDishQty' readonly>
                          <span class='plus'>
                            <i class='fas fa-plus align-middle' onclick=addSubDishQuantities($dish->id,'+',$dish->qty)></i>
                          </span>
                        </div>
                      </div>
                      <div class='col col-xx-7 col-xl-7 col-lg-6 col-md-6 text-end float-end ms-auto'>
                        <a href='javascript:void(0);' class='btn btn-custom-yellow fw-400 text-uppercase font-sebibold m-0 w-100 btn-mobile' onclick=addCustomizedCart($dish->id,$doesExist)>$addUpdateText<span>&nbsp;&nbsp;| €</span><span id='total-amt$dish->id'>" . number_format((float)$totalAmt + $optionTotalAmount, 2) . "</span>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>";

        return response::json(['status' => 1, 'data' => $html]);
    }

    function getDishes(Request $request,$cat_id)
    {

      if ($cat_id) {

        $category = Category::find($cat_id);

        $dishes = Dish::with(['favorite','category'])->where('category_id', $cat_id);

        $dishesHTML = view('user.dish.dish-list', ['dishes' => $dishes->get()])->render();

        return response()->json(['status' => 1, 'data' =>  $dishesHTML,'cat_name' => $category->name]);

      }
    }

}
