<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Dish;
use Illuminate\Http\Request;

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
    public function index(Request $request)
    {
        $categories = Category::all();
        $dishes = Dish::orderBy('id');

        if($request->has('search')){
            if(app()->getLocale() == 'en'){
                $dishes->orWhere('name_en', 'like', '%'.$request->search.'%');
            }else{
                $dishes->orWhere('name_nl', 'like', '%'.$request->search.'%');
            }
        }

        return view('admin.home',['categories' => $categories, 'dishes' => $dishes->get()]);
    }
}
