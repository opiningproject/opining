<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Dish;
use App\Models\DishIngredient;
use App\Models\DishOption;
use App\Models\Ingredient;
use App\Models\IngredientCategory;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\User;
use App\Notifications\Admin\NewDish;
use Carbon\Carbon;
use Exception;
use http\Encoding\Stream;
use Illuminate\Support\Facades\DB;
use Response;
use Illuminate\Http\Request;
use Symfony\Component\Console\Input\Input;
use Auth;
use App\Enums\UserType;

class DishController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = isset($request->per_page) ? $request->per_page : 10;
        $dishes = Dish::orderBy('id', 'DESC')->paginate($perPage);
        return view('admin.dish.list', [
            'dishes' => $dishes,
            'perPage' => $perPage
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.dish.create', ['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            $dish = new Dish();
            if ($request->has('image')) {
                $imageName = uploadImageToBucket($request, '/dish');
                $dish->image = $imageName;
            }

            $dish->name_en = $request->name_en;
            $dish->category_id = $request->category_id;
            $dish->name_nl = $request->name_nl;
            $dish->desc_en = $request->desc_en;
            $dish->desc_nl = $request->desc_nl;
            $dish->price = $request->price;
            $dish->percentage_off = $request->percentage_off ?? 0;
            $dish->qty = $request->qty;
            $dish->out_of_stock = isset($request->out_of_stock) ? '1' : '0';
            $dish->save();

            $users = User::where([
                ['user_role', '0'],
                ['enable_email_notification', '1']
            ])->get();

            foreach ($users as $user) {
                $user->notify(new NewDish($dish));
            }

            return redirect()->route('editDish', ['dish' => $dish->id]);
        } catch (Exception $e) {
            return response::json(['status' => 400, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $ingredientCategories = IngredientCategory::all();
        $categories = Category::all();
        $dish = Dish::with('category', 'freeIngredients.ingredient.category', 'paidIngredients.ingredient.category')->find($id);
        return view('admin.dish.edit', ['dish' => $dish, 'categories' => $categories, 'ingredientCategories' => $ingredientCategories]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $dish = Dish::find($id);

            if ($dish) {
                $dish->price = $request->price;
                $dish->save();
                return response::json(['status' => 200, 'data' => $dish]);
            } else {
                return response::json(['status' => 400, 'message' => trans('rest.message.went_wrong')]);
            }
        } catch (Exception $e) {
            return response::json(['status' => 400, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $dish = Dish::find($id);

            if ($dish) {
                foreach ($dish->cartOrderDetails  as $orderDetail){
                    $orderDetail->orderDishIngredients()->forceDelete();
                }
                $dish->cartOrderDetails()->forceDelete();
                $dish->adminFavourite()->forceDelete();

                $dish->option()->delete();
                $dish->ingredients()->delete();
                $dish->delete();
                return response::json(['status' => 200, 'message' => trans('rest.message.dish_delete_success')]);
            } else {
                return response::json(['status' => 400, 'message' => trans('rest.message.went_wrong')]);
            }
        } catch (Exception $e) {
            return response::json(['status' => 400, 'message' => $e->getMessage()]);
        }
    }

    public function ingredientDishBased(Request $request, string $id)
    {
        try {
            $ingredients = Ingredient::doesntHave('dishIngredient', 'and', function ($query) use ($request, $id) {
                if ($request->type == 'paid') {
                    $query->where([
                        ['dish_id', $id],
                        ['is_free', '0']
                    ]);
                } else {
                    $query->where([
                        ['dish_id', $id],
                        ['is_free', 1]
                    ]);
                }
            })->get();

            return response::json(['status' => 200, 'data' => $ingredients]);
        } catch (Exception $e) {
            return response::json(['status' => 400, 'message' => $e->getMessage()]);
        }
    }

    public function addDishIngredient(Request $request, string $id)
    {
        try {
            $dishIngredient = DishIngredient::create([
                'dish_id' => $id,
                'ingredient_id' => $request->ingredient_id,
                'is_free' => $request->type == 'free' ? 1 : '0',
                'price' => isset($request->price) ? $request->price : 0
            ]);

            $dishIng = $dishIngredient->whereId($dishIngredient->id)->with('ingredient.category')->first();
            return response::json(['status' => 200, 'data' => $dishIng]);
        } catch (Exception $e) {
            return response::json(['status' => 400, 'message' => $e->getMessage()]);
        }
    }

    public function updatePaidIngredient(Request $request, string $id)
    {
        try {
            $dishIngredient = DishIngredient::find($id);
            if ($dishIngredient) {
                $dishIngredient->price = $request->price;
                $dishIngredient->save();
                return response::json(['status' => 200, 'data' => $dishIngredient]);
            } else {
                return response::json(['status' => 400, 'message' => trans('rest.message.went_wrong')]);
            }

        } catch (Exception $e) {
            return response::json(['status' => 400, 'message' => $e->getMessage()]);
        }
    }

    public function deleteDishIngredient(string $id)
    {
        try {
            $dishIngredient = DishIngredient::find($id);

            if ($dishIngredient) {
                $dishIngredient->delete();
                return response::json(['status' => 200, 'message' => trans('rest.message.dish_ingre_delete_success')]);
            } else {
                return response::json(['status' => 400, 'message' => trans('rest.message.went_wrong')]);
            }
        } catch (Exception $e) {
            return response::json(['status' => 400, 'message' => $e->getMessage()]);
        }
    }

    public function updateDishData(Request $request, string $id)
    {
        try {
            $dish = Dish::find($id);

            if ($dish) {
                $dish->name_en = $request->name_en;
                $dish->name_nl = $request->name_nl;
                $dish->desc_en = $request->desc_en;
                $dish->desc_nl = $request->desc_nl;
                $dish->price = $request->price;
                $dish->category_id = $request->category_id;
                $dish->percentage_off = $request->percentage_off;
//                $dish->qty = $request->qty;
                $dish->out_of_stock = isset($request->out_of_stock) ? '1' : '0';

                if ($request->has('image')) {
                    $imageName = uploadImageToBucket($request, 'dish', '');
                    $dish->image = $imageName;
                }

                if ($dish->save()) {

                    if (isset($request->deletedOption)) {
                        $deletedDishArray = explode(',', $request->deletedOption);
                        DishOption::whereIn('id', $deletedDishArray)->delete();
                    }

                    if (isset($request->addedOption)) {
                        foreach ($request->addedOption as $addedOption) {
                            $addedOption = json_decode($addedOption);
                            $dishOption = DishOption::find($addedOption->id);
                            $dishOption->option_en = $addedOption->name_en;
                            $dishOption->option_nl = $addedOption->name_nl;
                            $dishOption->save();
                        }
                    }

                    if (isset($request->newOption)) {
                        foreach ($request->newOption as $newOption) {
                            $newOption = json_decode($newOption);

                            $dish->option()->create([
                                'option_en' => $newOption->name_en,
                                'option_nl' => $newOption->name_nl
                            ]);
                        }
                    }

                    return response::json(['status' => 200, 'message' => trans('rest.message.dish_update_success')]);
                } else {
                    return response::json(['status' => 400, 'message' => trans('rest.message.went_wrong')]);
                }
            } else {
                return response::json(['status' => 400, 'message' => trans('rest.message.went_wrong')]);
            }
        } catch (Exception $e) {
            return response::json(['status' => 400, 'message' => $e->getMessage()]);
        }
    }

    public function searchDish(Request $request)
    {
        $user = Auth::user();

        $dishes = Dish::orderBy('id');
        if ($request->has('search')) {
            if (app()->getLocale() == 'en') {
                $dishes->orWhere('name_en', 'like', '%' . $request->search . '%');
            } else {
                $dishes->orWhere('name_nl', 'like', '%' . $request->search . '%');
            }
        }

        if ($request->has('cat_id') && $request->cat_id != 'null') {
            $dishes->where('category_id', $request->cat_id);
        }

        if ($user && $user->user_role == UserType::Admin) {
            return view('admin.dish.dish-list', ['dishes' => $dishes->get()]);
        } else {
            return view('user.dish.dish-list', ['dishes' => $dishes->get()]);
        }


    }

    public function popularDish()
    {

        $currentWeekStartDate = Carbon::now()->startOfWeek();
        $currentWeekEndDate = Carbon::now()->endOfWeek();
        $previousWeekStartDate = Carbon::now()->subWeek()->startOfWeek();
        $previousWeekEndDate = Carbon::now()->subWeek()->endOfWeek();

        $currentWeekCounts = OrderDetail::whereHas('dishWithoutTrash')->select('dish_id', DB::raw('count(*) as total'))
            ->whereBetween('created_at', [$currentWeekStartDate, $currentWeekEndDate])
            ->groupBy('dish_id')
            ->orderByDesc('total')
            ->get()
            ->pluck('total', 'dish_id');

        // Query to get the counts of orders for each dish for the previous week
        $previousWeekCounts = OrderDetail::whereHas('dishWithoutTrash')->select('dish_id', DB::raw('count(*) as total'))
            ->whereBetween('created_at', [$previousWeekStartDate, $previousWeekEndDate])
            ->groupBy('dish_id')
            ->orderByDesc('total')
            ->get()
            ->pluck('total', 'dish_id');

        // Calculate percentage increase for each dish
        $popularDishes = [];

        if (!empty($currentWeekCounts)) {
            foreach ($currentWeekCounts as $dishId => $currentWeekCount) {
                $previousWeekCount = $previousWeekCounts->get($dishId, 0);
                $percentageCalculation = ($currentWeekCount - $previousWeekCount) / ($previousWeekCount ?: 1) * 100;
                $popularDishes[$dishId] = ['percentage' => round($percentageCalculation, 2), 'total_orders' => $currentWeekCount];
            }
        }

        return view('admin.dish.popular-list', [
            'popularDishes' => $popularDishes
        ]);
    }

    public function bestSellerDish()
    {

        $orderDetailsQuery = OrderDetail::whereHas('dish')->select('dish_id', DB::raw('COUNT(*) as total_orders'))
            ->groupBy('dish_id')
            ->orderByDesc('total_orders');

        $bestSellerDishes = $orderDetailsQuery->get();

        return view('admin.dish.bestseller-list', [
            'bestSellerDishes' => $bestSellerDishes,
        ]);
    }

//    for manual order functions
    public function getDishDetails(string $id, string $doesExist)
    {
        if (!\Illuminate\Support\Facades\Auth::user()) {
            return response::json(['status' => 2, 'message' => '']);
        }

        $user = Auth::user();

//        $user_id = $user->id;
        $user_id = 0;
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
                            <th colspan='3' class='py-2'>".trans('modal.dish.ingredients')."</th>
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
                        <a href='javascript:void(0);' class='btn btn-site-theme fw-400 text-uppercase font-sebibold m-0 w-100 btn-mobile' onclick=addCustomizedCartCustom($dish->id,$doesExist)>$addUpdateText<span>&nbsp;&nbsp;| €</span><span id='total-amt$dish->id'>" . number_format((float)$totalAmt + $optionTotalAmount, 2) . "</span>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>";

        return response::json(['status' => 1, 'data' => $html]);
    }
}
