<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DishFavorites;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
Use App\Models\User;
Use App\Models\Order;
Use App\Models\OrderDetail;
Use App\Models\Dish;
use Validator,Redirect,Response;

class CartController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
//        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //return view('user.home');
    }

    public function removeToCart(Request $request)
    {
        try {
            DishFavorites::where('dish_id', $request->dish_id)->delete();
        } catch (Exception $e) {
            return response::json(['status' => 0, 'message' => 'Something went wrong.']);
        }
    }

    public function addToCart(Request $request)
    {
        if(!Auth::user())
        {
            return response::json(['status' => 2, 'message' => '']);
        }

        try 
        {
            $user_id = Auth::user()->id;
            $order = Order::where('user_id',$user_id)->where('is_cart','1')->first();

            if(!empty($order))
            {
                $order->is_cart = '1';
            }
            else
            {
                $order = new Order();
                $order->user_id = $user_id;
                $order->is_cart = '1';
            }

            if($order->save())
            {
                $dish = Dish::find($request->id); 

                $cartArr = [
                    "user_id"=>$user_id,
                    "order_id"=>$order->id,
                    "dish_id"=>$request->id,
                    "price"=>$dish->price,
                    "qty"=>1,
                    "total_price"=>$dish->price,
                    "notes"=>'',
                ];

                OrderDetail::create(      
                    $cartArr
                );
            }

            return response::json(['status' => 1, 'message' => '']);
        } 
        catch (Exception $e) 
        {
            return response::json(['status' => 0, 'message' => 'Something went wrong.']);
        }
    }
}
