<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Dish;
use App\Models\DishIngredient;
use App\Models\Ingredient;
use App\Models\IngredientCategory;
use Exception;
use Response;
use Illuminate\Http\Request;

class DishController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return view('admin.dish.create', ['categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        $dish = Dish::with('category','option', 'freeIngredients.ingredient.category', 'paidIngredients.ingredient.category')->find($id);
        return view('admin.dish.edit', ['dish' => $dish, 'categories' => $categories, 'ingredientCategories' => $ingredientCategories]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function ingredientDishBased(Request $request, string $id){
        try {
            $ingredients = Ingredient::doesntHave('dishIngredient', 'and', function ($query) use ($request, $id){
                if($request->type == 'paid'){
                    $query->where([
                        ['dish_id', $id],
                        ['is_free', '0']
                    ]);
                }else{
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

    public function addDishIngredient(Request $request, string $id){
        try {
            $dishIngredient = DishIngredient::create([
                'dish_id' => $id,
                'ingredient_id' => $request->ingredient_id,
                'is_free' => $request->type == 'free' ? 1 : '0'
            ]);
//            dd($dishIngredient->toArray());
            $dishIng = $dishIngredient->whereId($dishIngredient->id)->with('ingredient.category')->first();
            return response::json(['status' => 200, 'data' => $dishIng]);
        } catch (Exception $e) {
            return response::json(['status' => 400, 'message' => $e->getMessage()]);
        }
    }

    public function updatePaidIngredient(Request $request, string $id){
        try {
            $dishIngredient = DishIngredient::find($id);
            if($dishIngredient){
                $dishIngredient->price = $request->price;
                $dishIngredient->save();
                return response::json(['status' => 200, 'data' => $dishIngredient]);
            }else{
                return response::json(['status' => 400, 'message' => 'No such Ingredient exist.']);
            }

        } catch (Exception $e) {
            return response::json(['status' => 400, 'message' => $e->getMessage()]);
        }
    }
}
