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

class DeliverersController extends Controller
{
    /**
     * @param Request $request
     * @param null $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function index(Request $request, $id = null)
    {
        $perPage = isset($request->per_page) ? $request->per_page : 10;
        $delivererUser = DelivererUser::orderBy('id', 'desc')->paginate($perPage);
        return view('admin.deliverers.index',['delivererUser' => $delivererUser,  'perPage' => $perPage]);
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function store(Request $request)
    {
        $deliverer = DelivererUser::create(
            $request->all()
        );

        return response::json(['status' => 200, 'data' => $deliverer, 'message' => trans('rest.message.deliverer_add_success')]);
    }

    /**
     * @param Request $request
     * @param string $id
     * @return mixed
     */
    public function update(Request $request, string $id)
    {
        try {
            $delivererUser = DelivererUser::find($id);

            if($delivererUser)
            {
                $delivererUser->first_name = $request->first_name;
                $delivererUser->last_name = $request->last_name;
                $delivererUser->phone = $request->phone;
                $delivererUser->email = $request->email;
                $delivererUser->save();

                return response::json(['status' => 200, 'message' => trans('rest.message.deliverer_update_success')]);
            }
            else
            {
                return response::json(['status' => 404, 'message' => trans('rest.message.went_wrong')]);
            }

            return response::json(['status' => 200, 'data' => $category]);
        }
        catch (\PHPUnit\Exception $e)
        {
            return response::json(['status' => 400, 'message' => trans('rest.message.went_wrong')]);
        }
    }

    /**
     * @param string $id
     * @return mixed
     */
    public function destroy(string $id)
    {
        try {
            DelivererUser::where('id', $id)->delete();
            return response::json(['status' => 1, 'message' => trans('rest.message.deliverer_delete_success')]);
        } catch (\PHPUnit\Exception $e) {
            return response::json(['status' => 0, 'message' => trans('rest.message.went_wrong')]);
        }
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function changeStatus(Request $request)
    {
        try {
            $deliverer = DelivererUser::find($request->id);
            $deliverer->status = $request->status;
            $deliverer->save();

            return response::json(['status' => 1, 'message' => trans('rest.message.deliverer_status_success')]);

        } catch (Exception $e) {
            return response::json(['status' => 0, 'message' => trans('rest.message.went_wrong')]);
        }
    }
}
