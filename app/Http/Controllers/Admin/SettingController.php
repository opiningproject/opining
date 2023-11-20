<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Zipcode;

class SettingController extends Controller
{
    public function index()
    {
        $zipcodes = $this->getZipcode();

        return view('admin.settings.index', ['zipcodes' => $zipcodes]);
    }

    public function getZipcode()
    {
        $zipcodes = Zipcode::orderBy('id', 'desc')->get();

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

        try {
            Zipcode::updateOrCreate(
                ['id' => $request->id],
                $request->all()
            );
        } catch (Exception $e) {
            return response::json(['status' => 0, 'message' => 'Something went wrong.']);
        }
    }
}
