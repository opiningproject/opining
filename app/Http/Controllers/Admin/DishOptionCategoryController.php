<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DishOptionCategory;
use App\Models\IngredientCategory;
use App\Models\OptionCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use PHPUnit\Exception;
use Response;

class DishOptionCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = isset($request->per_page) ? $request->per_page : 10;
        $dishOptionCategory = DishOptionCategory::orderBy('sort_order','asc')->paginate($perPage);
        return view('admin.dish-options.dish-option-category', [
            'dishOptionCategory' => $dishOptionCategory,
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
            $storedcategory = DishOptionCategory::orderBy('sort_order', 'desc')->first();

            if(empty($storedcategory->sort_order)) {
                $request->request->add(['sort_order' => 1]);
            }else{
                $request->request->add(['sort_order' =>  $storedcategory->sort_order + 1]);
            }
            $category = DishOptionCategory::create(
                $request->all()
            );

            return response::json(['status' => 200, 'data' => $category, 'message' => trans('rest.message.dish_category_add_success')]);

        } catch (Exception $e) {
            return response::json(['status' => 400, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $category = DishOptionCategory::find($id);

            return response::json(['status' => 200, 'data' => $category]);
        } catch (Exception $e) {
            return response::json(['status' => 400, 'message' => trans('rest.message.went_wrong')]);
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
            $category = DishOptionCategory::find($id);

            if($category)
            {
                $category->name_en = $request->name_en;
                $category->name_nl = $request->name_nl;
                $category->save();

                return response::json(['status' => 200, 'message' => trans('rest.message.dish_category_update_success')]);
            }
            else
            {
                return response::json(['status' => 404, 'message' => trans('rest.message.went_wrong')]);
            }

            return response::json(['status' => 200, 'data' => $category]);
        }
        catch (Exception $e)
        {
            return response::json(['status' => 400, 'message' => trans('rest.message.went_wrong')]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            DishOptionCategory::where('id', $id)->delete();
            return response::json(['status' => 1, 'message' => trans('rest.message.category_delete_success')]);
        } catch (Exception $e) {
            return response::json(['status' => 0, 'message' => trans('rest.message.went_wrong')]);
        }
    }

    public function checkAttachedItems(string $id){
        try {
            $ingredients = DishOptionCategory::has('ingredients.dishIngredient')->find($id);
            if($ingredients){
                return response::json(['status' => 400, 'data' => $ingredients]);
            }else{
                return response::json(['status' => 200, 'data' => $ingredients]);
            }

        } catch (Exception $e) {
            return response::json(['status' => 400, 'message' => $e->getMessage()]);
        }
    }

    public function updateCategoryRowOrder(Request $request){
        foreach ($request->order as $key => $order) {

            $data = DishOptionCategory::find($order['id']);
            $data->sort_order=$order['position'];
            $data->save();

        }
    }
}
