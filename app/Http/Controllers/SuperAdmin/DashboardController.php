<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RestaurantUser;

class DashboardController extends Controller
{
    public function dashboard(Request $request)
    {

        // Retrieve the search keyword, limit, and order from the request
        $search = $request->input('search');
        $limit = $request->input('limit', 10); // Default limit to 10 if not provided
        $order = $request->input('order', 'asc'); // Default order to 'asc'

        // Query the items, applying search and pagination
        $query = RestaurantUser::query();

        if ($search) {
            $query->where('user_name', 'like', '%' . $search . '%')
                ->orWhere('user_email', 'like', '%' . $search . '%')
                ->orWhere('restaurant_name', 'like', '%' . $search . '%');
        }

        // Apply ordering and pagination
        $customers = $query->orderBy('created_at', $order)
                        ->paginate($limit);

        return view('super-admin/dashboard', compact('customers'));
    }
}
