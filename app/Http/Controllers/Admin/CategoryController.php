<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use PHPUnit\Exception;
use Response;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
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
            if($request->has('id')){
                $category = Category::find($request->id);
                $message = trans('rest.message.category_update_success');
            }else{
                $category = new Category();
                $message = trans('rest.message.category_add_success');
            }
            if($request->has('image')){
                if($request->has('id')){
                    $imageName = uploadImageToBucket($request, '/category', '');
                }else{
                    $imageName = uploadImageToBucket($request, '/category');
                }
                $category->image = $imageName;
            }

            if(empty($category->sort_order)) {
                $storedcategory = Category::orderBy('sort_order', 'desc')->first();
                $category->sort_order = $storedcategory->sort_order + 1;
            }

            $category->name_en = $request->name_en;
            $category->name_nl = $request->name_nl;
            $category->save();

            return response::json(['status' => 200, 'data' => $category, 'message' => $message]);
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
            $category = Category::find($id);

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

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            dd($request->all());
            $category = Category::find($id);
        } catch (Exception $e) {
            return response::json(['status' => 0, 'message' => trans('rest.message.went_wrong')]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            Category::find($id)->delete();

            return response::json(['status' => 1, 'message' => trans('rest.message.category_delete_success')]);

        } catch (Exception $e) {
            return response::json(['status' => 0, 'message' => trans('rest.message.went_wrong')]);
        }
    }

    public function checkDishCategory(string $id){
        try {
            $category = Category::has('dish')->find($id);
            if($category){
                return response::json(['status' => 400, 'data' => $category]);
            }else{
                return response::json(['status' => 200, 'data' => $category]);
            }

        } catch (Exception $e) {
            return response::json(['status' => 400, 'message' => $e->getMessage()]);
        }
    }

    function updateCategorySortOrder(Request $request) 
    {
        try {
            Category::whereId(request('movedId'))->update(['sort_order' => request('replacedSortOrder')]);
            Category::whereId(request('replacedId'))->update(['sort_order' => request('movedSortOrder')]);
    
            return response()->json(['status' => HttpFoundationResponse::HTTP_OK, 'message' => 'Category sort order has been changed.']);
        } catch (\Throwable $th) {
            return response()->json(['status' => 0, 'message' => 'Something went wrong.']);
        }
       
    }
}
