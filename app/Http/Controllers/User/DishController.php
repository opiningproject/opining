<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\DishFavorites;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
Use App\Models\User;

class DishController extends Controller
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

    public function getFavoriteDishes()
    {
        $dishes = DishFavorites::with('dish')->where('user_id',Auth::user()->id)->get();

        return view('user.favorite',['dishes' => $dishes]);
    }

    public function unFavorite(Request $request)
    {
        try {
            DishFavorites::where('id', $request->id)->delete();
        } catch (Exception $e) {
            return response::json(['status' => 0, 'message' => 'Something went wrong.']);
        }
    }

    public function getCollectedPoints()
    {
        return view('user.points');
    }
}
