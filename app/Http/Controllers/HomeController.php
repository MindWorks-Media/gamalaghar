<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Faq;
use App\Models\MainCategory;
use App\Models\Product;
use App\Models\ProductSizePrice;
use App\Models\SubCategory;
use App\Models\Wishlist;
use App\Models\UserReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class HomeController extends Controller
{
    public function index()
    {
        $mainCategory = MainCategory::with('subcategories')->get();
    //     $product = Product::with(['media', 'productsizeprice','productImages'])->latest()->get();
    //      // Loop through each product to get its reviews and average rating
    // foreach ($product as $products) {
    //     // Get the user reviews for the current product
    //     $productReviews = UserReview::join('users', 'users.id', '=', 'user_reviews.user_id')
    //         ->where('user_reviews.product_id', $products->id)
    //         ->get();
    //     // Add the reviews to the array
    //     $userReviews[$products->id] = $productReviews;
    //     // Calculate the average rating for the current product
    //     $userAverageRating = UserReview::where('product_id', $products->id)
    //         ->select(DB::raw('AVG(user_reviews.user_rating) as average_rating'))
    //         ->first();
    //     // Add the average rating to the array
    //     $averageRatingValues[$products->id] = $userAverageRating->average_rating ?? 0;
    // }
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
            $mainCategory = MainCategory::with('subcategories')->get();
        }
        $feauturedProducts = Product::with(['media', 'productsizeprice','productImages'])->where('is_featured', 1)->take(8)->get();
        // dd($feauturedProducts);
        $faqs = Faq::all();
        // return view('home.home', compact(
        //     'mainCategory',
        //     'product',
        //     'countWishList',
        //     'cart',
        //     'cartproductImages',
        //     'countCarts',
        //     'faqs',
        //     'userReviews',
        //     'averageRatingValues',
        //     'feauturedProducts'
        // ));
        return view('home.home', compact('mainCategory','countWishList','cart','cartproductImages','countCarts','faqs','feauturedProducts'
        ));
    }
}
