<?php

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

Route::group([
    'middleware' => 'api','prefix' => 'v1'
], function ($router) {

    Route::post('postApiLog', 'Api\v1\VersionController@postApiLog');
    
    Route::post('login', 'App\Http\Controllers\Api\v1\AuthController@login');
    Route::post('register', 'App\Http\Controllers\Api\v1\AuthController@register');
    Route::post('socialSignup', 'App\Http\Controllers\Api\v1\AuthController@socialSignup');
    Route::post('forgotPassword', 'App\Http\Controllers\Api\v1\AuthController@forgotPassword');
    Route::post('refresh', 'App\Http\Controllers\Api\v1\AuthController@refresh');
    Route::post('getVersion', 'App\Http\Controllers\Api\v1\VersionController@getAppVersion');
    Route::get('getCommonLinks', 'App\Http\Controllers\Api\v1\CMSController@getCommonLinks');
    Route::post('contactUs', 'App\Http\Controllers\Api\v1\CMSController@contactUs');
    Route::get('email/verify/{id}','App\Http\Controllers\Api\v1\VerificationController@verify')->name('verification.verify');

    Route::group(['middleware' => 'jwt.verify'], function ($router) {
		Route::post('getProfile', 'App\Http\Controllers\Api\v1\ProfileController@getProfile');
        Route::post('updateProfile', 'App\Http\Controllers\Api\v1\ProfileController@updateProfile');
        Route::post('changePassword', 'App\Http\Controllers\Api\v1\ProfileController@changePassword');
        Route::post('uploadProfilePicture', 'App\Http\Controllers\Api\v1\ProfileController@uploadProfilePicture');
        Route::post('getAndUpdateSettings', 'App\Http\Controllers\Api\v1\ProfileController@getAndUpdateSettings');
    	Route::post('logout', 'App\Http\Controllers\Api\v1\AuthController@logout');
        Route::post('changeLanguage', 'App\Http\Controllers\Api\v1\ProfileController@changeLanguage');
        Route::post('deleteAccount', 'App\Http\Controllers\Api\v1\ProfileController@deleteAccount');
       
        Route::post('favoriteUnfavorite', 'App\Http\Controllers\Api\v1\DishController@favoriteUnfavorite');
       
        Route::post('validateZipcode', 'App\Http\Controllers\Api\v1\AddressController@validateZipcode');
        Route::post('getFavouriteDishes', 'App\Http\Controllers\Api\v1\DishController@getFavouriteDishes');
        Route::get('deleteAddress/{id}', 'App\Http\Controllers\Api\v1\AddressController@deleteAddress');
        Route::post('getOrders', 'App\Http\Controllers\Api\v1\OrderController@getOrders');
        Route::post('refundRequest', 'App\Http\Controllers\Api\v1\OrderController@refundRequest');
        Route::get('getCoupons', 'App\Http\Controllers\Api\v1\CouponController@getCoupons');
        Route::post('buyCouponCode', 'App\Http\Controllers\Api\v1\CouponController@buyCouponCode');
        
        

        
	});
    Route::post('getCategories', 'App\Http\Controllers\Api\v1\CategoryController@getCategories');
    Route::post('getDishes', 'App\Http\Controllers\Api\v1\DishController@getDishes');
    
});


