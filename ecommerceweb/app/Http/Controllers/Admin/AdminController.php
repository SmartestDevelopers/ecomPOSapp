<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        // Get dashboard statistics
        $stats = [
            'total_users' => DB::table('users')->count(),
            'total_customers' => DB::table('users')->where('role', 'customer')->count(),
            'total_products' => DB::table('products')->count(),
            'total_categories' => DB::table('categories')->count(),
            'total_orders' => DB::table('orders')->count(),
            'pending_orders' => DB::table('orders')->where('status', 'pending')->count(),
            'total_revenue' => DB::table('orders')->sum('total_price'),
            'low_stock_products' => DB::table('products')->where('stock', '<', 5)->count(),
            'recent_orders_count' => DB::table('orders')->where('created_at', '>=', now()->subDays(7))->count(),
        ];

        // Get recent orders
        $recentOrders = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->select('orders.*', 'users.name as user_name', 'users.email as user_email')
            ->orderBy('orders.created_at', 'desc')
            ->limit(10)
            ->get();

        // Get recent users
        $recentUsers = DB::table('users')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentOrders', 'recentUsers'));
    }

    public function users()
    {
        $users = DB::table('users')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.users', compact('users'));
    }

    public function updateUserRole(Request $request, $id)
    {
        $request->validate([
            'role' => 'required|in:admin,customer'
        ]);

        DB::table('users')
            ->where('id', $id)
            ->update(['role' => $request->role]);

        return redirect()->back()->with('success', 'User role updated successfully.');
    }

    public function messages()
    {
        try {
            // Check if contact_messages table exists
            $messages = DB::table('contact_messages')
                ->orderBy('created_at', 'desc')
                ->paginate(20);
        } catch (\Exception $e) {
            // Table doesn't exist, pass null
            $messages = null;
        }

        return view('admin.messages', compact('messages'));
    }

    public function customers(Request $request)
    {
        $query = DB::table('users')
            ->where('role', 'customer');

        // Search functionality
        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('email', 'LIKE', '%' . $searchTerm . '%');
            });
        }

        $customers = $query->orderBy('created_at', 'desc')->paginate(20);

        // Get customer order counts
        foreach($customers as $customer) {
            $customer->orders_count = DB::table('orders')
                ->where('user_id', $customer->id)
                ->count();
            
            $customer->total_spent = DB::table('orders')
                ->where('user_id', $customer->id)
                ->sum('total_price');
        }

        return view('admin.customers', compact('customers'));
    }

    public function customerOrders($id)
    {
        $customer = DB::table('users')->where('id', $id)->where('role', 'customer')->first();
        
        if (!$customer) {
            abort(404, 'Customer not found');
        }

        $orders = DB::table('orders')
            ->where('user_id', $id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.customer-orders', compact('customer', 'orders'));
    }
}
