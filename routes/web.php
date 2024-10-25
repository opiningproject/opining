<?php

use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\DeliverersController;
use App\Http\Controllers\Admin\DishController;
use App\Http\Controllers\Admin\DishOptionCategoryController;
use App\Http\Controllers\Admin\DishOptionsController;
use App\Http\Controllers\Admin\DomainSettingController;
use App\Http\Controllers\Admin\IngredientCategoryController;
use App\Http\Controllers\Admin\IngredientController;
use App\Http\Controllers\Admin\ManualOrdersController;
use App\Http\Controllers\Admin\MyWebsiteController;
use App\Http\Controllers\Admin\NewOrdersController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ChatController;
use App\Http\Controllers\Admin\OldOrdersController;
use App\Http\Controllers\Admin\PaymentsController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\Admin\IntegrationsController;
use Illuminate\Http\Request;
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

Route::get('/_debugbar/assets/stylesheets', [
    'as' => 'debugbar-css',
    'uses' => '\Barryvdh\Debugbar\Controllers\AssetController@css'
]);

Route::get('/_debugbar/assets/javascript', [
    'as' => 'debugbar-js',
    'uses' => '\Barryvdh\Debugbar\Controllers\AssetController@js'
]);

Route::get('/clear-all', function () {
    Artisan::call('cache:clear');

    Artisan::call('config:clear');

    Artisan::call('view:clear');

    Artisan::call('route:clear');

    echo "All cache/config/view/route cleared...";
});


Route::get('/', function () {
    return redirect()->route('home');
});

Route::get('/', [App\Http\Controllers\User\HomeController::class, 'index'])->name('user.home');

Route::match(['get', 'post'], '/{domain_code}/login', [App\Http\Controllers\MainController::class, 'restaurantAdminLogin'])->name('restaurantAdminLogin');

Route::get('/login-notice', [App\Http\Controllers\MainController::class, 'loginNotice'])->name('loginNotice');

Auth::routes(['register' => false]);




Route::group(['prefix' => '/super-admin'], function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('super-admin.dashboard');
});

/* Route::get('/', [MainController::class, 'panelRegistration'])->name('panelRegistration'); */
Route::get('/restaurant-registration', [MainController::class, 'panelRegistration'])->name('panelRegistration');
Route::post('/storePanelRegistration', [MainController::class, 'storePanelRegistration'])->name('storePanelRegistration');


Route::post('/paymentCallback', [App\Http\Controllers\User\WebhookController::class, 'paymentCallback']);

Route::middleware(['localization'])->group(function () {
    Route::get('privacy-policy', [App\Http\Controllers\User\CMSController::class, 'privacyPolicy'])->name('privacy-policy');
    Route::get('terms', [App\Http\Controllers\User\CMSController::class, 'terms'])->name('terms');

    Route::get('google/auth', [App\Http\Controllers\User\AuthController::class, 'redirectToGoogle']);
    Route::get('google/auth/callback', [App\Http\Controllers\User\AuthController::class, 'handleGoogleCallback']);

    Route::group(['prefix' => '/user'], function () {
        Route::get('/dashboard/{cat_id?}', [App\Http\Controllers\User\HomeController::class, 'dashboard'])->name('user.dashboard');
        Route::get('/dashboard-new/{cat_id?}', [App\Http\Controllers\User\HomeController::class, 'dashboardNew'])->name('user.dashboardNew');
        Route::post('/login', [App\Http\Controllers\User\AuthController::class, 'login']);
        Route::post('/signup', [App\Http\Controllers\User\AuthController::class, 'signup']);
        Route::post('/forgot-password', [App\Http\Controllers\User\AuthController::class, 'forgotPassword'])->name('forgot-password');
        Route::get('/delete-address/{id}', [App\Http\Controllers\User\AddressController::class, 'deleteAddress']);
        Route::get('/add-to-cart/{id}', [App\Http\Controllers\User\CartController::class, 'addToCart']);
        Route::get('/get-dish-details/{id}/{doesExist}', [App\Http\Controllers\User\DishController::class, 'getDishDetails']);

        Route::post('/add-cart/{id}', [\App\Http\Controllers\User\CartController::class, 'addCustomizedDish']);
    });

    Route::get('/home', [App\Http\Controllers\User\HomeController::class, 'index'])->name('user.home');

    Route::get('email/verify/{id}', [App\Http\Controllers\User\VerificationController::class, 'verify'])->name('verification.verify');
    Route::post('/favorite', [App\Http\Controllers\User\DishController::class, 'favorite']);
    Route::post('/unFavorite', [App\Http\Controllers\User\DishController::class, 'unFavorite']);
    Route::post('/validateZipcode', [App\Http\Controllers\User\AddressController::class, 'validateZipcode']);
    Route::post('/takeawayPhone', [App\Http\Controllers\User\AddressController::class, 'takeawayPhone']);
    Route::post('/dish/searchDish', [DishController::class, 'searchDish']);
    Route::get('/get-dishes/{cat_id}', [App\Http\Controllers\User\DishController::class, 'getDishes']);

});

Auth::routes(['register' => false]);

Route::get('change-lang/{lang}', function ($lang) {
    session(['Accept-Language' => $lang]);
    return redirect()->back();
})->name('app.setLocal');

Route::get('change-theme/{theme}', function ($currency) {
    session(['theme' => $currency]);
    return redirect()->back();
});

Route::middleware(['auth', 'localization'])->group(function () {
    // dashboard route
    Route::get('dashboard', [HomeController::class, 'dashboard'])->name('dashboard');
    Route::get('dashboard/statistics', [HomeController::class, 'getDashboardStatistics'])->name('dashboard.statistics');

    // Restaurant Menu Routes
    Route::group(['prefix' => '/menu'], function () {

        Route::get('', [HomeController::class, 'index'])->name('home');
        Route::get('/add-dish', [DishController::class, 'create'])->name('addDish');
        Route::get('/edit-dish/{dish}', [DishController::class, 'edit'])->name('editDish');

        Route::group(['prefix' => '/dish'], function () {
            Route::post('/getIngredientList/{dish}', [DishController::class, 'ingredientDishBased']);
            Route::post('/addIngredient/{dish}', [DishController::class, 'addDishIngredient']);
            Route::patch('/updateIngredient/{dish}', [DishController::class, 'updatePaidIngredient']);
            Route::delete('/deleteIngredient/{dish}', [DishController::class, 'deleteDishIngredient']);
            Route::post('/updateDish/{dish}', [DishController::class, 'updateDishData']);
        });

        Route::get('/dish/popular', [DishController::class, 'popularDish'])->name('dish.popular');
        Route::get('/dish/best-seller', [DishController::class, 'bestSellerDish'])->name('dish.bestseller');
        Route::resource('/dish', DishController::class);

        Route::group(['prefix' => '/ingredients'], function () {
            Route::get('/checkAttachedDish/{ingredient}', [IngredientController::class, 'checkAttachedDish']);
            Route::post('/update-status/{ingredient}', [IngredientController::class, 'updateIngredientStatus']);
            Route::post('/update/{ingredient}', [IngredientController::class, 'updateIngredient']);
            Route::post('/ing-cat-wise/{ingredient}', [IngredientController::class => 'ingredientCategoryWise']);
            Route::post('/updateingredientRowOrder', [IngredientController::class, 'updateingredientRowOrder']);
        });

        Route::get('/ingredients/category/checkItems/{category}', [IngredientCategoryController::class, 'checkAttachedItems']);
        Route::post('/ingredients/category/updateCategoryRowOrder', [IngredientCategoryController::class, 'updateCategoryRowOrder']);

        Route::resource('/ingredients/category', IngredientCategoryController::class, [
            'as' => 'ingred'
        ]);

        Route::resource('/ingredients', IngredientController::class);

        // Dish option category route
        Route::resource('/dish-option', DishOptionsController::class);
        Route::group(['prefix' => '/dish-option'], function () {
            Route::post('/update/{dish_option_id}', [DishOptionsController::class, 'updateDishCategoryOption']);
            Route::post('/update-status/{dish_option_id}', [DishOptionsController::class, 'updateDishCategoryOptionStatus']);
            Route::post('/updateDishCategoryOptionRowOrder', [DishOptionsController::class, 'updateDishCategoryOptionRowOrder']);
            Route::get('/checkAttachedDish/{dish_option_id}', [DishOptionsController::class, 'checkAttachedDish']);
//            Route::post('/update/{ingredient}', [DishOptionsController::class, 'updateIngredient']);
        });
        Route::resource('/dish-options/category', DishOptionCategoryController::class, [
            'as' => 'dishOption'
        ]);
        Route::post('/dish-options/category/updateCategoryRowOrder', [DishOptionCategoryController::class, 'updateCategoryRowOrder']);
        Route::get('/dish-options/category/checkItems/{category}', [DishOptionCategoryController::class, 'checkAttachedItems']);
    });
    // Restaurant Menu Routes


    // Restaurant Setting Routes
    Route::group(['prefix' => '/settings'], function () {
        Route::get('/', [SettingController::class, 'index'])->name('settings');
        Route::get('/delete-zipcode', [SettingController::class, 'deleteZipcode']);
        Route::post('/change-status', [SettingController::class, 'changeStatus']);
        Route::post('/save-zipcode', [SettingController::class, 'saveZipcode']);
        Route::post('/save-content', [SettingController::class, 'saveContent']);
        Route::post('/change-password', [SettingController::class, 'changePassword'])->name('change.password');
        Route::post('/save-profile', [SettingController::class, 'saveProfile'])->name('settings.save-profile');
        Route::post('/update-checkout-setting', [SettingController::class, 'updatePaymentSetting'])->name('settings.update-checkout-setting');
        Route::post('/change-refund-status', [SettingController::class, 'changeRefundStatus'])->name('settings.change-refund-status');
    });
    Route::post('/update-notification-sound', [SettingController::class, 'updateNotificationSound'])->name('updateNotificationSound');

    // Domain Setting route
    Route::get('/domain-setting', [DomainSettingController::class, 'index'])->name('domainSetting.index');
    // Domain Setting route

    Route::resource('/banners', BannerController::class);
    Route::group(['prefix' => '/banners'], function () {
        Route::get('/checkAttachedDish/{bannerId}', [BannerController::class, 'checkAttachedDish']);
        Route::post('/update-status/{bannerId}', [BannerController::class, 'updateBannerStatus']);
        Route::post('/update/{bannerId}', [BannerController::class, 'updateBanner']);
        Route::post('/ing-cat-wise/{bannerId}', [BannerController::class => 'ingredientCategoryWise']);
        Route::post('/updateingredientRowOrder', [BannerController::class, 'updateingredientRowOrder']);
        Route::post('/updateBannerRowOrder', [BannerController::class, 'updateBannerRowOrder']);
    });




    Route::group(['prefix' => '/my-website'], function () {
        Route::get('/', [MyWebsiteController::class, 'index'])->name('myWebsite');
    });
    // Restaurant Setting Routes

    // Restaurant Coupons Routes
    Route::group(['prefix' => '/coupons'], function () {
        Route::get('/claim-history', [CouponController::class, 'claimHistoryLog'])->name('claimHistoryLog');
        Route::post('/change-status', [CouponController::class, 'changeStatus']);
    });
    Route::resource('/coupons', CouponController::class);
    // Restaurant Coupons Routes

    // Restaurant Category Routes
    Route::get('/category/checkDishes/{category}', [CategoryController::class, 'checkDishCategory']);
    Route::resource('/category', CategoryController::class);
    Route::post('/category/update/sort-order', [CategoryController::class, 'updateCategorySortOrder']);
    // Restaurant Category Routes

    Route::get('/chat', [ChatController::class, 'index'])->name('chat');
    Route::get('/chat/messages/{senderId}', [ChatController::class, 'getMessages'])->name('get_messages');
    Route::get('/chat/users', [ChatController::class, 'getChatUsersList'])->name('chat_users');
    Route::post('/chat/attachment/store', [ChatController::class, 'storeAttachment'])->name('storeAttachment');
    Route::get('/chat/search-chat', [ChatController::class, 'searchChat']);
    Route::post('/chat/store', [ChatController::class, 'storeMessage']);

    // old order pages route
    Route::get('/orders/not-notified-orders', [OldOrdersController::class, 'getNotNotifiedOrders'])->name('notNotifiedOrder');
    Route::get('/orders-old/{date_filter?}', [OldOrdersController::class, 'index'])->name('ordersOld');
    Route::get('/orders/print-label-old/{order_id}', [OldOrdersController::class, 'orderPrintLabel'])->name('orders.printLabel');
    Route::get('/orders/change-status-old/{id}', [OldOrdersController::class, 'changeStatus']);
    Route::get('/orders/order-detail-old/{order_id}', [OldOrdersController::class, 'orderDetail'])->name('order-detail');
    Route::post('/orders/searchOrder', [OldOrdersController::class, 'searchOrder'])->name('searchOrder');
    Route::post('/orders/getRealTimeOrderOld', [OldOrdersController::class, 'getRealTimeOrder'])->name('getRealTimeOrderOld');


    Route::get('/payments', [PaymentsController::class, 'index'])->name('payments')->middleware('CheckMyFinanceValidate');

    // New Orders Controller
    Route::get('/orders/{date_filter?}', [NewOrdersController::class, 'index'])->name('orders');
    Route::post('/orders/getRealTimeOrder', [NewOrdersController::class, 'getRealTimeOrder'])->name('getRealTimeOrder');
    Route::get('/orders/order-detail/{order_id}', [NewOrdersController::class, 'orderDetail'])->name('order-detail');
    Route::get('/orders/change-status/{id}/{order_status}', [NewOrdersController::class, 'changeStatusNew']);
    Route::get('/add-deliverer/{order_id}/{deliverer_id}', [NewOrdersController::class, 'addDeliverer']);
    Route::post('/save-order-setting', [NewOrdersController::class, 'updateOrderSetting'])->name('updateOrderSetting');
    Route::post('/update-display-order-setting', [NewOrdersController::class, 'updateDisplayOrderSetting'])->name('updateOrderSetting');
    Route::post('/update-delivery-time', [NewOrdersController::class, 'updateDeliveryTime'])->name('updateDeliveryTime');
    Route::post('/update-wished-time', [NewOrdersController::class, 'updateWishedTime'])->name('updateWishedTime');
    Route::get('/get-order-setting', [NewOrdersController::class, 'getOrderSetting'])->name('getOrderSetting');
    Route::get('/orders/print-label/{order_id}', [NewOrdersController::class, 'orderPrintLabel'])->name('orders.printLabel');
    Route::get('/cancel-order/{order_id}/{status}', [NewOrdersController::class, 'cancelOrder'])->name('orders.cancelOrder');
    Route::get('/save-reset', [NewOrdersController::class, 'saveReset'])->name('saveReset');
    Route::get('/orders-map', [NewOrdersController::class, 'ordersMap'])->name('ordersMap');

    Route::post('/set-per-page', function (Request $request) {
        $request->session()->put('per_page', $request->input('per_page'));
        return response()->json(['success' => true]);
    });

    //    manual order routes
    Route::get('/create-order', [ManualOrdersController::class, 'index'])->name('create-order');
    Route::get('/get-dish/{cat_id}', [ManualOrdersController::class, 'getDishes']);
    Route::post('/custom-add-cart/{id}', [ManualOrdersController::class, 'addCustomizedDishCustom']);
    Route::post('/custom-update-dish-qty', [ManualOrdersController::class, 'updateDishQty']);
    Route::get('/get-dish-details/{id}/{doesExist}', [DishController::class, 'getDishDetails']);
    Route::post('/create-customer', [ManualOrdersController::class, 'createCustomer']);


    //    Integrations order routes
    Route::get('/integrations', [IntegrationsController::class, 'index'])->name('integrations');

    // customer order routes
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers');

    //  deliverers routes
    Route::resource('deliverers', DeliverersController::class);
    Route::post('deliverers/status-change', [DeliverersController::class, 'changeStatus']);


    // Archive Order Route
    Route::get('/archive/{date_filter?}', [OldOrdersController::class, 'archiveOrders'])->name('archives');
    Route::get('/archive/order-detail/{order_id}', [OldOrdersController::class, 'archiveOrderDetail'])->name('archive-order-detail');
    Route::post('/archive/searchOrder', [OldOrdersController::class, 'archiveSearchOrder'])->name('archiveSearchOrder');



    Route::get('/ingredients/category/checkItems/{category}', [IngredientCategoryController::class, 'checkAttachedItems']);

    // User Routes
    Route::get('/validate-myfinance', [PaymentsController::class, 'validateMyFinance'])->name('validateMyFinance');
    Route::post('/check-myfinance-password', [PaymentsController::class, 'checkMyFinancePassword'])->name('checkMyFinancePassword');

});

Route::middleware(['auth', 'auth.user', 'localization'])->group(function () {
    Route::group(['prefix' => '/user'], function () {
        Route::get('/settings', [App\Http\Controllers\User\SettingController::class, 'index'])->name('user.settings');
        Route::post('/settings/save-profile', [App\Http\Controllers\User\SettingController::class, 'saveProfile'])->name('user.settings.save-profile');
        Route::get('/favorite', [App\Http\Controllers\User\DishController::class, 'getFavoriteDishes'])->name('user.favorite');
        Route::get('/points', [App\Http\Controllers\User\DishController::class, 'getCollectedPoints'])->name('user.points');

        // Route::get('/coupons', [App\Http\Controllers\User\CouponController::class, 'index'])->name('user.coupons');

        // new coupons scenario
        Route::get('/coupons', [App\Http\Controllers\User\CouponController::class, 'coupons'])->name('user.coupons');

        Route::get('/coupons/confirm/{id}', [App\Http\Controllers\User\CouponController::class, 'confirm']);

        Route::get('/orders/{order_id?}', [App\Http\Controllers\User\OrderController::class, 'index'])->name('user.orders');
        // use for show order details on track order back button
        Route::get('/order/order-detail/{order_id?}', [App\Http\Controllers\User\OrderController::class, 'ordersDetailMobile'])->name('user.ordersDetailMobile');

        Route::get('/orders/order-detail/{order_id}', [App\Http\Controllers\User\OrderController::class, 'orderDetail'])->name('user.order-detail');
        Route::get('/orders/download-invoice/{order_id}', [App\Http\Controllers\User\OrderController::class, 'downloadInvoice'])->name('user.download-invoice');
        Route::get('/orders/print-label/{order_id}', [App\Http\Controllers\User\OrderController::class, 'orderPrintLabel'])->name('user.orders.printLabel');

        Route::post('/orders/send-refund-req', [App\Http\Controllers\User\OrderController::class, 'sendRefundRequest']);

//        Route::get('/order-location/{order_id}', [App\Http\Controllers\User\OrderController::class, 'orderLocation'])->name('user.order-location');
        Route::get('/order-location/{order_id}', [App\Http\Controllers\User\OrderController::class, 'orderLocationNew'])->name('user.order-location-new');
        Route::post('/update-dish-qty', [App\Http\Controllers\User\CartController::class, 'updateDishQty']);
        Route::get('/chat', [App\Http\Controllers\User\ChatController::class, 'index'])->name('user.chat');
        Route::post('/chat/store', [App\Http\Controllers\User\ChatController::class, 'storeMessage'])->name('user.store');
        Route::post('/chat/store/attachment', [App\Http\Controllers\User\ChatController::class, 'storeAttachment'])->name('user.storeAttachment');
        Route::get('/checkout', [App\Http\Controllers\User\CheckoutController::class, 'index'])->name('user.checkout');
        Route::get('/ideal-payment', [App\Http\Controllers\User\CheckoutController::class, 'idealPayment'])->name('user.ideal');
        Route::get('/card-payment', [App\Http\Controllers\User\CheckoutController::class, 'cardPayment'])->name('user.card');

        Route::post('/coupon/apply', [App\Http\Controllers\User\CouponController::class, 'apply']);
        Route::patch('/remove-coupon', [App\Http\Controllers\User\CouponController::class, 'removeCoupon']);

        Route::delete('/cart/remove-dish/{cart_dish_id}', [\App\Http\Controllers\User\CartController::class, 'removeCartDish']);
        Route::patch('/cart/update-delivery-type', [\App\Http\Controllers\User\CartController::class, 'updateDeliveryType']);
        Route::post('/validate-cart', [\App\Http\Controllers\User\CartController::class, 'validateCart']);
        Route::post('/place-order', [\App\Http\Controllers\User\CheckoutController::class, 'placeOrderData']);

        Route::get('/validate-address/{address_id}', [\App\Http\Controllers\User\AddressController::class, 'validateSelectedAddress']);
        Route::get('/redirect-online-payment', [\App\Http\Controllers\User\CheckoutController::class, 'redirectedOnlinePayment']);

        Route::patch('/cart/update-notes/{dish_id}', [\App\Http\Controllers\User\CartController::class, 'updateDishNotes']);
        Route::patch('/cart/update-del-ins', [\App\Http\Controllers\User\CartController::class, 'updateDeliveryNotes']);
        Route::get('/chat/users', [App\Http\Controllers\User\ChatController::class, 'getMessages'])->name('chat_users');
    });
});
