<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IngredientCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use PHPUnit\Exception;
use Response;

class IngredientCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = isset($request->per_page) ? $request->per_page : 10;
        $ingredientCategory = IngredientCategory::orderBy('id','DESC')->paginate($perPage);
        
        return view('admin.ingredients.ingredient-category', [
            'ingredientCategory' => $ingredientCategory,
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
            $category = IngredientCategory::create(
                $request->all()
            );
            return response::json(['status' => 200, 'data' => $category, 'message' => trans('rest.message.category_add_success')]);

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
            $category = IngredientCategory::find($id);

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
            $category = IngredientCategory::find($id);

            if($category)
            {
                $category->name_en = $request->name_en;
                $category->name_nl = $request->name_nl;
                $category->save();

                return response::json(['status' => 200, 'message' => trans('rest.message.category_update_success')]);
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
            IngredientCategory::where('id', $id)->delete();
            return response::json(['status' => 1, 'message' => trans('rest.message.category_delete_success')]);
        } catch (Exception $e) {
            return response::json(['status' => 0, 'message' => trans('rest.message.went_wrong')]);
        }
    }

    public function checkAttachedItems(string $id){
        try {
            $ingredients = IngredientCategory::has('ingredients.dishIngredient')->find($id);
            if($ingredients){
                return response::json(['status' => 400, 'data' => $ingredients]);
            }else{
                return response::json(['status' => 200, 'data' => $ingredients]);
            }

        } catch (Exception $e) {
            return response::json(['status' => 400, 'message' => $e->getMessage()]);
        }
    }
}
