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
    public function index()
    {
        $ingredientCategory = IngredientCategory::orderBy('id','DESC')->get();
        return view('admin.ingredients.ingredient-category', [
            'ingredientCategory' => $ingredientCategory
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
            return response::json(['status' => 200, 'data' => $category]);

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
            return response::json(['status' => 400, 'message' => 'Something went wrong.']);
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

            if($category){
                $category->name_en = $request->name_en;
                $category->name_nl = $request->name_nl;
                $category->save();
            }else{
                return response::json(['status' => 404, 'message' => 'No such category exist.']);
            }

            return response::json(['status' => 200, 'data' => $category]);
        } catch (Exception $e) {
            return response::json(['status' => 400, 'message' => 'Something went wrong.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            IngredientCategory::where('id', $id)->delete();
            return response::json(['status' => 1, 'message' => 'Category Deleted successfully']);
        } catch (Exception $e) {
            return response::json(['status' => 0, 'message' => 'Something went wrong.']);
        }
    }
}
