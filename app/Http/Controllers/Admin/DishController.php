<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Dish;
use App\Models\DishIngredient;
use App\Models\DishOption;
use App\Models\Ingredient;
use App\Models\IngredientCategory;
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
        $dish = Dish::with('category', 'option', 'freeIngredients.ingredient.category', 'paidIngredients.ingredient.category')->find($id);
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
                $dish->qty = $request->qty;
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

        $currentWeekCounts = OrderDetail::whereHas('dish')->select('dish_id', DB::raw('count(*) as total'))
            ->whereBetween('created_at', [$currentWeekStartDate, $currentWeekEndDate])
            ->groupBy('dish_id')
            ->orderByDesc('total')
            ->get()
            ->pluck('total', 'dish_id');

        // Query to get the counts of orders for each dish for the previous week
        $previousWeekCounts = OrderDetail::whereHas('dish')->select('dish_id', DB::raw('count(*) as total'))
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
}
