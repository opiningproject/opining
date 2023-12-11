<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Zipcode;
use App\Models\User;
use App\Models\Address;
use App\Models\RestaurantDetail;
use Auth;
use Response;

class AddressController extends Controller
{
    public function index()
    {
        
    }

    public function validateZipcode(Request $request)
    {
        $zipcode = Zipcode::select('id')->where('zipcode',$request->zipcode)->first();

        if($zipcode)
        {
            session(['zipcode' => $request->zipcode]);
            session(['house_no' => $request->house_no]);

            return response::json(['status' => 1, 'message' => ""]);
        }

        return response::json(['status' => 2, 'message' => "Currently, we are not delivering food to this location."]);
    }

    public function deleteAddress(string $id)
    {
        try {
            Address::where('id', $id)->delete();
        } catch (Exception $e) {
            return response::json(['status' => 0, 'message' => 'Something went wrong.']);
        }
    }
}
