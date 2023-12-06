<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Dish;
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
        $ingredientCategories = IngredientCategory::all();
        return view('admin.dish.create', ['categories' => $categories, 'ingredientCategories' => $ingredientCategories]);
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
        $dish = Dish::with('category','option')->find($id);
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
}
