<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\DishController;
use App\Http\Controllers\Admin\IngredientCategoryController;
use App\Http\Controllers\Admin\IngredientController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\CommonController;
use App\Http\Controllers\Admin\HomeController;
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

Route::get('/clear-all', function() {
    Artisan::call('cache:clear');

    Artisan::call('config:clear');

    Artisan::call('view:clear');

    Artisan::call('route:clear');

    echo "All cache/config/view/route cleared...";
});

Route::get('/', function () {
    return redirect()->route('user.home');
});

Route::middleware(['localization'])->group(function ()
{
    Route::get('privacy-policy', [App\Http\Controllers\User\CMSController::class, 'privacyPolicy'])->name('privacy-policy');
    Route::get('terms', [App\Http\Controllers\User\CMSController::class, 'terms'])->name('terms');

    Route::get('google/auth', [App\Http\Controllers\User\AuthController::class, 'redirectToGoogle']);
    Route::get('google/auth/callback', [App\Http\Controllers\User\AuthController::class, 'handleGoogleCallback']);

    Route::get('/home', [App\Http\Controllers\User\HomeController::class, 'index'])->name('user.home');
    Route::get('/user/dashboard', [App\Http\Controllers\User\HomeController::class, 'dashboard'])->name('user.dashboard');
    Route::post('/user/login', [App\Http\Controllers\User\AuthController::class, 'login']);
    Route::post('/user/signup', [App\Http\Controllers\User\AuthController::class, 'signup']);
    Route::post('/user/forgot-password', [App\Http\Controllers\User\AuthController::class, 'forgotPassword'])->name('forgot-password');
    Route::get('email/verify/{id}',[App\Http\Controllers\User\VerificationController::class, 'verify'])->name('verification.verify');
    Route::post('/favorite', [App\Http\Controllers\User\DishController::class, 'favorite']);
    Route::post('/validateZipcode', [App\Http\Controllers\User\AddressController::class, 'validateZipcode']);
    Route::get('/user/delete-address/{id}',[App\Http\Controllers\User\AddressController::class, 'deleteAddress']);
    Route::get('/user/add-to-cart/{id}', [App\Http\Controllers\User\CartController::class, 'addToCart']);

});

Auth::routes();

Route::get('change-lang/{lang}', function($lang) {
    session(['Accept-Language' => $lang]);
    return redirect()->back();
})->name('app.setLocal');

Route::middleware(['auth', 'localization'])->group(function () {

    Route::get('/menu', [HomeController::class, 'index'])->name('home');
    Route::get('/menu/add-dish', [DishController::class, 'index'])->name('addDish');
    Route::get('/menu/edit-dish/{dish}', [DishController::class, 'edit'])->name('editDish');

    Route::get('/settings', [SettingController::class, 'index'])->name('settings');
    Route::get('/settings/delete-zipcode', [SettingController::class, 'deleteZipcode']);
    Route::post('/settings/change-status', [SettingController::class, 'changeStatus']);
    Route::post('/settings/save-zipcode', [SettingController::class, 'saveZipcode']);
    Route::post('/settings/save-content', [SettingController::class, 'saveContent']);
    Route::post('/settings/change-password', [SettingController::class, 'changePassword'])->name('change.password');
    Route::post('/settings/save-profile', [SettingController::class, 'saveProfile'])->name('settings.save-profile');

    Route::get('/coupons/claim-history', [CouponController::class, 'claimHistoryLog'])->name('claimHistoryLog');
    Route::resource('/coupons', CouponController::class);
    Route::post('/coupons/change-status', [CouponController::class, 'changeStatus']);

    Route::post('get-paginate-data', [CommonController::class, 'getPaginateData'])->name('getPaginateData');

    Route::post('/menu/dish/getIngredientList/{dish}', [DishController::class, 'ingredientDishBased']);
    Route::post('/menu/dish/addIngredient/{dish}', [DishController::class, 'addDishIngredient']);
    Route::patch('/menu/dish/updateIngredient/{dish}', [DishController::class, 'updatePaidIngredient']);
    Route::resource('/menu/dish', DishController::class);

    Route::resource('/category',CategoryController::class);

    Route::resource('/menu/ingredients/category',IngredientCategoryController::class, [
        'as' => 'ingred'
    ]);

    Route::get('/menu/ingredients/checkAttachedDish/{ingredient}', [IngredientController::class, 'checkAttachedDish']);
    Route::post('/menu/ingredients/update-status/{ingredient}',[IngredientController::class, 'updateIngredientStatus']);

    Route::resource('/menu/ingredients',IngredientController::class);
    Route::post('/menu/ingredients/ing-cat-wise/{ingredient}',[IngredientController::class => 'ingredientCategoryWise']);

    Route::get('/user/settings', [App\Http\Controllers\User\SettingController::class, 'index'])->name('user.settings');
    Route::post('/user/settings/save-profile', [App\Http\Controllers\User\SettingController::class, 'saveProfile'])->name('user.settings.save-profile');
    Route::get('/user/favorite', [App\Http\Controllers\User\DishController::class, 'getFavoriteDishes'])->name('user.favorite');
    Route::get('/user/points', [App\Http\Controllers\User\DishController::class, 'getCollectedPoints'])->name('user.points');
    Route::post('/unFavorite', [App\Http\Controllers\User\DishController::class, 'unFavorite']);

    Route::get('/user/coupons', [App\Http\Controllers\User\CouponController::class, 'index'])->name('user.coupons');
    Route::get('/user/orders', [App\Http\Controllers\User\OrderController::class, 'index'])->name('user.orders');
});
