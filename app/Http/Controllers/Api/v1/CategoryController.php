<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use JWTAuth;
class CategoryController extends Controller
{
    public function getCategories(Request $request)
    {
        $categories = Category::select("*");
       
        if($request->has('search'))
        {
            $categories->where(function($query) use ($request){
                    $query->orwhere('name_en', 'like', '%' . $request->get('search') . '%')
                    ->orwhere('name_nl', 'like', '%' . $request->get('search') . '%');
            });
        }

        $categories = $categories->orderBy('id', 'DESC')->get();
        
        if(!$categories->count())
        {
            return response()->json([
                'status' => '1',
                'message' => trans('api.no_data_found'),
            ], 200);
        }

        return response()->json([
            'status' => '1',
            'message' => trans('api.categories_data'),
            'data' => [
                    'categories_data' => $categories
                ]
        ], 200);
    }
}
