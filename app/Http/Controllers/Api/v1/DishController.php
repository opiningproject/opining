<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dish;
use App\Models\DishFavorites;
use JWTAuth;
use Illuminate\Support\Facades\Auth;
class DishController extends Controller
{
    public function getDishes(Request $request)
    {
        $limit = config('params.page_limit');
        $offset = ($request->input('page_no') - 1) * $limit;
        $pageNo = !empty($request->input('page_no')) ? $request->input('page_no') : 1;

        $dishes = Dish::select("*");

        if(!empty($request->category_id)){

            $dishes=Dish::where('category_id',$request->category_id);
        }

        if($request->has('search'))
        {

            $dishes->where(function($query) use ($request){
                    $query->orwhere('name_en', 'like', '%' . $request->get('search') . '%')
                    ->orwhere('name_nl', 'like', '%' . $request->get('search') . '%');
            });
           
        }

        $dishes_count=$dishes->count();

        $dishes= $dishes->orderBy('id', 'DESC')->offset($offset)->limit($limit)->get();
       
       
        if(!$dishes->count())
        {
            return response()->json([
                'status' => '1',
                'message' => trans('api.no_data_found'),
            ], 200);
        }
        
        return response()->json([
            'status' => '1',
            'limit' => $limit,
            'is_data_available' => (($limit * $pageNo) >= $dishes_count) ? 0 : 1,
            'message' => trans('api.dishes_data'),
            'data' => [
                    'dishes_data' => $dishes
                ]
        ], 200);
    }

    public function favoriteUnfavorite(Request $request)
    {

        $user=JWTAuth::toUser($request->input('token'));
        if (!$user) {
            return response()->json(['status' => 2, 'message' => '']);
        }

        $data = $request->all('dish_id','is_favorite');

        if(isEmpty($data) == 1)
        {
            return response()->json([
            'status' => '0',
            'message' => trans('api.something_wrong'),
            ], 200);
        }

        $data['user_id'] = $user->id;

        $favorite=DishFavorites::where([
                ['dish_id',$data['dish_id']],
                ['user_id',$user->id],
                ])->first();

        $data['id']= !empty($favorite) ? $favorite->id : '';
        
        if($data['is_favorite'] == 1){
 
            $addFavorite=DishFavorites::updateOrCreate(
                ['id' => $data['id']],
                $data
            );

            return response()->json([
            'status' => '1',
            'message' => trans('api.sucess_added_to_favorite'),
            'data' => $addFavorite
                
        ], 200);

        }else if($data['is_favorite'] == 0){

            $removeFavorite=DishFavorites::where([['dish_id',$data['dish_id']],['user_id',$user->id]])->delete();

            return response()->json([
            'status' => '1',
            'message' => trans('api.sucess_remove_to_unfavorite')
            
                
            ], 200);
        }
        // if(!$favorite)
        // {
        //      return response()->json([
        //         'status' => '1',
        //         'message' => trans('api.no_data_found'),
        //     ], 200);
        // }

       
       
    }


    public function getFavouriteDishes(Request $request)
    {
        
        $user_id=Auth::user()->id;
        $limit = config('params.page_limit');
        $offset = ($request->input('page_no') - 1) * $limit;
        $pageNo = !empty($request->input('page_no')) ? $request->input('page_no') : 1;
        

        $dishes=DishFavorites::with('dish')->where('user_id',$user_id);

        $dishes_count = $dishes->count();

        $dishes = $dishes->offset($offset)->limit($limit)->get();

        if(!$dishes->count())
        {
            return response()->json([
            'status' => '0',
            'message' => trans('api.no_data_found'),
            ], 200);
        }

        return response()->json([
            'status' => '1',
            'limit' => $limit,
            'is_data_available' => (($limit * $pageNo) >= $dishes_count) ? 0 : 1,
            'message' => trans('api.favorite_dish_data'),
            'data' => $dishes
              
        ], 200);

    }

}
