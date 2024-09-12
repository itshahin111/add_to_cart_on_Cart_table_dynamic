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
        // Find the product by its ID or fail if not found
        $product = Product::findOrFail($productId);

        // Check if the product already exists in the cart
        $cart = Cart::where('product_id', $productId)->first();

        if ($cart) {
            // If it exists, increment the quantity
            $cart->quantity += 1;
            $cart->save();
        } else {
            // Otherwise, create a new cart item with quantity 1
            Cart::create([
                'product_id' => $productId,
                'quantity' => 1,
            ]);
        }

        // Calculate the total quantity of all items in the cart
        $totalQuantity = Cart::sum('quantity');

        // Return a JSON response with a success message, total quantity, and other data
        return response()->json([
            'message' => 'Product added to cart',
            'quantity' => $totalQuantity, // Include total quantity in response
            'html' => view('carts.cart-items', ['carts' => Cart::with('product')->get()])->render(),
            'totalPrice' => Cart::with('product')->get()->sum(fn($cart) => $cart->product->price * $cart->quantity),
        ]);
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