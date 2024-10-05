<?php

namespace App\Http\Controllers;

use App\Mail\OrderConfirmationMail;
use App\Models\Area;
use App\Models\Cart;
use App\Models\City;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Province;
use App\Models\User;
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
                $totalPrice = 0;
                for ($i = 0; $i < count($size); $i++) {
                    $products[] = [
                        'name' => $product_name[$i],
                        'quantity' => $quantity[$i],
                        'price' => $price[$i]
                    ];
                    $totalPrice += $price[$i] * $quantity[$i];
                }

                // Send the email with order, products, and total price
                Mail::to($user->email)->send(new OrderConfirmationMail($user, $order, $products, $totalPrice));
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
}
