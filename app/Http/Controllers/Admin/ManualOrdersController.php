<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\DelivererUser;
use App\Models\Dish;
use App\Models\DishOptionCategory;
use App\Models\Order;
use App\Models\TrackOrder;
use App\Models\User;
use App\Models\Zipcode;
use App\Notifications\Admin\DeliveryTypeUpdate;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Enums\OrderStatus;
use App\Enums\OrderType;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Str;
use Response;
use Mail;
use Carbon\Carbon;
use function React\Promise\all;

class ManualOrdersController extends Controller
{
    /**
     * @param Request $request
     * @param null $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function index(Request $request, $id = null)
    {
        $categories = Category::orderBy('sort_order', 'asc')->get();
        $category = '';

        if ($request->cat_id) {
            $dishes = Dish::with('favorite')->where('category_id', $request->cat_id);
            $category = Category::find($request->cat_id);
        } else if(!$request->all) {
            $category = Category::orderBy('sort_order', 'asc')->first();
            if(!empty($category)){
                $dishes = Dish::with('favorite')->where('category_id', $category->id);
            }else{
                $dishes = Dish::with('favorite');
            }

        }else{
            $dishes = Dish::with('favorite');
        }

        if(count($dishes->get()) > 0){
            $dishes = ($request->all) ? $dishes->get() : $dishes->get();
            // $dishes = ($request->all) ? $dishes->get() : $dishes->limit(12)->get();
        }else{
            $dishes = [];

        }
        return view('admin.manual-order.index', [
            'categories' => $categories,
            'dishes' => $dishes,
            'category' => $category,
            'cat_id' => $request->cat_id ?? '',
        ]);
    }

    function getDishes(Request $request, $cat_id)
    {
        if ($cat_id) {
            $category = Category::find($cat_id);
            $dishes = Dish::with(['favorite', 'category'])->where('category_id', $cat_id);
            $dishesHTML = view('admin.manual-order.dish.dish-list', ['dishes' => $dishes->get()])->render();
            return response()->json(['status' => 1, 'data' => $dishesHTML, 'cat_name' => $category->name]);

        }
    }
}
