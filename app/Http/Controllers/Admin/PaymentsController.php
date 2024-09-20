<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Dish;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Auth;
use App\Models\Order;
use DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class PaymentsController extends Controller
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

    public function index(Request $request)
    {
        $totalIncome = Order::select("*")->where('is_cart', '0')->sum('total_amount');
        $orderMonths = Order::select("orders.*", DB::raw("DATE_FORMAT(created_at,'%b') as month"), DB::raw("sum(total_amount) as totalAmount"))
                                ->where('is_cart', '0')
                                ->groupBy('month')
                                ->pluck('totalAmount','month')
                                ->toArray();

        $defaultMonths = collect(["Jan" => 0, "Feb" => 0, "Mar" => 0, "Apr" => 0, "May" => 0, "Jun" => 0, "Jul" => 0, "Aug" => 0, "Sep" => 0, "Oct" => 0, "Nov" => 0, "Dec" => 0]);

        $month_order_merge_array = $defaultMonths->merge($orderMonths);

        $m = 0;
        foreach ($month_order_merge_array as $key => $month_order)
        {
            $totalMonthOrders[$m]['label'] = ''.$key.'';
            $totalMonthOrders[$m]['value'] = $month_order;
            $m++;
        }

        $orderWeeks = Order::select("*", DB::raw("DATE_FORMAT(created_at,'%a') as week"), DB::raw("sum(total_amount) as totalAmount"))
                                ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                                ->where('is_cart', '0')->groupBy('week')
                                ->pluck('totalAmount','week')
                                ->toArray();

        $defaultWeeks = collect(["Sun" => 0, "Mon" => 0, "Tue" => 0, "Wed" => 0, "Thu" => 0, "Fri" => 0, "Sat" => 0]);

        $week_order_merge_array = $defaultWeeks->merge($orderWeeks);

        $w = 0;
        foreach ($week_order_merge_array as $key => $week_order)
        {
            $totalWeekOrders[$w]['label'] = ''.$key.'';
            $totalWeekOrders[$w]['value'] = $week_order;
            $w++;
        }

        $orderYear = Order::select(DB::raw("sum(total_amount) as totalAmount"), DB::raw("DATE_FORMAT(created_at,'%Y') as year"))
                                ->where('is_cart', '0')
                                ->groupBy('year')
                                ->orderBy('year', 'asc')
                                ->pluck('totalAmount','year')
                                ->toArray();

        $currentYear = date('Y') + 1;

        for ($i = 1; $i <= 2; $i++)
        {
            $previousYear[$currentYear - $i] = 0;
        }
        $year_order_merge_array = $orderYear + $previousYear;
        ksort($year_order_merge_array);

        $y = 0;
        foreach ($year_order_merge_array as $key => $year_order)
        {
            $totalYearOrders[$y]['label'] = ''.$key.'';
            $totalYearOrders[$y]['value'] = $year_order;
            $y++;
        }

        $yearlyOnlineChartData = $this->getIncomeChartData(Carbon::now()->startOfYear(),Carbon::now()->endOfYear());
        $monthlyOnlineChartData = $this->getIncomeChartData(Carbon::now()->startOfMonth(),Carbon::now()->endOfMonth());
        $weeklyOnlineChartData = $this->getIncomeChartData(Carbon::now()->startOfWeek(),Carbon::now()->endOfWeek());

        $weeklyLineChartData = $this->getLineChartData(1);
        $monthlyLineChartData = $this->getLineChartData(2);
        $yearlyLineChartData = $this->getLineChartData(3);

        /*echo "<pre>";
        print_r($monthlyLineChartData);
        exit;*/

        return view('admin.payments',
            [ 'totalMonthOrders' => $totalMonthOrders,
              'totalWeekOrders' => $totalWeekOrders,
              'totalYearOrders' => $totalYearOrders,
              'totalIncome' => $totalIncome,
              'yearlyDeliveryOnlineChartData' => $yearlyOnlineChartData['deliveryOnlineChartData'],
              'yearlyTAOnlineChartData' => $yearlyOnlineChartData['TAOnlineChartData'],

              'monthlyDeliveryOnlineChartData' => $monthlyOnlineChartData['deliveryOnlineChartData'],
              'monthlyTAOnlineChartData' => $monthlyOnlineChartData['TAOnlineChartData'],

              'weeklyDeliveryOnlineChartData' => $weeklyOnlineChartData['deliveryOnlineChartData'],
              'weeklyTAOnlineChartData' => $weeklyOnlineChartData['TAOnlineChartData'],

              'weeklyLineChartData' => $weeklyLineChartData,
              'monthlyLineChartData' => $monthlyLineChartData,
              'yearlyLineChartData' => $yearlyLineChartData
            ]);
    }

    function getLineChartData($time_frame)
    {
        if($time_frame == 1)
        {
             // For a week logic
            $defaultWeeks = collect(["Mon" => 0, "Tue" => 0, "Wed" => 0, "Thu" => 0, "Fri" => 0, "Sat" => 0, "Sun" => 0]);
            $chartDataArr['categories'] = [['category' => [['label' => 'Mon'],['label' => 'Tue'],['label' => 'Wed'],['label' => 'Thu'],['label' => 'Fri'],['label' => 'Sat'],['label' => 'Sun']]]];

            // Online delivery and take away income logic
            $orderWeeks = Order::select("*", DB::raw("DATE_FORMAT(created_at,'%a') as week"), DB::raw("sum(total_amount) as totalAmount"))
                                    ->whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])
                                    ->where('is_cart', '0')
                                    ->where('order_status', '6');

            $ordersQuery = clone $orderWeeks;
            $deliveryOrders = $ordersQuery->where('order_type','1')->groupBy('week')->pluck('totalAmount','week')->toArray();

            $ordersQuery = clone $orderWeeks;
            $TAOrders = $ordersQuery->where('order_type','2')->groupBy('week')->pluck('totalAmount','week')->toArray();

            $week_delivery_order_merge_array = $defaultWeeks->merge($deliveryOrders);
            $week_TA_order_merge_array = $defaultWeeks->merge($TAOrders);

            $w = 0;
            foreach ($week_delivery_order_merge_array as $key => $week_order)
            {
                $chartDataArr['dataset'][0]['data'][$w]['value'] = $week_order;
                $w++;
            }

            $w = 0;
            foreach ($week_TA_order_merge_array as $key => $week_order)
            {
                $chartDataArr['dataset'][1]['data'][$w]['value'] = $week_order;
                $w++;
            }
        }

        if($time_frame == 2)
        {
            // For a month logic
            $defaultMonths = collect(["Jan" => 0, "Feb" => 0, "Mar" => 0, "Apr" => 0, "May" => 0, "Jun" => 0, "Jul" => 0, "Aug" => 0, "Sep" => 0, "Oct" => 0, "Nov" => 0, "Dec" => 0]);
            $chartDataArr['categories'] = [['category' => [['label' => 'Jan'],['label' => 'Feb'],['label' => 'Mar'],['label' => 'Apr'],['label' => 'May'],['label' => 'Jun'],['label' => 'Jul'],['label' => 'Aug'],['label' => 'Sep'],['label' => 'Oct'],['label' => 'Nov'],['label' => 'Dec']]]];

            // Online delivery and take away income logic
           $orderMonths = Order::select("*", DB::raw("DATE_FORMAT(created_at,'%b') as month"), DB::raw("sum(total_amount) as totalAmount"))
                                    ->where('is_cart', '0')
                                    ->where('order_status', '6');

            $ordersQuery = clone $orderMonths;
            $deliveryOrders = $ordersQuery->where('order_type','1')->groupBy('month')->pluck('totalAmount','month')->toArray();

            $ordersQuery = clone $orderMonths;
            $TAOrders = $ordersQuery->where('order_type','2')->groupBy('month')->pluck('totalAmount','month')->toArray();

            $month_delivery_order_merge_array = $defaultMonths->merge($deliveryOrders);
            $month_TA_order_merge_array = $defaultMonths->merge($TAOrders);

            $w = 0;
            foreach ($month_delivery_order_merge_array as $key => $month_order)
            {
                $chartDataArr['dataset'][0]['data'][$w]['value'] = $month_order;
                $w++;
            }

            $w = 0;
            foreach ($month_TA_order_merge_array as $key => $month_order)
            {
                $chartDataArr['dataset'][1]['data'][$w]['value'] = $month_order;
                $w++;
            }
        }

        if($time_frame == 3)
        {
            // For a year logic

            $defaultYears = collect(['2023' => 0, '2024' => 0])->toArray();
            $chartDataArr['categories'] = [['category' => [['label' => '2023'],['label' => '2024']]]];

            // Online delivery and take away income logic
           $orderYears = Order::select("*", DB::raw("DATE_FORMAT(created_at,'%Y') as year"), DB::raw("sum(total_amount) as totalAmount"))
                                    ->whereBetween('created_at', [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()])
                                    ->where('is_cart', '0')
                                    ->where('order_status', '6');

            $ordersQuery = clone $orderYears;
            $deliveryOrders = $ordersQuery->where('order_type','1')->groupBy('year')->pluck('totalAmount','year')->toArray();

            $ordersQuery = clone $orderYears;
            $TAOrders = $ordersQuery->where('order_type','2')->groupBy('year')->pluck('totalAmount','year')->toArray();

            $year_delivery_order_merge_array = array_replace($defaultYears,$deliveryOrders);
            $year_TA_order_merge_array = array_replace($defaultYears,$TAOrders);

            $w = 0;
            foreach ($year_delivery_order_merge_array as $key => $year_order)
            {
                $chartDataArr['dataset'][0]['data'][$w]['value'] = $year_order;
                $w++;
            }

            $w = 0;
            foreach ($year_TA_order_merge_array as $key => $year_order)
            {
                $chartDataArr['dataset'][1]['data'][$w]['value'] = $year_order;
                $w++;
            }
        }

        return $chartDataArr;

    }

    function getIncomeChartData($start_date,$end_date)
    {
        // Online delivery and take away income logic
        $orders = Order::select('*')->where('is_cart', '0')->where('order_status', '6')
                        ->whereBetween('created_at', [$start_date, $end_date]);

        $ordersQuery = clone $orders;

        // Yearly Delivery Orders
        $deliveryOrders = $orders->where('order_type', '1')->count();
        $deliveryOnlineOrders = $orders->where('order_type', '1')->where('transaction_id','<>',NULL)->count();

        $deliveryOnlinePer = 0;
        $deliveryCODPer = 0;

        if($deliveryOrders)
        {
            $deliveryCODOrders = $deliveryOrders - $deliveryOnlineOrders;
            $deliveryCODPer = ($deliveryCODOrders / $deliveryOrders)*100;
            $deliveryOnlinePer = 100 - $deliveryCODPer;
        }

        $deliveryOnlineChartData = [0 => ["value" => $deliveryOnlinePer], 1 => ["value" => $deliveryCODPer]];

        // Yearly Take Away Orders
        $TAOrders = $ordersQuery->where('order_type','2')->count();
        $TAOnlineOrders = $ordersQuery->where('order_type','2')->where('transaction_id','<>',NULL)->count();

        $TACODPer = 0;
        $TAOnlinePer = 0;

        if($TAOrders)
        {
            $TACODOrders = $TAOrders - $TAOnlineOrders;
            $TACODPer = ($TACODOrders / $TAOrders)*100;
            $TAOnlinePer = 100 - $TACODPer;
        }

        $TAOnlineChartData = [0 => ["value" => $TAOnlinePer], 1 => ["value" => $TACODPer]];

        $onlineChartData['deliveryOnlineChartData'] = $deliveryOnlineChartData;
        $onlineChartData['TAOnlineChartData'] = $TAOnlineChartData;

        return $onlineChartData;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function validateMyFinance(Request $request)
    {
        if (Session::get('myFinanceIsValidate') == 1) {
            return redirect('payments');
        }
        return view('admin.validate-my-finance');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Http\RedirectResponse
     */
    public function checkMyFinancePassword(Request $request)
    {
        if (Hash::check($request->password, auth()->user()->password)) {
            Session::put(['myFinanceIsValidate'=>"1"]);
            return redirect('payments');
        }
        return Redirect::back()->withErrors(['msg' => 'Please enter valid password.']);
    }
}
