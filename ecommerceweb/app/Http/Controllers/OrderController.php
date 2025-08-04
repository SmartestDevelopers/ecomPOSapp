<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = DB::table('orders')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        $seoData = [
            'meta_title' => 'My Orders - ECommerce Store',
            'meta_description' => 'View your order history and track your purchases.',
            'canonical_url' => url('/orders'),
            'robots' => 'noindex,follow',
        ];

        return view('pages.orders', compact('orders', 'seoData'));
    }

    public function show($id)
    {
        $order = DB::table('orders')
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$order) {
            abort(404);
        }

        $orderItems = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->where('order_items.order_id', $id)
            ->select('order_items.*', 'products.name', 'products.slug', 'products.image_path')
            ->get();

        $seoData = [
            'meta_title' => 'Order #' . $order->id . ' - ECommerce Store',
            'meta_description' => 'View order details and tracking information.',
            'canonical_url' => url('/orders/' . $order->id),
            'robots' => 'noindex,follow',
        ];

        return view('pages.order', compact('order', 'orderItems', 'seoData'));
    }

    public function checkout()
    {
        $cart = session('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $cartItems = [];
        $total = 0;

        foreach ($cart as $id => $details) {
            $product = DB::table('products')->where('id', $id)->first();
            if ($product) {
                $cartItems[] = [
                    'id' => $id,
                    'product' => $product,
                    'quantity' => $details['quantity'],
                    'subtotal' => $product->price * $details['quantity']
                ];
                $total += $product->price * $details['quantity'];
            }
        }

        $seoData = [
            'meta_title' => 'Checkout - ECommerce Store',
            'meta_description' => 'Complete your purchase securely.',
            'canonical_url' => url('/checkout'),
            'robots' => 'noindex,follow',
        ];

        return view('pages.checkout', compact('cartItems', 'total', 'seoData'));
    }

    public function processCheckout(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required|string|max:500',
            'payment_method' => 'required|string',
        ]);

        $cart = session('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $total = 0;
        $orderItems = [];

        // Calculate total and prepare order items
        foreach ($cart as $id => $details) {
            $product = DB::table('products')->where('id', $id)->first();
            if ($product && $product->stock >= $details['quantity']) {
                $subtotal = $product->price * $details['quantity'];
                $total += $subtotal;
                $orderItems[] = [
                    'product_id' => $id,
                    'quantity' => $details['quantity'],
                    'price' => $product->price,
                ];
            } else {
                return redirect()->route('cart.index')
                    ->with('error', 'Some items in your cart are no longer available.');
            }
        }

        // Add shipping cost if total < 50
        if ($total < 50) {
            $total += 9.99;
        }

        // Create order
        $orderId = DB::table('orders')->insertGetId([
            'user_id' => Auth::id(),
            'status' => 'pending',
            'total_price' => $total,
            'shipping_address' => $request->shipping_address,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Create order items
        foreach ($orderItems as $item) {
            $item['order_id'] = $orderId;
            $item['created_at'] = now();
            $item['updated_at'] = now();
            DB::table('order_items')->insert($item);

            // Update product stock
            DB::table('products')
                ->where('id', $item['product_id'])
                ->decrement('stock', $item['quantity']);
        }

        // Clear cart
        session()->forget('cart');

        return redirect()->route('orders.show', $orderId)
            ->with('success', 'Order placed successfully! Order #' . $orderId);
    }
}
