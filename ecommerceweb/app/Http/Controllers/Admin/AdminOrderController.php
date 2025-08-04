<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminOrderController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->select('orders.*', 'users.name as user_name', 'users.email as user_email');

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('orders.status', $request->status);
        }

        // Search functionality
        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('orders.id', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('users.name', 'LIKE', '%' . $searchTerm . '%')
                  ->orWhere('users.email', 'LIKE', '%' . $searchTerm . '%');
            });
        }

        // Date filter
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('orders.created_at', '>=', $request->date_from);
        }
        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('orders.created_at', '<=', $request->date_to);
        }

        $orders = $query->orderBy('orders.created_at', 'desc')->paginate(20);

        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->select('orders.*', 'users.name as user_name', 'users.email as user_email')
            ->where('orders.id', $id)
            ->first();

        if (!$order) {
            abort(404);
        }

        $orderItems = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->where('order_items.order_id', $id)
            ->select('order_items.*', 'products.name as product_name', 'products.slug as product_slug', 'products.image_path as product_image')
            ->get();

        return view('admin.orders.show', compact('order', 'orderItems'));
    }

    public function edit($id)
    {
        $order = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->select('orders.*', 'users.name as user_name', 'users.email as user_email')
            ->where('orders.id', $id)
            ->first();

        if (!$order) {
            abort(404);
        }

        return view('admin.orders.edit', compact('order'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled'
        ]);

        $order = DB::table('orders')->where('id', $id)->first();
        
        if (!$order) {
            abort(404);
        }

        DB::table('orders')->where('id', $id)->update([
            'status' => $request->status,
            'updated_at' => now(),
        ]);

        return redirect()->route('admin.orders.index')->with('success', 'Order status updated successfully!');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled'
        ]);

        $order = DB::table('orders')->where('id', $id)->first();
        
        if (!$order) {
            abort(404);
        }

        DB::table('orders')->where('id', $id)->update([
            'status' => $request->status,
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Order status updated successfully!');
    }
}
