<?php

namespace App\Http\Controllers\Admin;

use App\Enums\UserType;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Dish;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\User;
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
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function dashboard(Request $request) {
        $startDate = Carbon::today();
//        $totalUser = User::where('created_at', '>=', $startDate)->count();
        $totalUser = User::where('user_role', UserType::User)->count();
        $newUsers = User::where('created_at', '>=', $startDate)->count();
        $totalOrders = Order::where('created_at', '>=', $startDate)->count();
        return view('admin.dashboard',['totalUser' => $totalUser, 'totalOrders' => $totalOrders, 'newUsers' => $newUsers]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDashboardStatistics(Request $request) {
        $dateRange = $request->input('date_range');

        switch($dateRange) {
            case 'Today':
                $startDate = Carbon::today();
                break;
            case 'Yesterday':
                $startDate = Carbon::yesterday();
                break;
            case 'Last 7 days':
                $startDate = Carbon::today()->subDays(6); // Includes today
                break;
            case 'Last 30 days':
                $startDate = Carbon::today()->subDays(29); // Includes today
                break;
            default:
                $startDate = null;
        }

        // Query users and orders based on the start date
        if ($startDate) {
            $totalUser = User::where('user_role', UserType::User)->whereDate('created_at', $startDate)->count();
            $totalOrders = Order::whereDate('created_at', $startDate)->count();
            $newUsers = user::where('user_role', UserType::User)->whereDate('created_at',$startDate)->count();

        } else {
            $totalUser = User::where('user_role', UserType::User)->count();
            $newUsers = User::where('user_role', UserType::User)->count();
            $totalOrders = Order::count();
        }
        return response()->json([
            'totalUser' => $totalUser,
            'totalOrders' => $totalOrders,
            'newUsers' => $newUsers
        ]);
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

        $currentWeekCounts = OrderDetail::whereHas('dishWithoutTrash')->select('dish_id', DB::raw('count(*) as total'))
            ->whereBetween('created_at', [$currentWeekStartDate, $currentWeekEndDate])
            ->groupBy('dish_id')
            ->orderByDesc('total')
            ->get()
            ->pluck('total', 'dish_id');

        // Query to get the counts of orders for each dish for the previous week
        $previousWeekCounts = OrderDetail::whereHas('dishWithoutTrash')->select('dish_id', DB::raw('count(*) as total'))
            ->whereBetween('created_at', [$previousWeekStartDate, $previousWeekEndDate])
            ->groupBy('dish_id')
            ->orderByDesc('total')
            ->get()
            ->pluck('total', 'dish_id');

        // Calculate percentage increase for each dish
        $popularDishes = [];

        if (!empty($currentWeekCounts)) {
            foreach ($currentWeekCounts as $dishId => $currentWeekCount) {
                $previousWeekCount = $previousWeekCounts->get($dishId, 0);
                $percentageCalculation = ($currentWeekCount - $previousWeekCount) / ($previousWeekCount ?: 1) * 100;
                $popularDishes[$dishId] = ['percentage' => round($percentageCalculation, 2), 'total_orders' => $currentWeekCount];
            }
        }

        $categories = Category::orderBy('sort_order', 'asc')->get();
        $dishes = Dish::orderBy('id', 'desc');

        if (isset($request->cat_id)) {
            $dishes = $dishes->whereCategoryId($request->cat_id)->get();
        } else {
            if(!empty($categories) && count($categories) > 0){
                $dishes = $dishes->whereCategoryId($categories[0]->id)->get();
            }else{
                $dishes = $dishes->get();
            }
        }

        $orderDetailsQuery = OrderDetail::whereHas('dishWithoutTrash')->select('dish_id', DB::raw('COUNT(*) as total_orders'))
            ->groupBy('dish_id')
            ->orderByDesc('total_orders');

        $bestSellerDishes = $orderDetailsQuery->get();
        //$popularDishes = clone $orderDetailsQuery->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->get();

        return view('admin.home', ['categories' => $categories, 'dishes' => $dishes, 'popularDishes' => $popularDishes, 'bestSellerDishes' => $bestSellerDishes]);
    }
}
