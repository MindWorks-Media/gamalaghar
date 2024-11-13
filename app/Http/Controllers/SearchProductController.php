<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Faq;
use App\Models\MainCategory;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class SearchProductController extends Controller
{

    public function index(Request $request)
    {
        $searchKeyword = $request->search_keyword;
        $minPrice = $request->min_price;
        $maxPrice = $request->max_price;
        $position = $request->position;
        $query = Product::select('id','slug','product_name','product_price')->with(['media', 'productsizeprice'])
            ->where('product_name', 'like', '%' . $searchKeyword . '%');
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
        $resultedProducts = $query->paginate(9);
        $mainCategory = MainCategory::with('subcategories')->get();
        // $product = Product::with(['media', 'productImages','productsizeprice'])->latest()->get();
        // $productSizePrice=ProductSizePrice::where('')
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
        return view('search_products.search_product', compact(
            'resultedProducts',
            'mainCategory',
            'countWishList',
            'cart',
            'cartproductImages',
            'countCarts',
        ));
    }
}
