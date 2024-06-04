<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DishIngredient;
use App\Models\Ingredient;
use App\Models\IngredientCategory;
use PHPUnit\Exception;
use Illuminate\Http\Request;
use Response;

class IngredientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = isset($request->per_page) ? $request->per_page : 10;
        $ingredientCategory = IngredientCategory::all();

        $ingredients = Ingredient::with('freeDishIngredient.dish')->orderBy('sort_order', 'asc')->paginate($perPage);

        return view('admin.ingredients.index', [
            'ingredientCategory' => $ingredientCategory,
            'ingredients' => $ingredients,
            'perPage' => $perPage
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            if ($request->has('image')) {
                $imageName = uploadImageToBucket($request, 'ingredients/');
            }

            $storedIngredient = Ingredient::orderBy('sort_order', 'desc')->first();

            $ingredient = new Ingredient();
            $ingredient->image = $imageName;
            $ingredient->name_en = $request->name_en;
            $ingredient->name_nl = $request->name_nl;
            $ingredient->category_id = $request->category_id;

            if(empty($storedIngredient->sort_order)) {
                $ingredient->sort_order = 1;
            }else{
                $ingredient->sort_order = $storedIngredient->sort_order + 1;
            }

            $ingredient->save();

            return redirect()->back();
        } catch (Exception $e) {
            return response::json(['status' => 0, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $ingredients = Ingredient::where('id', $id)->has('dishIngredient')->get();

            return response::json(['status' => 1, 'data' => '']);
        } catch (Exception $e) {
            return response::json(['status' => 0, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Ingredient::find($id)->delete();
            return response::json(['status' => 200, 'message' => trans('rest.message.ingredient_delete_success')]);

        } catch (Exception $e) {
            return response::json(['status' => 400, 'message' => $e->getMessage()]);
        }
    }

    public function updateIngredientStatus(Request $request, string $id)
    {
        try {
            $ingredient = Ingredient::find($id);
            if ($ingredient) {
                $ingredient->status = $request->status;
                $ingredient->save();

                return response::json(['status' => 200, 'data' => $ingredient, 'message' => trans('rest.message.ingredient_status_success')]);
            }
            else
            {
                return response::json(['status' => 400, 'message' => trans('rest.message.went_wrong')]);
            }

        } catch (Exception $e) {
            return response::json(['status' => 400, 'message' => $e->getMessage()]);
        }
    }

    public function ingredientCategoryWise(string $id)
    {
        try {
            $ingredients = Ingredient::where('category_id', $id)->get();
            return response::json(['status' => 200, 'data' => $ingredients]);
        } catch (Exception $e) {
            return response::json(['status' => 400, 'message' => $e->getMessage()]);
        }
    }

    public function checkAttachedDish(string $id)
    {
        try {
            $ingredients = Ingredient::has('dishIngredientWithoutTrash')->find($id);

            if($ingredients){
                return response::json(['status' => 400, 'data' => $ingredients]);
            }else{
                return response::json(['status' => 200, 'data' => $ingredients]);
            }

        } catch (Exception $e) {
            return response::json(['status' => 400, 'message' => $e->getMessage()]);
        }
    }

    public function updateIngredient(Request $request, string $id){
        try {

            $ingredient = Ingredient::find($id);
            if($ingredient){
                if ($request->has('image')) {
                    $imageName = uploadImageToBucket($request, 'ingredients/', '');
                    $ingredient->image = $imageName;
                }

                $ingredient->name_en = $request->name_en;
                $ingredient->name_nl = $request->name_nl;
                $ingredient->category_id = $request->category_id;
                $ingredient->save();

                if(!empty($request->deletedDish)){
                    $dishList = explode(',', $request->deletedDish);
                    DishIngredient::whereIn('id',$dishList)->delete();
                }

                if($request->has('addedDish')){
                    foreach ($request->addedDish as $addedDish) {
                        $ingredient->dishIngredient()->create([
                            'dish_id' => $addedDish
                        ]);
                    }
                }

                return response::json(['status' => 200, 'message' => trans('rest.message.ingredient_updated_success')]);

            }else{
                return response::json(['status' => 400, 'message' => trans('rest.message.went_wrong')]);
            }
            return response::json(['status' => 200, 'data' => $ingredient]);
        } catch (Exception $e) {
            return response::json(['status' => 400, 'message' => $e->getMessage()]);
        }
    }

    public function updateingredientRowOrder(Request $request){

        foreach ($request->order as $key => $order) {

            $data=Ingredient::find($order['id']);
            $data->sort_order=$order['position'];
            $data->save();

        }
    }
}
