<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
    public function index()
    {
        $ingredientCategory = IngredientCategory::all();

        $ingredients = Ingredient::with('dishIngredient.dish')->get();

        return view('admin.ingredients.index', [
            'ingredientCategory' => $ingredientCategory,
            'ingredients' => $ingredients
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
                $imageName = uploadImageToBucket($request, 'ingredients');
                $request->merge(['image' => $imageName]);
            }

            Ingredient::create(
                $request->all()
            );

            return redirect()->back();
        } catch (Exception $e) {
            return response::json(['status' => 0, 'message' => 'Something went wrong.']);
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
            return response::json(['status' => 0, 'message' => 'Something went wrong.']);
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
                $ingredient->update(
                    $request->all()
                );
            }else{
                return response::json(['status' => 0, 'message' => 'No such ingredient exist']);
            }
            return response::json(['status' => 1, 'data' => $ingredient]);
        } catch (Exception $e) {
            return response::json(['status' => 0, 'message' => 'Something went wrong.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Ingredient::find($id)->delete();
        } catch (Exception $e) {
            return response::json(['status' => 0, 'message' => 'Something went wrong.']);
        }
    }

    public function updateIngredientStatus(Request $request, string $id)
    {
        try {
            $ingredient = Ingredient::find($id);
            if ($ingredient) {
                $ingredient->status = $request->status;
                $ingredient->save();
                return response::json(['status' => 1, 'data' => $ingredient]);
            } else {
                return response::json(['status' => 0, 'message' => 'No such ingredient exist']);
            }

        } catch (Exception $e) {
            return response::json(['status' => 0, 'message' => 'Something went wrong.']);
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
}
