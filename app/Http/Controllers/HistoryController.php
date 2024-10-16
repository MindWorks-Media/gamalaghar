<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\MainCategory;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function index()
    {
    $mainCategory = MainCategory::with('subcategories')->get();
    $product = Product::with('media')->latest()->get();

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

        // Fetch order histories and group by `order_id`
        $order_histories = OrderItem::with('order') // Load the related Order
            ->where('user_id', auth()->user()->id)
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('order_id');

        $orderproductId = $order_histories->flatten()->pluck('product_id')->toArray();
        $orderproductImages = Product::with('media', 'productImages')->whereIn('id', $orderproductId)->get();
    } else {
        $countWishList = "";
        $countCarts = "";
        $cart = [];
        $cartproductImages = [];
        $order_histories = collect();
        $orderproductImages = [];
    }

    return view('user.history', compact(
        'mainCategory',
        'product',
        'countWishList',
        'countCarts',
        'cart',
        'cartproductImages',
        'order_histories',
        'orderproductImages'
    ));
    }

    
}
