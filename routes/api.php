<?php

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('products' , 'Api\ProductController')->only('index','show');
Route::get('product/{product}/availability' , 'Api\ProductAvailabilityController')->name('product.availability.show');
Route::get('product/{product}/reviews' , 'Api\ReviewProductController')->name('product.reviews.index');
Route::get('product/{product}/price' , 'Api\ProductPriceController')->name('product.price.show');
Route::get('booking-by-review/{reviewKey}' , 'Api\BookingByReviewController')->name('booking-by-review-show');
Route::apiResource('reviews' , 'Api\ReviewController')->only('show' , 'store');
