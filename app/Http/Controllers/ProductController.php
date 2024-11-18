<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\MainCategory;
use App\Models\Product;
use App\Models\ProductSizePrice;
use App\Models\Size;
use App\Models\SubCategory;
use App\Models\UserReview;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{

    public function product()
    {
        $mainCategory = MainCategory::with('subcategories')->get();
        $all_products = Product::with(['media', 'productsizeprice', 'productImages'])->orderBy('id','DESC')->paginate(12);

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
        return view('shop.productarchive',compact('all_products','mainCategory', 'countWishList', 'cart', 'cartproductImages', 'countCarts'));
    }

    public function showProduct(Request $request, $slug)
    {
        $mainCategory = MainCategory::with('subcategories')->get();
        $subCategory = SubCategory::where('slug', $slug)->first();
        $searchKeyword = $request->search_keyword;
        $minPrice = $request->min_price;
        $maxPrice = $request->max_price;
        $position = $request->position;
        $query = Product::with(['media', 'productsizeprice', 'productImages'])
            ->where('sub_category_id', $subCategory->id);
        if (!is_null($minPrice)) {
            $query->where('product_price', '>=', $minPrice);
        }
        if (!is_null($maxPrice)) {
            $query->where('product_price', '<=', $maxPrice);
        }
        if ($position == "low-to-high") {
            $query->orderBy('product_price', 'asc');
        } elseif ($position == "high-to-low") {
            $query->orderBy('product_price', 'desc');
        }
        $product = $query->paginate(9);
        // Initialize arrays to avoid undefined variable errors
        $userReviews = [];
        $averageRatingValue = [];
        foreach ($product as $products) {
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
            $averageRatingValue[$products->id] = $userAverageRating->average_rating ?? 0;
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
        } else {
            $countWishList = "";
            $countCarts = "";
            $cart = [];
            $cartproductImages = [];
        }
        return view('shop.product', compact('mainCategory', 'subCategory', 'product', 'countWishList', 'cart', 'cartproductImages', 'countCarts', 'slug', 'userReviews', 'averageRatingValue'));
    }


    public function showSingleProduct($slug)
    {
        $mainCategory = MainCategory::with('subcategories')->get();
        $product = Product::with('media','productImages')->with('productsizeprice')->where('slug', $slug)->first();
        $size = Size::whereIn('id', function ($query) use ($product) {
            $query->select('size_id')
                  ->from('product_size_prices')
                  ->where('product_id', $product->id)
                  ->where('product_stock', '>', 0);
        })
        ->orderByRaw("FIELD(slug, 'small', 'medium', 'large')")
        ->get();
        // $lastSizeId = $size->where('slug', 'small')->id;
        $lastSizeId = $size->where('slug', 'small')->first()->id ?? $size->first()->id;
        $activeSizePrice = $product->productsizeprice->where('size_id', $size->first()->id)->first()->price;

        $bestSellingProducts = Product::with('media', 'productImages')->with('productsizeprice')->take(6)->get();
        $relatedProducts = Product::select('id','slug','product_name','product_price','discount')->with('media', 'productImages')->with('productsizeprice')->take(4)->get();
        $productID=Product::where('slug',$slug)->first();
        $userReviews=UserReview::join('users', 'users.id','=', 'user_reviews.user_id')
        ->where('user_reviews.product_id', $productID->id)->get();
        $userAverageRating = UserReview::where('product_id', $productID->id)
        ->select(DB::raw('AVG(user_reviews.user_rating) as average_rating'))
        ->first();
        $averageRatingValue = $userAverageRating->average_rating ?? 0;
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
            $existingWishlistItem = Wishlist::where('user_id', auth()->user()->id)
            ->where('product_id', $product->id)
            ->first();
        } else {
            $countWishList = "";
            $countCarts = "";
            $cart = [];
            $cartproductImages = [];
            $existingWishlistItem= false;
        }
        return view('shop.single_product', compact(
            'mainCategory',
            'product',
            'size',
            'lastSizeId',
            'relatedProducts',
            'bestSellingProducts',
            'countWishList',
            'cart',
            'cartproductImages',
            'countCarts',
            'existingWishlistItem',
            'userReviews',
            'averageRatingValue',
            'activeSizePrice'
        ));
    }

    public function getPrice(Request $request)
{
    $productId = $request->product_id;
    $sizeId = $request->size_id;
    // Fetch the product size price based on product ID and size ID
    $productSizePrice = ProductSizePrice::where('product_id', $productId)
                                        ->where('size_id', $sizeId)
                                        ->first();

    if (!$productSizePrice) {
        // If no matching record is found, return an error response
        return response()->json([
            'error' => 'Product size not found',
        ], 404);
    }
    if ($productSizePrice->product_stock == 0) {
        return response()->json([
            'productsizeid' => $productSizePrice->id,
            'price' => $productSizePrice->price,

        ]);
    } else {
        return response()->json([
            'productsizeid' => $productSizePrice->id,
            'price' => $productSizePrice->price,
            'stock' => $productSizePrice->product_stock,
        ]);
    }
}

}
