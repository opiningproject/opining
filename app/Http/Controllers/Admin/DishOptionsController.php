<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DishCategoryOption;
use App\Models\DishIngredient;
use App\Models\DishOption;
use App\Models\DishOptionCategory;
use App\Models\Ingredient;
use App\Models\IngredientCategory;
use PHPUnit\Exception;
use Illuminate\Http\Request;
use Response;

class DishOptionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = isset($request->per_page) ? $request->per_page : 10;
        $dishOptionCategory = DishOptionCategory::all();
        $optionCategory = DishCategoryOption::with('dishOptions')->orderBy('sort_order', 'asc')->paginate($perPage);
        return view('admin.dish-options.index', [
            'dishOptionCategory' => $dishOptionCategory,
            'optionCategory' => $optionCategory,
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
            $storedIngredient = DishCategoryOption::orderBy('sort_order', 'desc')->first();

            $ingredient = new DishCategoryOption();
            $ingredient->name_en = $request->name_en;
            $ingredient->name_nl = $request->name_nl;
            $ingredient->cat_id = $request->category_id;

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
            return response::json(['status' => 200, 'message' => trans('rest.message.dish_category_delete_success')]);

        } catch (Exception $e) {
            return response::json(['status' => 400, 'message' => $e->getMessage()]);
        }
    }

    public function updateIngredientStatus(Request $request, string $id)
    {
        try {
            $ingredient = DishCategoryOption::find($id);
            if ($ingredient) {
                $ingredient->status = $request->status;
                $ingredient->save();

                return response::json(['status' => 200, 'data' => $ingredient, 'message' => trans('rest.message.dish_category_status_success')]);
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
//            dd($request->all());
            $optionCategory = DishCategoryOption::find($id);
            if($optionCategory){
//                dd($ingredient);

                $optionCategory->name_en = $request->name_en;
                $optionCategory->name_nl = $request->name_nl;
                $optionCategory->cat_id = $request->category_id;
                $optionCategory->save();
                if(!empty($request->deletedDish)){
                    $dishList = explode(',', $request->deletedDish);
                    DishOption::whereIn('id',$dishList)->delete();
                }
                if($request->has('addedDish')){
                    foreach ($request->addedDish as $addedDish) {
                        $optionCategory->dishOptions()->create([
                            'dish_id' => $addedDish,
                            'dish_category_options_id' => $optionCategory->id
                        ]);
                    }
                }

                return response::json(['status' => 200, 'message' => trans('rest.message.dish_category_updated_success')]);

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

            $data=DishCategoryOption::find($order['id']);
            $data->sort_order=$order['position'];
            $data->save();

        }
    }
}