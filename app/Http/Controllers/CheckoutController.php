<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Cart;
use App\Models\City;
use App\Models\MainCategory;
use App\Models\PaymentOption;
use App\Models\Product;
use App\Models\Province;
use App\Models\User;
use App\Models\UserDetail;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use App\Models\UserReview;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $mainCategory = MainCategory::with('subcategories')->get();
        $relatedProducts = Product::with('media')->with('productsizeprice')->take(4)->get();
        foreach ($relatedProducts as $products) {
            // Get the user reviews for the current product
            $productReviews = UserReview::join('users', 'users.id', '=', 'user_reviews.user_id')
                ->where('user_reviews.product_id', $products->id)
                ->get();
            // Add the reviews to the array
            $userReviews[$products->id] = $productReviews;
            // Calculate the average rating for the current product
            $userAverageRating = UserReview::where('product_id', $products->id)
                ->select(DB::raw('AVG(user_reviews.user_rating) as average_rating'))
                ->first();
            // Add the average rating to the array
            $averageRatingValues[$products->id] = $userAverageRating->average_rating ?? 0;
        }
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
            $userDetails = User::leftjoin('user_details', 'user_details.user_id', '=', 'users.id')
            ->select('users.id', 'users.name', 'user_details.address')
            ->where('users.id', auth()->user()->id)
            ->first();
        } else {
            $countWishList = "";
            $countCarts = "";
            $cart = [];
            $cartproductImages = [];
            $userDetails=[];
        }
        $selectedProducts = $request->session()->get('selectedProducts');
        $productId = $selectedProducts->pluck('id')->toArray();
        $cartproductImages = Product::with('media')->whereIn('id', $productId)->get();
        $sub_total = Cart::join('product_size_prices', 'product_size_prices.id', '=', 'carts.product_size_price_id')
        ->where('user_id', auth()->user()->id)
        ->whereIn('carts.product_id', $productId)
        ->sum(DB::raw('product_size_prices.price * carts.quantity'));
        $paymentOptions=PaymentOption::get();
        $provinces=Province::all();
        return view('user.checkout', compact(
            'mainCategory',
            'countWishList',
            'countCarts',
            'cart',
            'cartproductImages',
            'selectedProducts',
            'cartproductImages',
            'relatedProducts',
            'userDetails',
            'provinces',
            'sub_total',
            'paymentOptions'
        ));
    }

    public function getCities($provinceId)
    {
        $cities = City::where('province_id', $provinceId)->get();
        return response()->json($cities);
    }

    public function getAreas($cityId){
        $areas = Area::where('city_id', $cityId)->get();
        return response()->json($areas);
    }

    public function getDeliveryCharge($areaID)
    {
        $areas = Area::find($areaID);
        return response()->json($areas);
    }
}
