<?php

namespace App\Http\Controllers;

use App\Mail\OrderConfirmationMail;
use App\Models\Area;
use App\Models\Cart;
use App\Models\City;
use App\Models\MainCategory;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Province;
use App\Models\User;
use App\Models\Wishlist;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'payment_option' => ['required'],
            'fullname' => ['required'],
            'shipping_address' => ['required'],
            'province_id' => ['required'],
            'city_id' => ['required'],
        ]);

        try {
            $city = $request->input('city_id');
            $area = $request->input('area_id');
            // Retrieve province, city, and area names from their respective models
            $provinceName = Province::find($request->province_id);
            $cityName = City::find($city)->city;
            $areaName = "";
            if ($area) {
                $areaName = Area::find($area)->area;
            }
            $user = Auth::user();
            $order = DB::transaction(function () use ($request, $provinceName, $cityName, $areaName, $user) {
                $order = Order::create([
                    'user_id' => $user->id,
                    'order_number' => Str::upper(Carbon::now()->format('Yd') . Str::random(5)),
                    'fullname' => $request->fullname,
                    'shipping_email' => $request->shipping_email !== $user->email ? $request->shipping_email : null,
                    'shipping_phone' => $request->shipping_phone !== $user->phone ? $request->shipping_phone : null,
                    'province' => $provinceName->province,
                    'city' => $cityName ?? null,
                    'area' => $areaName ?? null,
                    'shipping_address' => $request->shipping_address,
                    'sub_total' => $request->sub_total,
                    'delivery_charge' => $request->delivery_charge,
                    'total_amount' => $request->total_amount,
                    'payment_option_id' => $request->payment_option,
                    'comment' => $request->comment,
                    'order_status' => 'Pending',
                ]);
                $size = $request->input('size');
                $price = $request->input('price');
                $product_name = $request->input('product_name');
                $product_id = $request->input('product_id');
                $quantity = $request->input('quantity');
                $subTotalAmount = $request->input('sub_total');
                $deliveryCharge = $request->input('delivery_charge');
                $netTotalAmount = $request->input('total_amount');
                // Loop through the arrays and save each product
                for (
                    $i = 0;
                    $i < count($size);
                    $i++
                ) {
                    $orderItem = new OrderItem();
                    $orderItem->user_id = auth()->user()->id;
                    $orderItem->order_id = $order->id;
                    $orderItem->size = $size[$i];
                    $orderItem->product_name = $product_name[$i];
                    $orderItem->price = $price[$i];
                    $orderItem->product_id = $product_id[$i];
                    $orderItem->quantity = $quantity[$i];
                    $orderItem->save();
                }
                $orderedProductIds = collect($product_id);
                Cart::where('user_id', auth()->user()->id)
                    ->whereIn('product_id', $orderedProductIds)
                    ->delete();

                $user = User::find(auth()->user()->id);

                // Prepare products and total price data for the email
                $products = [];
                $subTotalPrice = 0;
                for ($i = 0; $i < count($size); $i++) {
                    $products[] = [
                        'name' => $product_name[$i],
                        'quantity' => $quantity[$i],
                        'price' => $price[$i],
                        'size' => $size[$i]
                    ];
                    $subTotalPrice += $price[$i] * $quantity[$i];
                    // $deliveryAmount = $deliveryCharge;
                    // $totalPrice = $netTotalAmount;
                }

                // Send the email with order, products, and total price
                Mail::to($user->email)->send(new OrderConfirmationMail($user, $order, $products, $subTotalPrice, $deliveryCharge, $netTotalAmount));
                return $order;
            });
            if ($order) {
                return redirect('/')->with('success', 'Your Order is Placed!!');
            } else {
                return back()->with('error', 'Please Fill the Province, City and Area');
            }
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function singleorder($id)
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
            $userDetails = User::leftjoin('user_details', 'user_details.user_id', '=', 'users.id')
            ->select('users.id', 'users.name', 'users.email', 'users.phone', 'user_details.address')
            ->where('users.id', auth()->user()->id)
            ->first();
        } else {
            $countWishList = "";
            $countCarts = "";
            $cart = [];
            $cartproductImages = [];
            $userDetails=[];
        }
        $order = Order::with('orderItems')->where('id', $id)->first();
        $productId = $order->orderItems->pluck('product_id')->toArray();
        $productImages = Product::with('media')->whereIn('id', $productId)->get();
        return view('user.order_details', compact('order', 'productImages', 'countWishList', 'countCarts', 'cart', 'cartproductImages', 'userDetails', 'mainCategory'));
    }
}
