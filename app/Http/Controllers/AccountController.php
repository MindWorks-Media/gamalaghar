<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\MainCategory;
use App\Models\Product;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{
    public function index()
    {
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
            $user = User::with(['userDetail', 'media'])->where('id', auth()->user()->id)->first();

        } else {
            $countWishList = "";
            $countCarts = "";
            $cart = [];
            $cartproductImages = [];
            $user = [];
        }
        return view('user.profile', compact('mainCategory', 'user', 'countWishList', 'countCarts', 'cartproductImages', 'cart'));
    }

    public function edituserdetails(Request $request)
    {
        $user = User::find(auth()->user()->id);
        if (is_null($user)) {
            return back()->with('error', 'User not Found!');
        }
        try {
            $user = DB::transaction(function () use ($user, $request) {
                $user->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                ]);
                $user->userDetail()->updateOrCreate([
                    // 'user_id'=>auth()->user()->id,
                    'address' => $request->address,
                    'shipping_address' => $request->shipping_address,
                    'secondary_phone' => $request->secondary_phone,
                ]);
                if ($request->user_image) {
                    $user->clearMediaCollection('user_image');
                    $user->addMedia($request->user_image)->toMediaCollection('user_image');
                }
                return $user;
            });
            if ($user) {
                return back()->with('success', 'Details Edited Successfully!');
            }
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
