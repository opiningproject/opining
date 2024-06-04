<?php

namespace App\Http\Controllers\User;

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
    public function index()
    {
        $user = User::find(Auth::user()->id);
       
        return view('user.settings.index', ['user' => $user]);
    }

    public function saveProfile(Request $request)
    {
        $user_id = Auth::user()->id;
        $reqParamsArr = $request->all();

        if ($request->has('image')) {
            $imageName = uploadImageToBucket($request, '/user');
            $reqParamsArr['image'] = $imageName;
        }

        User::updateOrCreate(
                ['id' => $user_id],
                $reqParamsArr
            );

        sleep(1);

        return redirect("user/settings");
    }
}
