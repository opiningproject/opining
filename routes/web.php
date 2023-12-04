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
    return redirect()->route('login');
});

Route::get('/user', [App\Http\Controllers\User\HomeController::class, 'index']);

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
    Route::post('/settings/change-password', [SettingController::class, 'changePassword']);
    Route::post('/settings/save-profile', [SettingController::class, 'saveProfile'])->name('settings.save-profile');

    Route::get('/coupons/claim-history', [CouponController::class, 'claimHistoryLog'])->name('claimHistoryLog');
    Route::resource('/coupons', CouponController::class);
    Route::post('/coupons/change-status', [CouponController::class, 'changeStatus']);

    Route::post('get-paginate-data', [CommonController::class, 'getPaginateData'])->name('getPaginateData');
    Route::resource('/menu/dish', DishController::class);

    Route::resource('/category',CategoryController::class);

    Route::resource('/menu/ingredients/category',IngredientCategoryController::class, [
        'as' => 'ingred'
    ]);

    Route::get('/menu/ingredients/checkAttachedDish/{ingredient}', [IngredientController::class, 'checkAttachedDish']);
    Route::post('/menu/ingredients/update-status/{ingredient}',[IngredientController::class, 'updateIngredientStatus']);
    Route::resource('/menu/ingredients',IngredientController::class);
    Route::post('/menu/ingredients/ing-cat-wise/{ingredient}',[IngredientController::class => 'ingredientCategoryWise']);

});
