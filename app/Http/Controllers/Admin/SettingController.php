<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Zipcode;
use App\Models\CMS;
use App\Models\User;
use App\Models\RestaurantDetail;
use App\Models\OperatingHour;
use Auth;
use Hash;
use Response;

class SettingController extends Controller
{
    public function index(Request $request)
    {
        $perPage = isset($request->per_page) ? $request->per_page : 10;
        $zipcodes = $this->getZipcode($perPage);

        $privacy_policy_en = CMS::where('type','privacy')->where('lang','en')->pluck('content')->first();
        $terms_en = CMS::where('type','terms')->where('lang','en')->pluck('content')->first();

        $privacy_policy_nl = CMS::where('type','privacy')->where('lang','nl')->pluck('content')->first();
        $terms_nl = CMS::where('type','terms')->where('lang','nl')->pluck('content')->first();

        $user = RestaurantDetail::where('user_id',Auth::user()->id)->firstOrFail();
        $operating_days = OperatingHour::all();

        return view('admin.settings.index', [
            'operating_days' => $operating_days,
            'user' => $user,
            'zipcodes' => $zipcodes,
            'privacy_policy_en' => $privacy_policy_en,
            'terms_en' => $terms_en,
            'privacy_policy_nl' => $privacy_policy_nl,
            'terms_nl' => $terms_nl,
            'perPage' => $perPage
        ]);
    }

    public function getZipcode($perPage)
    {
        $zipcodes = Zipcode::orderBy('id', 'desc')->paginate($perPage);

        return $zipcodes;
    }

    public function deleteZipcode(Request $request)
    {
        try {
            Zipcode::where('id', $request->id)->delete();
        } catch (Exception $e) {
            return response::json(['status' => 0, 'message' => 'Something went wrong.']);
        }
    }

    public function changeStatus(Request $request)
    {
        try {
            $zipcode = Zipcode::find($request->id);
            $zipcode->status = $request->status;
            $zipcode->save();
        } catch (Exception $e) {
            return response::json(['status' => 0, 'message' => 'Something went wrong.']);
        }
    }

    public function saveZipcode(Request $request)
    {
        /*print_r ($request->all());
        exit();*/

        try
        {

            $result = Zipcode::updateOrCreate(
                ['id' => $request->id],
                $request->all()
            );

            if($request->id == 0)
            {

                $id = $result->id;
                $zipcode = "zipcode_".$id;
                $min_order_price = "min_order_price_".$id;
                $delivery_charge = "delivery_charge_".$id;
                $status = "status_".$id;
                $is_active = $request->status ? 'checked':'';

                echo "<tr class=zipcode-row-$id>
                    <td>
                      <input type='text' class='form-control text-center w-10r m-auto' value=".$request->zipcode." id=".$zipcode." readonly />
                    </td>
                    <td class='text-center'>
                      <div class='input-group w-5r m-auto'>
                        <span class='input-group-text' id='basic-addon1'>€</span>
                        <input type='number' class='form-control m-auto' value=".$request->min_order_price." id=".$min_order_price." readonly />
                      </div>
                    </td>
                    <td class='text-center'>
                      <div class='input-group w-5r m-auto'>
                        <span class='input-group-text' id='basic-addon1'>€</span>
                        <input type='number' class='form-control m-auto' value=".$request->delivery_charge." id=".$delivery_charge." readonly />
                      </div>
                    </td>
                    <td class='text-center'>
                      <div class='form-check form-switch custom-switch justify-content-center ps-0'>
                        <input class='form-check-input' type='checkbox' role='switch' id=".$status." onchange='changeStatus($id)' $is_active>
                      </div>
                    </td>
                    <td class='text-center'>
                      <a class='btn btn-custom-yellow btn-icon me-2' tabindex='0' href='javascript:void(0);' id='zipcode-edit-btn-$id' onclick='editZipcode($id)'>
                        <i class='fa-solid fa-pen-to-square'></i>
                      </a>
                      <a class='btn btn-custom-yellow btn-icon' id='zipcode-remove-btn-$id' onclick='deleteZipcode($id)'>
                        <i class='fa-regular fa-trash-can'></i>
                      </a>

                      <button type='button' class='btn btn-custom-yellow text-uppercase font-sebibold w-100' id='zipcode-save-btn-$id' style='display: none;' onclick='saveZipcode($id)'>Save</button>
                    </td>
                  </tr>";

                  exit;
            }
        }
        catch (Exception $e)
        {
            return response::json(['status' => 0, 'message' => 'Something went wrong.']);
        }
    }

    public function saveContent(Request $request)
    {
        $content = CMS::where('type',$request->type)->where('lang',$request->lang)->first();
        $content->content = $request->content;
        $content->save();
        exit;
    }

    public function changePassword(Request $request)
    {
        $user = User::findOrFail(Auth::user()->id);

        if(!Hash::check($request->old_password, $user->password))
        {
            echo 2;
            exit;
        }

        $user->password = Hash::make($request->new_password);

        if($user->save())
        {
            echo 1;
            exit;
        }
        else
        {
            return response::json(
                [
                    'status' => 0,
                    'message' => 'Something went wrong.'
                ]
            );
        }
    }

    public function saveProfile(Request $request)
    {
        $user_id = Auth::user()->id;

        $request->merge([
            'online_order_accept' => $request->online_order_accept ? '1' : '0',
        ]);
        $request->request->remove('_token');

        RestaurantDetail::updateOrCreate(
                ['user_id' => $user_id],
                $request->all()
            );

        foreach ($request->id as $key => $timeId){
            $day = OperatingHour::find($timeId);
            $day->start_time = $request->start_time[$key];
            $day->end_time = $request->end_time[$key];
            $day->save();
        }


        return redirect("/settings");
    }
}
