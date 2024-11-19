<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Models\Cart;
use App\Models\MainCategory;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{

    public function index(Request $request)
    {
        if ($request->has('redirect_to')) {
            session(['url.intended' => $request->input('redirect_to')]);
        }

        $mainCategory = MainCategory::with('subcategories')->get();
        if (auth()->check()) {
            $countWishList = Wishlist::where('user_id', auth()->user()->id)->count();
            $countCarts = Cart::where('user_id', auth()->user()->id)->count();
            $cart = Cart::join('products', 'products.id', '=', 'carts.product_id')
                ->join('product_size_prices', 'product_size_prices.id', '=', 'carts.product_size_price_id')
                ->join('sizes', 'sizes.id', '=', 'product_size_prices.size_id')
                ->select('products.id', 'products.product_name', 'products.slug', 'product_size_prices.price', 'sizes.size', 'carts.quantity', 'carts.id as cartid', 'carts.user_id')
                ->groupBy('cartid', 'products.id', 'products.product_name', 'products.slug', 'product_size_prices.price', 'sizes.size', 'carts.quantity', 'carts.user_id')
                ->where('carts.user_id', auth()->user()->id)->get();
            $productId = $cart->pluck('id')->toArray();
            $cartproductImages = Product::with('media')->whereIn('id', $productId)->get();
        } else {
            $countWishList = "";
            $countCarts = "";
            $cart = [];
            $cartproductImages = [];
        }
        return view('auth.login', compact('mainCategory', 'countWishList', 'cart', 'cartproductImages', 'countCarts'));
    }

    // public function login(LoginRequest $request)
    // {
    //     $confidential = $request->only('email', 'password');
    //     try {
    //         if (Auth::attempt($confidential)) {
    //             $user = Auth()->user();
    //             if ($user->role == 'user') {
    //                 Session::put('user_id', $user->id);
    //                 return redirect('/')->with('success', 'Welcome ' . $user->name);
    //             } else {
    //                 return back()->with('error', 'Incorrect email or password!');
    //             }
    //         } else {
    //             return back()->with('error', 'Incorrect email or password!');
    //         }
    //     } catch (\Exception $e) {
    //         return back()->with('error', $e->getMessage());
    //     }
    // }



    
    public function login(LoginRequest $request)
    {
        $cartItems = Session::get('cart', []); // Retrieve session cart

    
        $confidential = $request->only('email', 'password');
    
        try {
            if (Auth::attempt($confidential)) {
                $user = Auth()->user();
    
                if ($user->role == 'user') {
                    // Save session cart items to the database
                    if (!empty($cartItems)) {
                        foreach ($cartItems as $item) {
                            Cart::create([
                                'user_id' => $user->id,
                                'product_id' => $item['product_id'],
                                'product_size_price_id' => $item['price_sizeId'], // Fix key name if needed
                                'quantity' => $item['quantity'],
                            ]);
                        }
    
                        // Clear session cart after storing it in the database
                        Session::forget('cart');
                    }
                    Session::put('user_id', $user->id);
    
                    // Check for intended URL
                    $redirectTo = session()->pull('url.intended', '/'); // Defaults to '/' if no intended URL is found
                    
                    return redirect($redirectTo)->with('success', 'Welcome ' . $user->name);
                } else {
                    return back()->with('error', 'Incorrect email or password!');
                }
            } else {
                return back()->with('error', 'Incorrect email or password!');
            }
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
    


    public function logout()
    {
        session()->flush();
        return redirect('/')->with('success', 'You have logout successfully!');
    }
}
