<?php

use App\Http\Controllers\AboutUsController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HistoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\NewsLetterController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PrivacyPolicyController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\SearchProductController;
use App\Http\Controllers\SocialiteController;
use App\Http\Controllers\TermsAndConditionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserReviewController;
use App\Http\Controllers\WishlistController;
use App\Models\MainCategory;
use App\Models\Rating;
use App\Models\UserReview;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('register', [UserController::class, 'index']);
Route::post('register', [UserController::class, 'store']);

Route::get('complete_registration', [UserController::class, 'verifyMail']);


Route::get('login', [LoginController::class, 'index'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::post('logout', [LoginController::class, 'logout']);

Route::get('/', [HomeController::class, 'index']);

Route::get('products/{slug}', [ProductController::class, 'showProduct']);
Route::get('product/{slug}', [ProductController::class, 'showSingleProduct']);

Route::get('/get-price', [ProductController::class, 'getPrice'])->name('get.price');

Route::get('profile', [AccountController::class, 'index']);
Route::post('profile', [AccountController::class, 'edituserdetails']);

Route::get('wishlist', [WishlistController::class, 'index']);
Route::post('wishlist', [WishlistController::class, 'store']);
Route::get('wishlist/delete/{id}', [WishlistController::class, 'destroy']);


Route::get('cart', [CartController::class, 'index']);
Route::post('cart', [CartController::class, 'store']);
Route::get('cart/delete/{id}', [CartController::class, 'destroy']);
Route::get('cart/update/{id}', [CartController::class, 'updateCartQuantity']);

Route::get('user/checkout', [CheckoutController::class, 'index'])->name('checkout')->middleware('auth');
Route::post('user/checkouts', [CartController::class, 'checkout']);
Route::get('user/checkout/cities/{provinceId}', [CheckoutController::class, 'getCities']);
Route::get('user/checkout/areas/{cityId}', [CheckoutController::class, 'getAreas']);
Route::get('user/checkout/areas/deliveryCharge/{areaID}', [CheckoutController::class, 'getDeliveryCharge']);
Route::get('user/whole-checkout', [CartController::class, 'smallCartCheckout']);

Route::post('user/order', [OrderController::class, 'store']);


Route::get('user/history', [HistoryController::class, 'index']);
Route::get('user/history/order-details/{id}', [OrderController::class, 'singleorder'])->name('history.order-details');

Route::get('privacy-policy', [PrivacyPolicyController::class, 'index']);
Route::get('terms-condition', [TermsAndConditionController::class, 'index']);

Route::post('product/review', [RatingController::class, 'store']);


Route::get('/contact_us', function () {
    return view('contact_us');
});



Route::get('about-us', [AboutUsController::class, 'index']);


Route::get('products/search/view', [SearchProductController::class, 'index']);
// Route::post('products/search/view',[SearchProductController::class,'search']);


Route::get('googleLogin2',[SocialiteController::class, 'googleLogin']);
Route::get('auth/google/callback', [SocialiteController::class, 'googleHandle']);

Route::post('newsletter', [NewsLetterController::class, 'store']);

Route::post('user-review',[UserReviewController::class,'store']);
