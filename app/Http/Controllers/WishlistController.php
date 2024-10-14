<?php

namespace App\Http\Controllers;

use App\Http\Requests\Wishlist\WishlistCreateRequest;
use App\Models\Cart;
use App\Models\MainCategory;
use App\Models\Product;
use App\Models\Wishlist;
use App\Models\UserReview;
use Illuminate\Http\Client\ResponseSequence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WishlistController extends Controller
{
    public function index()
{
    $mainCategory = MainCategory::with('subcategories')->get();

    if (auth()->check()) {
        $wishLists = Wishlist::join('products', 'products.id', '=', 'wishlists.product_id')
            ->join('product_size_prices', 'products.id', '=', 'product_size_prices.product_id')
            ->select('wishlists.id as wishlistid','products.id', 'products.product_name', 'products.description', 'products.slug', 'products.discount',  DB::raw('MAX(product_size_prices.price) as price'))
            ->groupBy('wishlistid','products.id', 'products.product_name', 'products.description', 'products.slug')
            ->where('wishlists.user_id', auth()->user()->id)
            ->get();

        if ($wishLists->isNotEmpty()) {
            $productIDs = $wishLists->pluck('id')->toArray();

            // Get product images
            $productImages = Product::with('media', 'productImages')
                ->whereIn('id', $productIDs)
                ->get();

            // Get user reviews for all products in wishlist
            $userReviews = UserReview::join('users', 'users.id', '=', 'user_reviews.user_id')
                ->whereIn('user_reviews.product_id', $productIDs)
                ->get();

            // Calculate the average rating for all products in wishlist
            $userAverageRating = UserReview::whereIn('product_id', $productIDs)
                ->select(DB::raw('AVG(user_reviews.user_rating) as average_rating'))
                ->first();

            // Average rating value
            $averageRatingValue = $userAverageRating->average_rating ?? 0;
        } else {
            $productImages = [];
            $userReviews = [];
            $averageRatingValue = 0;
        }

        $countWishList = Wishlist::where('user_id', auth()->user()->id)->count();
        $countCarts = Cart::where('user_id', auth()->user()->id)->count();

        $cart = Cart::join('products', 'products.id', '=', 'carts.product_id')
            ->join('product_size_prices', 'product_size_prices.id', '=', 'carts.product_size_price_id')
            ->join('sizes', 'sizes.id', '=', 'product_size_prices.size_id')
            ->select('products.id', 'products.product_name', 'products.slug', 'product_size_prices.price', 'sizes.size', 'carts.quantity', 'carts.id as cartid', 'carts.user_id')
            ->groupBy('cartid', 'products.id', 'products.product_name', 'products.slug', 'product_size_prices.price', 'sizes.size', 'carts.quantity', 'carts.user_id')
            ->where('carts.user_id', auth()->user()->id)
            ->get();

        $productId = $cart->pluck('id')->toArray();
        $cartproductImages = Product::with('media')->whereIn('id', $productId)->get();
    } else {
        $productImages = [];
        $wishLists = [];
        $countWishList = "";
        $countCarts = "";
        $cart = [];
        $cartproductImages = [];
        $userReviews = [];
        $averageRatingValue = "";

    }

    return view('wishlist.wishlist', compact('mainCategory', 'wishLists', 'productImages', 'countWishList', 'cart', 'cartproductImages', 'countCarts', 'userReviews', 'averageRatingValue'));
}




    public function store(WishlistCreateRequest $request)
{
    try {
        // Check if the user is logged in
        if (Auth::check()) {
            $userId = auth()->user()->id;
            $productId = $request->product_id;

            // Check if the product is already in the user's wishlist
            $existingWishlistItem = Wishlist::where('user_id', $userId)
                ->where('product_id', $productId)
                ->first();

            if ($existingWishlistItem) {
                // If the product is in the wishlist, delete it
                DB::transaction(function () use ($existingWishlistItem) {
                    $existingWishlistItem->delete();
                });
                return back()->with('success', 'Product Removed from Wishlist');
            } else {
                // If the product is not in the wishlist, add it
                DB::transaction(function () use ($userId, $productId) {
                    Wishlist::create([
                        'user_id' => $userId,
                        'product_id' => $productId,
                    ]);
                });
                return back()->with('success', 'Added to Wishlist');
            }
        } else {
            return redirect('login')->with('error', 'Please Login First');
        }
    } catch (\Exception $e) {
        return back()->with('error', $e->getMessage());
    }
}


    public function destroy($id) {
        $wishlist = Wishlist::find($id);
        if (is_null($wishlist)) {
            return back()->with('error', 'Product Not Found!');
        }
        try {
            $wishlist = DB::transaction(function () use ($wishlist) {
                $wishlist->delete();
                return $wishlist;
            });
            if ($wishlist) {
                return back()->with('success', 'Product Earsed From Wishlist');
            }
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
