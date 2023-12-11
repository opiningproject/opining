<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Dish;
use App\Models\Address;
use Auth;

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
        $categories = Category::all();
        $dishes = Dish::with('favorite');
        $user = (Auth::user()) ? Auth::user() : '';
        $user_id = $user ? $user->id : 0;

        $addresses = Address::select('*')->orderBy('company_name', 'asc')->where('user_id',$user_id)->get();

        $dishes = ($request->all) ? $dishes->get() : $dishes->limit(12)->get();

        return view('user.dashboard',['categories' => $categories, 'dishes' => $dishes, 'addresses' => $addresses, 'user' => $user]);
    }
}
