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

        $ingredients = Ingredient::with('freeDishIngredient.dish')->orderBy('id', 'desc')->paginate($perPage);

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

            $ingredient = new Ingredient();
            $ingredient->image = $imageName;
            $ingredient->name_en = $request->name_en;
            $ingredient->name_nl = $request->name_nl;
            $ingredient->category_id = $request->category_id;
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

            return response::json(['status' => 1, 'data' => 'Ingredient deleted successfully']);
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
            }else{
                return response::json(['status' => 400, 'message' => 'No such ingredient exist']);
            }
            return response::json(['status' => 200, 'data' => $ingredient]);
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
            Ingredient::find($id)->delete();
            return response::json(['status' => 200, 'message' => 'Deleted Successfully.']);

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
                return response::json(['status' => 200, 'data' => $ingredient]);
            } else {
                return response::json(['status' => 400, 'message' => 'No such ingredient exist']);
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
            $ingredients = Ingredient::has('dishIngredient')->find($id);
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
            }else{
                return response::json(['status' => 400, 'message' => 'No such ingredient exist']);
            }
            return response::json(['status' => 200, 'data' => $ingredient]);
        } catch (Exception $e) {
            return response::json(['status' => 400, 'message' => $e->getMessage()]);
        }
    }
}
