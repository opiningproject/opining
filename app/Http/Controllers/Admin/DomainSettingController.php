<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use PHPUnit\Exception;
use Illuminate\Http\Request;
use Response;
use App\Models\Tenant;
use App\Models\Domain;

class DomainSettingController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function index() {

        $domains = Domain::with('tenant')->get();
        return view('admin.settings.domain-setting', compact('domains'));
    }

    public function create()
    {
        $tenants = Tenant::all();
        return view('admin.settings.domain.create', compact('tenants'));
    }

    public function store(Request $request)
    {
    /*     die('here'); */
        $request->validate([
            'domain' => 'required|string|max:255|unique:domains',
        ]);

        $tenant1 = Tenant::create(['id' => $request->domain]);
        $tenant1->domains()->create(['domain' => $request->domain]);
/*         $tenant1 = Tenant::create(['id' => 'foo']);
        $tenant1->domains()->create(['domain' => 'foo.localhost']); */

        /* Domain::create($request->all()); */
        return redirect()->route('settings');
        // return view('admin.settings.domain-setting');
    }
}
