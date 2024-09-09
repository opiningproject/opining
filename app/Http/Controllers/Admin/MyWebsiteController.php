<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Auth;
use Hash;
use PHPUnit\Exception;
use Response;

class MyWebsiteController extends Controller
{

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function index(Request $request)
    {
        $perPage = isset($request->per_page) ? $request->per_page : 10;
        $ingredients = Banner::orderBy('sort_order', 'asc')->paginate($perPage);
        return view('admin.my-website.index', [
            'bannersData' => $ingredients,
            'perPage' => $perPage
        ]);
    }
}
