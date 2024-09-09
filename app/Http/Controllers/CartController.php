<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $carts = Cart::with('product')->get();
        $totalPrice = $carts->sum(function ($cart) {
            return $cart->product->price * $cart->quantity;
        });

        return view('carts.index', compact('carts', 'totalPrice'));
    }
    public function TotalItems()
    {
        $products = Product::all();
        return $products->count();

    }

    public function add($productId)
    {
        $product = Product::findOrFail($productId);

        $cart = Cart::where('product_id', $productId)->first();
        if ($cart) {
            $cart->quantity += 1;
            $cart->save();
        } else {
            Cart::create([
                'product_id' => $productId,
                'quantity' => 1,
            ]);
        }

        return response()->json(['message' => 'Product added to cart', 'html' => view('carts.cart-items', ['carts' => Cart::with('product')->get()])->render(), 'totalPrice' => Cart::with('product')->get()->sum(fn($cart) => $cart->product->price * $cart->quantity)]);
    }

    public function increment($cartId)
    {
        $cart = Cart::findOrFail($cartId);
        $cart->quantity += 1;
        $cart->save();

        return response()->json(['html' => view('carts.cart-items', ['carts' => Cart::with('product')->get()])->render(), 'totalPrice' => Cart::with('product')->get()->sum(fn($cart) => $cart->product->price * $cart->quantity)]);
    }

    public function decrement($cartId)
    {
        $cart = Cart::findOrFail($cartId);
        if ($cart->quantity > 1) {
            $cart->quantity -= 1;
            $cart->save();
        }

        return response()->json(['html' => view('carts.cart-items', ['carts' => Cart::with('product')->get()])->render(), 'totalPrice' => Cart::with('product')->get()->sum(fn($cart) => $cart->product->price * $cart->quantity)]);
    }

    public function remove($cartId)
    {
        $cart = Cart::findOrFail($cartId);
        $cart->delete();

        return response()->json(['html' => view('carts.cart-items', ['carts' => Cart::with('product')->get()])->render(), 'totalPrice' => Cart::with('product')->get()->sum(fn($cart) => $cart->product->price * $cart->quantity)]);
    }

}