<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
Use App\Models\User;
use App\Enums\UserType;
use Validator,Redirect,Response;
use App\Models\CMS;

class CMSController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        /*$this->lang = app()->getlocale();

        print_r($this->lang);
        exit();*/
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function privacyPolicy(Request $request)
    {
        $privacy_policy = CMS::where('type','privacy')->where('lang',app()->getlocale())->pluck('content')->first();

        return view('user.cms.privacy-policy', ['privacy_policy' => $privacy_policy]);
    }

    public function terms(Request $request)
    {
        $terms = CMS::where('type','terms')->where('lang',app()->getlocale())->pluck('content')->first();

        return view('user.cms.terms', ['terms' => $terms]);
    }
}
