<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use App\Models\Zipcode;
use App\Models\User;
use App\Models\Address;
use App\Models\RestaurantDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Response;

class AddressController extends Controller
{
    public function index()
    {

    }

    public function validateZipcode(Request $request)
    {
        $zip =substr($request->zipcode, 0, 4);
        $zipcode = Zipcode::whereRaw("LEFT(zipcode,4) = $zip")->where('status','1')->first();

        if($zipcode)
        {
            session()->forget('address');
            session(['zipcode' => $request->zipcode]);
            session(['house_no' => $request->house_no]);

            return response::json(['status' => 1, 'message' => ""]);
        }

        return response::json(['status' => 2, 'message' => "Delivery is not possible for this zipcode"]);
    }

    public function deleteAddress(string $id)
    {
        try {
            Address::where('id', $id)->delete();
        } catch (Exception $e) {
            return response::json(['status' => 0, 'message' => 'Something went wrong.']);
        }
    }

    public function validateSelectedAddress(string $id){
        try{
            $address = Address::find($id);

            $zip =substr($address->zipcode, 0, 4);
            $zipcode = Zipcode::whereRaw("LEFT(zipcode,4) = $zip")->where('status','1')->first();

            $response['zipcode'] = $address->zipcode;
            $response['house_no'] = $address->house_no;

            if($zipcode){

                session(['zipcode'=> $address->zipcode]);
                session(['house_no'=> $address->house_no]);
                session(['address' => $id]);
                $response['message'] = 'Successfully validated';

                return response::json(['status' => 200, 'data' => $response]);
            }else{
                $response['message'] = 'Currently, we are not delivering food to this location.';
                return response::json(['status' => 406, 'data' => $response]);
            }

        }catch (Exception $e){
            return response::json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }

    public function takeawayPhone(Request $request){
        try {
            session(['phone_no'=> $request->phone_no]);
            return response::json(['status' => 200, 'data' => 'Phone number stored']);
        }catch (Exception $e){
            return response::json(['status' => 500, 'message' => $e->getMessage()]);
        }
    }
}
