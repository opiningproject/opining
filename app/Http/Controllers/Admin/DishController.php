<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Dish;
use App\Models\DishIngredient;
use App\Models\DishOption;
use App\Models\Ingredient;
use App\Models\IngredientCategory;
use Exception;
use http\Encoding\Stream;
use Response;
use Illuminate\Http\Request;
use Symfony\Component\Console\Input\Input;

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

            if($request->has('image')){
                $imageName = uploadImageToBucket($request, 'dish');
                $request->merge(['image' => $imageName]);
            }

            $dish = Dish::create(
                $request->all()
            );
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
                return response::json(['status' => 400, 'message' => 'No such Ingredient exist.']);
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
                $dish->option()->delete();
                $dish->ingredients()->delete();
                $dish->delete();
                return response::json(['status' => 200, 'message' => 'Deleted Successfully.']);
            } else {
                return response::json(['status' => 400, 'message' => 'No such dish exist.']);
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
                return response::json(['status' => 400, 'message' => 'No such Ingredient exist.']);
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
                return response::json(['status' => 200, 'message' => 'Dish Ingredient Deleted successfully']);
            } else {
                return response::json(['status' => 400, 'message' => 'No such Ingredient Attached']);
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
                $dish->percentage_off = $request->percentage_off;
                $dish->qty = $request->qty;
                $dish->out_of_stock = isset($request->out_of_stock) ? '1' : '0';
                if ($dish->save()) {

                    if($request->has('image')){
                        $imageName = uploadImageToBucket($request, 'dish','');
                        $request->merge(['image' => $imageName]);
                    }

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

                    return response::json(['status' => 200, 'message' => 'Successfully Updated']);
                } else {
                    return response::json(['status' => 400, 'message' => 'Something went wrong. Please try again.']);
                }
            } else {
                return response::json(['status' => 400, 'message' => 'No such Dish Exist']);
            }
        } catch (Exception $e) {
            return response::json(['status' => 400, 'message' => $e->getMessage()]);
        }
    }

    public function searchDish(Request $request)
    {
        $dishes = Dish::orderBy('id');
        if ($request->has('search')) {
            if (app()->getLocale() == 'en') {
                $dishes->orWhere('name_en', 'like', '%' . $request->search . '%');
            } else {
                $dishes->orWhere('name_nl', 'like', '%' . $request->search . '%');
            }
        }
        return view('admin.dish.dish-list', ['dishes' => $dishes->get()]);
    }
}
