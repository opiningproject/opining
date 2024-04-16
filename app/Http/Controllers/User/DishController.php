<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
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
            DishFavorites::where('dish_id', $request->dish_id)->delete();
        } catch (Exception $e) {
            return response::json(['status' => 0, 'message' => 'Something went wrong.']);
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
            return response::json(['status' => 0, 'message' => 'Something went wrong.']);
        }
    }

    public function getCollectedPoints()
    {
        return view('user.points');
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
        $options = $dish->option;
        $freeIngredients = $dish->freeIngredients;

        $paidIngredients = IngredientCategory::withWhereHas('ingredients', function ($query) use ($id) {
            $query->withWhereHas('paidDishIngredientWise', function ($q) use ($id) {
                $q->whereDishId($id);
            });
        })->get();

        $totalAmt = $dish->price;
        $freeSelectedIngredients = [];
        $paidSelectedIngredients = [];
        $selectedOption = '';

        $dishDetail = [];

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


            $selectedOption = $dishDetail->dish_option_id ?? '';

            if ($paidDishDetail) {
                $paidSelectedIngredients = $paidDishDetail->orderDishPaidIngredients->pluck('quantity', 'dish_ingredient_id')->toArray();
            }

            if ($freeDishDetail) {
                $freeSelectedIngredients = $freeDishDetail->orderDishFreeIngredients->pluck('dish_ingredient_id')->toArray();
            }
        }

        $html_options = '';
        if (count($options) > 0) {

            $html_options = "<div class='row justify-content-center'>
                        <div class='col-xl-5'>
                          <div class='form-group mb-0'>
                            <div class='input-group w-100'>
                              <div class='dropdown w-100  ingredientslist-dp custom-default-dropdown'>
                                <select class='form-control bg-white dropdown-toggle d-flex align-items-center justify-content-between w-100' id='dish-option$dish->id'>
                                <option value=''>Please select option</option>";
            foreach ($options as $option) {
                $selected = $selectedOption == $option->id ? 'selected' : '';
                $html_options .= "<option value='$option->id' $selected >$option->name</option>";
            }
            $html_options .= "</select>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>";
        }

        $html_free_ingredients = '';
        if (count($freeIngredients) > 0) {
            $html_free_ingredients .= "<div class='customisable-table custom-table'>
                      <table class='w-100'>
                        <thead>
                          <tr>
                            <th colspan='3'>Existing Ingredients</th>
                          </tr>
                        </thead>
                        <tbody>";
            foreach ($freeIngredients as $ingredient) {
                $checked = in_array($ingredient->id, $freeSelectedIngredients) ? 'checked' : '';
                $defaultCheck = $doesExist ? '' : 'checked';

                $ingredient_name = $ingredient->ingredient->name;
                $ingredient_image = $ingredient->ingredient->image;

                $html_free_ingredients .= "<tr>
                                  <td width='10%'>
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
            $html_paid_ingredients .= "<div class='customisable-table custom-table mt-4'>
                      <table class='w-100'>
                        <thead>
                          <tr>
                            <th colspan='3'>Add Extra Ingredients</th>
                          </tr>
                        </thead>
                      </table>
                      <div class='accordion accordion-flush customisable-accordion' id='accordionExample'>";

            foreach ($paidIngredients as $key => $category) {
                $show = ($key == 0) ? ' show' : '';
                $collapsed = ($key != 0) ? ' collapsed' : '';
                $html_paid_ingredients .= "<div class='accordion-item'>
                          <h2 class='accordion-header'>
                            <button class='accordion-button $collapsed' type='button' data-bs-toggle='collapse' data-bs-target='#collapse$category->id' aria-expanded='true' aria-controls='collapseOne'> $category->name </button>
                          </h2>
                          <div id='collapse$category->id' class='accordion-collapse collapse $show' data-bs-parent='#accordionExample'>
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
                                    <td width='10%'>
                                      <img src='$ingredient_image' class='img-fluid me-15px' alt='$ingredient_name' width='50' height='50'>
                                    </td>
                                    <td class='text-left paid-ing-text'>$ingredient_name <span class='food-custom-price'>€<span id='ing-price-val$ingredient->id'>$ingredient_price</span></span>
                                    </td>
                                    <td width='7%'>
                                      <div class='foodqty mt-0'>
                                        <span class='minus'>
                                          <i class='fas fa-minus align-middle' onclick=addSubDishIngredientQuantities($ingredient->id,'-',$dish->id)></i>
                                        </span>
                                        <input type='number' class='count dishPaidIngQty' data-id='$ingredient_id' readonly id='dishIng$ingredient->id' data-price='$ingredient_price' value='$paidQty'>
                                        <span class='plus'>
                                          <i class='fas fa-plus align-middle' onclick=addSubDishIngredientQuantities($ingredient->id,'+',$dish->id)></i>
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
                  <div class='modal-header border-0 d-block'>
                    <button type='button' class='btn-close float-end' data-bs-dismiss='modal' aria-label='Close'></button>
                    <div class='customisable-item-detail mt-3 text-center'>
                      <div class='mb-3 text-center pro-image'>
                      <img src='$dish->image' alt='burger' width='100' height='100' id='dish_image'>
                      </div>
                      <h4>$dish->name</h4>
                      <p class='my-0'>$dish->description</p>
                      <span class='food-custom-price mb-0' id='dish_price'>€$dish->price</span>
                      <input type='hidden' id='dish-org-price' value='$dish->price'>
                      $html_options
                    </div>
                  </div>
                  <div class='modal-body pt-0 pb-0'>
                    $html_free_ingredients
                    $html_paid_ingredients
                  </div>
                  <div class='modal-footer border-top-0 d-block px-2 px-xxl-3'>
                    <div class='row align-items-center modal-footer-sticky'>
                      <div class='col qty-col'>
                        <div class='foodqty mt-0 mb-0'>
                          <span class='minus'>
                            <i class='fas fa-minus align-middle' onclick=addSubDishQuantities($dish->id,'-',$dish->qty)></i>
                          </span>
                          <input type='number' class='count' name='qty-$dish->id' value='$orderQty' id='totalDishQty' readonly>
                          <span class='plus'>
                            <i class='fas fa-plus align-middle' onclick=addSubDishQuantities($dish->id,'+',$dish->qty)></i>
                          </span>
                        </div>
                      </div>
                      <div class='col col-xx-6 col-xl-7 col-lg-6 col-md-6 text-end float-end ms-auto'>
                        <a href='javascript:void(0);' class='btn btn-custom-yellow fw-400 text-uppercase font-sebibold m-0 w-100 btn-mobile' onclick=addCustomizedCart($dish->id,$doesExist)>$addUpdateText<span>&nbsp;&nbsp;| €</span><span id='total-amt$dish->id'>" . number_format((float)$totalAmt, 2) . "</span>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>";

        return response::json(['status' => 1, 'data' => $html]);
    }
}
