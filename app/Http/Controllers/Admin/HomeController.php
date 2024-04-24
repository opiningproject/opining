<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Dish;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use DB;
use Carbon\Carbon;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $currentWeekStartDate = Carbon::now()->startOfWeek();
        $currentWeekEndDate = Carbon::now()->endOfWeek();
        $previousWeekStartDate = Carbon::now()->subWeek()->startOfWeek();
        $previousWeekEndDate = Carbon::now()->subWeek()->endOfWeek();

        $currentWeekCounts = OrderDetail::whereHas('dish')->select('dish_id', DB::raw('count(*) as total'))
            ->whereBetween('created_at', [$currentWeekStartDate, $currentWeekEndDate])
            ->groupBy('dish_id')
            ->orderByDesc('total')
            ->get()
            ->pluck('total', 'dish_id');

        // Query to get the counts of orders for each dish for the previous week
        $previousWeekCounts = OrderDetail::whereHas('dish')->select('dish_id', DB::raw('count(*) as total'))
            ->whereBetween('created_at', [$previousWeekStartDate, $previousWeekEndDate])
            ->groupBy('dish_id')
            ->orderByDesc('total')
            ->get()
            ->pluck('total', 'dish_id');

        // Calculate percentage increase for each dish
        $popularDishes = [];

        if(!empty($currentWeekCounts))
        {
            foreach ($currentWeekCounts as $dishId => $currentWeekCount) 
            {
                $previousWeekCount = $previousWeekCounts->get($dishId, 0);
                $percentageCalculation = ($currentWeekCount - $previousWeekCount) / ($previousWeekCount ?: 1) * 100;
                $popularDishes[$dishId] = ['percentage' => round($percentageCalculation, 2), 'total_orders' => $currentWeekCount];
            }
        }
        
        $categories = Category::orderBy('id', 'desc')->get();
        $dishes = Dish::orderBy('id', 'desc')->limit(5)->get();

        $orderDetailsQuery = OrderDetail::whereHas('dish')->select('dish_id', DB::raw('COUNT(*) as total_orders'))
                ->groupBy('dish_id')
                ->orderByDesc('total_orders');

        $bestSellerDishes = $orderDetailsQuery->get();
        //$popularDishes = clone $orderDetailsQuery->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get();

        return view('admin.home', ['categories' => $categories, 'dishes' => $dishes, 'popularDishes' => $popularDishes, 'bestSellerDishes' => $bestSellerDishes]);
    }
}
