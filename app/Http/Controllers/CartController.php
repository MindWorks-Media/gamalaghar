<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\MainCategory;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use League\CommonMark\Extension\CommonMark\Parser\Inline\BacktickParser;

class CartController extends Controller
{

    public function index()
    {
        $mainCategory = MainCategory::with('subcategories')->get();
        $relatedProducts = Product::with('media')->with('productsizeprice')->take(4)->get();
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
            $cartproductImages = Product::with('media', 'productImages')->whereIn('id', $productId)->get();
        } else {
            $countWishList = "";
            $countCarts = "";
            $cart = [];
            $cartproductImages = [];
        }
        // dd($cart);
        return view('user.user_cart', compact('mainCategory', 'countWishList', 'countCarts', 'cart', 'cartproductImages', 'relatedProducts'));
    }

    public function store(Request $request)
    {
        try {
            if (!Auth::check()) {
                return redirect('login');
            }
            $user_id = auth()->user()->id;
            $product_id = $request->product_id;
            $product_size_price_id = $request->product_size_price_id;
            $cart = DB::transaction(function () use ($user_id, $product_id, $product_size_price_id, $request) {
                // Check if the product already exists in the user's cart
                $existingCart = Cart::where('user_id', $user_id)
                    ->where('product_id', $product_id)
                    ->where('product_size_price_id', $product_size_price_id)
                    ->first();
                if ($existingCart) {
                    // If the product exists, update the quantity
                    $existingCart->update([
                        'quantity' => $existingCart->quantity + $request->quantity
                    ]);
                    return $existingCart;
                } else {
                    // If the product doesn't exist, create a new entry
                    $cart = Cart::create([
                        'user_id' => $user_id,
                        'product_id' => $product_id,
                        'product_size_price_id' => $product_size_price_id,
                        'quantity' => $request->quantity,
                    ]);
                    return $cart;
                }
            });
            if ($cart) {
                return back()->with('success', 'Product Added to Cart!');
            }
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $cart = Cart::find($id);
        if (is_null($cart)) {
            return back()->with('error', 'Product Not Found!');
        }
        try {
            $cart = DB::transaction(function () use ($cart) {
                $cart->delete();
                return $cart;
            });
            if ($cart) {
                return back()->with('success', 'Product Deleted From Cart!');
            }
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function checkout(Request $request)
    {
        // Retrieve selected product IDs from the form submission
        $selectedProductIds = $request->input('selectedProducts', []);
        if (!$selectedProductIds) {
            return back()->with('error', 'Please select products');
        }
        // Retrieve products based on the selected IDs
        $selectedProducts = Cart::join('products', 'products.id', '=', 'carts.product_id')
            ->join('product_size_prices', 'product_size_prices.id', '=', 'carts.product_size_price_id')
            ->join('sizes', 'sizes.id', '=', 'product_size_prices.size_id')
            ->select('products.id', 'products.product_name', 'products.slug', 'product_size_prices.price', 'sizes.size', 'carts.quantity', 'carts.id as cartid', 'carts.user_id')
            ->groupBy('cartid', 'products.id', 'products.product_name', 'products.slug', 'product_size_prices.price', 'sizes.size', 'carts.quantity', 'carts.user_id')
            ->where('carts.user_id', auth()->user()->id)
            ->whereIn('carts.id', $selectedProductIds)->get();
        // Store the selected products in the session
        $request->session()->put('selectedProducts', $selectedProducts);
        return redirect()->route('checkout'); // Assuming you have a named route for your checkout page
    }

    public function smallCartCheckout(Request $request){
        $selectedProducts = Cart::join('products', 'products.id', '=', 'carts.product_id')
        ->join('product_size_prices', 'product_size_prices.id', '=', 'carts.product_size_price_id')
        ->join('sizes', 'sizes.id', '=', 'product_size_prices.size_id')
        ->select('products.id', 'products.product_name', 'products.slug', 'product_size_prices.price', 'sizes.size', 'carts.quantity', 'carts.id as cartid', 'carts.user_id')
        ->groupBy('cartid', 'products.id', 'products.product_name', 'products.slug', 'product_size_prices.price', 'sizes.size', 'carts.quantity', 'carts.user_id')
        ->where('carts.user_id', auth()->user()->id)
        ->get();
        $request->session()->put('selectedProducts', $selectedProducts);
        return redirect()->route('checkout');
    }

    public function updateCartQuantity(Request $request, $id)
    {
        // Retrieve the cart item
        $cart = Cart::find($id);
        $cart->update([
            'quantity'=>$request->query('quantity')
        ]);
        $subtotal = $cart->price * $cart->quantity;
        return back()->with('success','Quantity Updated Successfully!');
    }

// isntant show in my cart
    public function addToCart(Request $request)
    {
        $cart = session()->get('cart', []);
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity', 1);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $cart[$productId] = [
                'product_id' => $productId,
                'quantity' => $quantity,
                'name' => $request->input('name'),
                'price' => $request->input('price'),
                'image_url' => $request->input('image_url')
            ];
        }

        session()->put('cart', $cart);
        $cartCount = array_sum(array_column($cart, 'quantity'));
        $totalPrice = array_reduce($cart, function ($total, $item) {
            return $total + ($item['price'] * $item['quantity']);
        }, 0);

        return response()->json(['cart' => $cart, 'cartCount' => $cartCount,'totalPrice' => $totalPrice, 'message' => 'Item added to cart']);
    }

    public function getCart()
    {
        $cart = session()->get('cart', []);
        return response()->json(['cart' => $cart]);
    }

    public function updateCart(Request $request)
    {
        $cart = session()->get('cart', []);
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] = $quantity;
            session()->put('cart', $cart);
            return response()->json(['cart' => $cart, 'message' => 'Cart updated']);
        }

        return response()->json(['message' => 'Item not found in cart'], 404);
    }

    public function deleteFromCart(Request $request)
    {
        $cart = session()->get('cart', []);
        $productId = $request->input('product_id');
    
        if (isset($cart[$productId])) {
            // Remove the item from the cart
            unset($cart[$productId]);
            
            // Update the session with the new cart data
            session()->put('cart', $cart);
            
            // Calculate the updated cart count
            $cartCount = array_sum(array_column($cart, 'quantity'));
    
            return response()->json([
                'cart' => $cart,
                'cartCount' => $cartCount,
                'message' => 'Item removed from cart successfully!'
            ]);
        }
    
        return response()->json(['message' => 'Item not found in cart'], 404);
    }



    // isntantly add to cart after 
    public function wishlist_toggle(Request $request)
{
    $request->validate([
        'product_id' => 'required|exists:products,id',
    ]);

    $wishlist = Wishlist::where('user_id', auth()->id())
                        ->where('product_id', $request->product_id)
                        ->first();

    if ($wishlist) {
        $wishlist->delete();
        $status = 'removed';
    } else {
        Wishlist::create([
            'user_id' => auth()->id(),
            'product_id' => $request->product_id,
        ]);
        $status = 'added';
    }

    // Return the new wishlist count
    $count = Wishlist::where('user_id', auth()->id())->count();

    return response()->json([
        'status' => $status,
        'count' => $count,
    ]);
}
    
}
