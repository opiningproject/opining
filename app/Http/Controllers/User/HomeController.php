<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Dish;
use App\Models\Address;
use App\Models\OrderDetail;
use Auth;
use Session;

class HomeController extends Controller
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
        return view('user.home');
    }

    public function dashboard(Request $request)
    {
        $couponCode = '';
        $couponDiscount = 0;
        $couponPercent = 0;

        $categories = Category::orderBy('sort_order', 'asc')->get();

        $user = (Auth::user()) ? Auth::user() : '';
        $user_id = $user ? $user->id : 0;
        $addresses = Address::select('*')->orderBy('company_name', 'asc')->where('user_id', $user_id)->get();
        $cart = OrderDetail::select('*')->orderBy('id', 'desc')->where([
            ['user_id', $user_id],
            ['is_cart', '1']
        ])->get();
        $category = '';

        if ($request->cat_id) {
            $dishes = Dish::with('favorite')->where('category_id', $request->cat_id);
            $category = Category::find($request->cat_id);
        } else if(!$request->all) {
            $category = Category::orderBy('sort_order', 'asc')->first();
            if(!empty($category)){
                $dishes = Dish::with('favorite')->where('category_id', $category->id);
            }else{
                $dishes = Dish::with('favorite')->get();
            }

        }else{
            $dishes = Dish::with('favorite');
        }

        if(count($dishes->get()) > 0){
            $dishes = ($request->all) ? $dishes->get() : $dishes->limit(12)->get();
        }else{
            $dishes = [];

        }

        $serviceCharge = getRestaurantDetail()->service_charge;

        if ($user) {
            if (isset($user->cart)) {
                $couponCode = $user->cart->coupon_code;
                $couponDiscount = $user->cart->coupon_discount;
                if ($user->cart->coupon)
                    $couponPercent = $user->cart->coupon->percentage_off/100;
            }
        }

        return view('user.dashboard', [
            'categories' => $categories,
            'category' => $category,
            'dishes' => $dishes,
            'addresses' => $addresses,
            'user' => $user,
            'cart' => $cart,
            'serviceCharge' => $serviceCharge,
            'couponCode' => $couponCode,
            'couponDiscount' => $couponDiscount,
            'couponDiscountPercent' => $couponPercent,
            'cat_id' => $request->cat_id ?? ''
        ]);
    }
}
