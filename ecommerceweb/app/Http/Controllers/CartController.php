<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
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
            'meta_title' => 'Shopping Cart - ECommerce Store',
            'meta_description' => 'Review your items and proceed to checkout.',
            'canonical_url' => url('/cart'),
            'robots' => 'noindex,follow',
        ];

        return view('pages.cart', compact('cartItems', 'total', 'seoData'));
    }

    public function add(Request $request, $id)
    {
        $product = DB::table('products')->where('id', $id)->first();
        
        if (!$product) {
            return redirect()->back()->with('error', 'Product not found.');
        }

        if ($product->stock < 1) {
            return redirect()->back()->with('error', 'Product is out of stock.');
        }

        $quantity = $request->input('quantity', 1);
        $cart = session('cart', []);

        if (isset($cart[$id])) {
            $newQuantity = $cart[$id]['quantity'] + $quantity;
            if ($newQuantity > $product->stock) {
                return redirect()->back()->with('error', 'Not enough stock available.');
            }
            $cart[$id]['quantity'] = $newQuantity;
        } else {
            if ($quantity > $product->stock) {
                return redirect()->back()->with('error', 'Not enough stock available.');
            }
            $cart[$id] = [
                'quantity' => $quantity,
                'price' => $product->price
            ];
        }

        session(['cart' => $cart]);
        return redirect()->back()->with('success', 'Product added to cart successfully.');
    }

    public function update(Request $request, $id)
    {
        $cart = session('cart', []);
        $quantity = $request->input('quantity', 1);

        if (isset($cart[$id])) {
            $product = DB::table('products')->where('id', $id)->first();
            if ($quantity > $product->stock) {
                return redirect()->back()->with('error', 'Not enough stock available.');
            }
            $cart[$id]['quantity'] = $quantity;
            session(['cart' => $cart]);
            return redirect()->back()->with('success', 'Cart updated successfully.');
        }

        return redirect()->back()->with('error', 'Item not found in cart.');
    }

    public function remove($id)
    {
        $cart = session('cart', []);
        
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session(['cart' => $cart]);
            return redirect()->back()->with('success', 'Item removed from cart.');
        }

        return redirect()->back()->with('error', 'Item not found in cart.');
    }

    public function clear()
    {
        session()->forget('cart');
        return redirect()->back()->with('success', 'Cart cleared successfully.');
    }
}
