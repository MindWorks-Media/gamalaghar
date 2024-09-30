<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\CreateUserRequest;
use App\Mail\UserVerificationMail;
use App\Models\Cart;
use App\Models\MainCategory;
use App\Models\PasswordReset;
use App\Models\Product;
use App\Models\User;
use App\Models\Wishlist;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
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
        $mainCategory = MainCategory::with('subcategories')->get();
        return view('auth.register',compact('mainCategory', 'countWishList', 'cartproductImages', 'cart', 'countCarts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateUserRequest $request)
    {
        if ($request->password !== $request->confirm_password) {
            return back()->with('error', 'Password does not match with Confirm Password!');
        }
        try {
            $user=DB::transaction(function() use($request){
                $user=User::create([
                    'name' => $request->fullname,
                    'email' => $request->email,
                    'phone'=>$request->phone,
                    'password' => Hash::make($request->password),
                    'email_verified_at'=>Carbon::today(),
                    'role'=>'user',
                ]);
                $token = Str::random(60);
                DB::table('password_resets')->insert([
                    'email' => $request->email,
                    'token' => $token,
                    'created_at' => now(),
                ]);
                Mail::to($request->email)->send(new UserVerificationMail($user, $token));
                return $user;
            });
            if ($user) {
                return redirect()->route('login')->with('success', 'You are registered successfully!');
            }
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function verifyMail(Request $request)
    {
        $token = request()->token;
        if (!$token) {
            return back()->with('error','Invalid Token');
        }
        $passwordReset = PasswordReset::where('token', $token)->first();
        if (!$passwordReset) {

            return back()->with('error', 'Token Not Found!');
        }
        $user = User::where('email', $passwordReset->email)->first();
        if (!$user) {
            return back()->with('error', 'User Not Found!');
        }
        try {
            DB::transaction(function () use ($user, $request, $token) {
                $user->email_verified_at = now();
                $user->save();
                PasswordReset::where('token', $token)->delete();
            });
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
        return redirect('/')->with('success','User verified successfully!');
    }
}
