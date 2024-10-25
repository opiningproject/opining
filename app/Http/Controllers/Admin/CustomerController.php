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

class CustomerController extends Controller
{
    /**
     * @param Request $request
     * @param null $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function index(Request $request, $id = null)
    {
        return view('admin.customer.index');
    }
}
