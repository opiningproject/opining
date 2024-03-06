<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Zipcode;
use App\Models\Address;
class AddressController extends Controller
{
    public function validateZipcode(Request $request)
    {
        $data = $request->all('zip_code');
        if(isEmpty($data) == 1)
        {
            return response()->json([
            'status' => '0',
            'message' => trans('api.something_wrong'),
            ], 200);
        }
        
        $zipcode = Zipcode::select('id')->where([
            ['zipcode',$request->zip_code],
            ['status' , '1']
        ])->first();

        if($zipcode->count())
        {
            return response()->json(['status' => 1, 'message' => "api.zipcode_is_valid"]);
        }

        return response()->json(['status' => 2, 'message' => "Currently, we are not delivering food to this location."]);
    }

    public function deleteAddress(string $id){

        $address= Address::where('id', $id)->delete();

        if($address)
        {
            return response()->json(['status' => 1, 'message' => "api.address_delete_sucess"]);
        }
        else{

            return response()->json(['status' => 0, 'message' => 'api.something_wrong']);
        }

    }
}
