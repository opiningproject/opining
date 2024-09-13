<?php $__env->startSection('content'); ?>

    <?php
    $zipcode = session('zipcode');
    $house_no = session('house_no');
    $street_name = session('street_name');
    $city = session('city');
    $min_order_price = session('min_order_price');
    $delivery_charge = session('delivery_charge');
    $showModal = 0;
    
    if (!session('showLoginModal')) {
        $showModal = 1;
        Session::put('showLoginModal', '1', '1440');
    }
    
    $cartValue = 0;
    $dishOptionCategoryTotalAmount = 0;
    
    ?>
    <div class="main">
        <div class="main-view">
            <div class="container-fluid bd-gutter bd-layout">
                <?php echo $__env->make('layouts.user.side_nav_bar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <main class="bd-main content-main-part">
                    <div class="main-content">
                        <div class="section-page-title main-page-title row justify-content-between">
                            <div class="col-xxl-6 col-xl-6 col-lg-5 col-md-6 col-sm-6 col-12">
                                <h1 class="page-title"><?php echo e(trans('user.dashboard.title')); ?></h1>
                            </div>
                            <div
                                class="searcheaderBox d-none d-md-flex align-items-center form-group mb-0 has-search position-relative searcheatbox col-xxl-4 col-xl-4 col-lg-7 col-md-6 col-sm-12 col-12 text-end">
                                <button type="button"
                                    class="btn-close d-block position-absolute d-md-none top-0 mt-2 end-0 me-2"
                                    id="closeSearch"></button>
                                <div class="position-relative w-100">
                                    <span class="form-control-feedback">
                                        <img class="svg" src="<?php echo e(asset('images/search-icon-up.svg')); ?>" alt=""
                                            height="18" width="18">
                                    </span>
                                    <input type="text" class="form-control text-transform-none form-control-icon ps-5"
                                        placeholder="<?php echo e(trans('user.dashboard.search')); ?>" id="search-dish" />
                                </div>
                                <button
                                    class="navbar-toggler bag-count d-flex  dashboard-cart-navbar-toggler cart-navbar-toggler ms-2 p-0 d-none"
                                    type="button" data-bs-toggle="offcanvas" data-bs-target="#bdSidebarCart"
                                    aria-controls="bdSidebarCart" aria-label="Toggle docs navigation">
                                    <span class="count"
                                        id="cart-item-count"><?php echo e(isset(Auth::user()->cart) ? Auth::user()->cart->dishDetails->count() : 0); ?></span>
                                    <svg width="26px" height="26px" viewBox="-4 0 32 32" version="1.1"
                                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                                        <defs></defs>
                                        <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"
                                            sketch:type="MSPage">
                                            <g id="Icon-Set" sketch:type="MSLayerGroup"
                                                transform="translate(-572.000000, -723.000000)" fill="#FFC00B">
                                                <path
                                                    d="M594,747 L574,747 L574,731 C574,729.896 574.896,729 576,729 L578,729 L578,735 L580,735 L580,729 L588,729 L588,735 L590,735 L590,729 L592,729 C593.104,729 594,729.896 594,731 L594,747 L594,747 Z M594,751 C594,752.104 593.104,753 592,753 L576,753 C574.896,753 574,752.104 574,751 L574,749 L594,749 L594,751 L594,751 Z M584,725 C586.209,725 588,725.619 588,727 L580,727 C580,725.619 581.791,725 584,725 L584,725 Z M592,727 L590,727 C590,724.791 587.313,723 584,723 C580.687,723 578,724.791 578,727 L576,727 C573.791,727 572,728.791 572,731 L572,751 C572,753.209 573.791,755 576,755 L592,755 C594.209,755 596,753.209 596,751 L596,731 C596,728.791 594.209,727 592,727 L592,727 Z"
                                                    id="bag" sketch:type="MSShapeGroup"></path>
                                            </g>
                                        </g>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="banner_home_slider mb-2">
                            <div class="swiper banner-swiper-slider">
                                <div class="category-slider swiper-wrapper pt-0 pb-0">
                                    <?php $__currentLoopData = $bannerData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $bannerKey => $bannerValue): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="swiper-slide">
                                        <div class="offer-card-banner offercard-slider w-100 mb-0">
                                            <div class="card position-relative">
                                                <div class="bg-offercard-circle-1">
                                                    <img class="svg" src="<?php echo e(asset('images/ban-grade1.svg')); ?>"
                                                        alt="" width="175" height="102">
                                                </div>
                                                <div class="bg-offercard-circle-2">
                                                    <img class="svg" src="<?php echo e(asset('images/ban-grade2.svg')); ?>"
                                                        alt="" width="285" height="114">
                                                </div>
                                                <div class="bg-offercard-circle-3">
                                                    <img class="svg" src="<?php echo e(asset('images/ban-grade3.svg')); ?>"
                                                        alt="" width="175" height="144">
                                                </div>
                                                <div class="card-body">
                                                    <div class="text-content">
                                                        <h2><?php echo e($bannerValue->content); ?></h2>
                                                        <a href="#"
                                                            class="btn btn-site-theme fw-400 text-uppercase font-sebibold">See
                                                            How</a>
                                                    </div>

                                                    <div class="img-content">
                                                        <img src="<?php echo e($bannerValue->image); ?>"
                                                            alt="Banner Slider One" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                    
                                </div>
                            </div>
                            <div class="swiper-pagination"></div>
                        </div>


                        


                        <!-- start category section -->
                        <section class="custom-section category-section pb-0 swiper-container-mobile">
                            <div class="section-page-title">
                                <h1 class="section-title"><?php echo e(trans('user.dashboard.category')); ?></h1>
                            </div>
                            <div class="swiper-container">
                                <div class="category-slider-navigation">
                                    <!-- Add Arrows -->
                                    <div class="swiper-button-prev"></div>
                                    <div class="swiper-button-next"></div>
                                </div>
                                <div class="swiper category-swiper-slider">
                                    <div class="category-slider swiper-wrapper pt-0">
                                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                            $selected = '';
                                            
                                            if (!isset($_GET['all']) && $cat_id == '') {
                                                if ($key == 0) {
                                                    $selected = 'selected-cart-active';
                                                }
                                            } else {
                                                if ($cat_id == $cat->id) {
                                                    $selected = 'selected-cart-active';
                                                }
                                            }
                                            ?>
                                            <div class="category-element swiper-slide <?php echo e($selected); ?>"
                                                data-category-id=<?php echo e($cat->id); ?>>
                                                <div class="card shadow-mobile">
                                                    <span class="dish-item-icon">
                                                        <img src="<?php echo e($cat->image); ?>" class="img-fluid svg"
                                                            alt="bakery" width="56" height="56" />
                                                    </span>
                                                    <p class="mb-0 text-truncate text-muted" title="<?php echo e($cat->name); ?>">
                                                        <?php echo e($cat->name); ?>

                                                    </p>
                                                    <a href="javascript:void(0)" onclick="getDishes(<?php echo e($cat->id); ?>)"
                                                         class="stretched-link"></a>
                                                </div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <!-- end category section -->
                        <!-- start category list section -->
                        <section
                            class="custom-section category-list-section pb-0 scrollable-tap dashboard-custom pt-3 pt-lg-4">
                            <div class="section-page-title">
                                <h1 class="section-title dish-list"><?php echo e($category ? $category->name : ''); ?></h1>
                                <!--                            <a href="<?php echo e(route('user.dashboard')); ?>?all=1" type="button" class="viewall-btn"><?php echo e(trans('user.button.view_all')); ?>

                                                                    <span>
                                                                        <img src="<?php echo e(asset('images/view.svg')); ?>" alt="" class="svg" height="24" width="24">
                                                                                                                        </span>
                                                                                                                    </a>-->
                            </div>
                            <div class="dish-details-div">
                                <div class="category-list-item-grid">
                                    <?php if(count($dishes) > 0): ?>
                                        <?php $__currentLoopData = $dishes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dish): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                            $disableBtn = '';
                                            $customizeBtn = false;
                                            
                                            //                                        if ($dish->qty == 0 || $dish->out_of_stock == '1') {
                                            if ($dish->out_of_stock == '1') {
                                                $disableBtn = 'disabled';
                                                $customizeBtn = true;
                                            }
                                            
                                            if (count($dish->ingredientsWithoutTrash) == 0) {
                                                $customizeBtn = true;
                                            }
                                            
                                            ?>
                                            <div class="card food-detail-card shadow-mobile">
                                                <?php if($dish->percentage_off > 0): ?>
                                                    <p class="mb-0 offer-percantage">
                                                        <?php echo e($dish->percentage_off); ?>%
                                                    </p>
                                                <?php endif; ?>
                                                <p class="mb-0 food-favorite-icon <?php echo e(isset($dish->favorite) ? 'd-none' : ''); ?>"
                                                    onclick="favorite(<?php echo e($dish->id); ?>)"
                                                    id="unfavorite-icon-<?php echo e($dish->id); ?>">
                                                    <img src="<?php echo e(asset('images/favorite-before-icon.svg')); ?>"
                                                        alt="" class="svg" height="20" width="22">
                                                </p>
                                                <p class="mb-0 food-favorite-icon <?php echo e(isset($dish->favorite) ? '' : 'd-none'); ?>"
                                                    onclick="unFavorite(<?php echo e($dish->id); ?>)"
                                                    id="favorite-icon-<?php echo e($dish->id); ?>">
                                                    <img src="<?php echo e(asset('images/favorite-after-icon-up.svg')); ?>"
                                                        alt="" class="svg" height="20" width="22">
                                                </p>

                                                <div class="food-image">
                                                    <img src="<?php echo e($dish->image); ?>" alt="burger imag" class="img-fluid"
                                                        width="100" height="100" />
                                                </div>
                                                <h4 class="food-name-text"><?php echo e($dish->name); ?></h4>
                                                

                                                <button type="button" class="btn btn-xs-sm btn-site-theme"
                                                    onclick="customizeDish(<?php echo e($dish->id); ?>)" <?php echo e($disableBtn); ?>

                                                    id="dish-cart-lbl-<?php echo e($dish->id); ?>">
                                                    
                                                    <?php if($dish->out_of_stock == '1'): ?>
                                                        <?php echo e(trans('user.dashboard.out_of_stock')); ?>

                                                    <?php else: ?>
                                                        <img src="<?php echo e(asset('images/plus-up.svg')); ?>" class="svg"
                                                            height="9"
                                                            width="9">€<?php echo e(number_format($dish->price, 2)); ?>

                                                    <?php endif; ?>
                                                </button>

                                                <?php if(!$customizeBtn): ?>
                                                    <label class="customize-foodlink">
                                                        <?php echo e(trans('user.dashboard.customizable')); ?>

                                                    </label>
                                                <?php endif; ?>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                        <?php echo e(trans('user.dashboard.no_dish_found')); ?>

                                    <?php endif; ?>
                                </div>
                            </div>

                            <div class="bottom-sticky">
                                <a href="javascript:void(0)" class="scroll-top" id="scroll-top">
                                    <svg width="18" height="12" viewBox="0 0 18 12" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M8.99436 3.16394C7.44245 4.87833 5.91867 6.56167 4.39488 8.24432C3.73237 8.9759 3.07548 9.71508 2.40421 10.437C1.92795 10.9498 1.21106 10.7545 1.03418 10.0788C0.944182 9.73648 1.03668 9.44246 1.25544 9.19469C1.55357 8.85719 1.85733 8.52591 2.15921 8.19255C4.19113 5.9481 6.22305 3.70297 8.25497 1.45852C8.8081 0.847711 9.19374 0.845641 9.7425 1.4523C12.0394 3.98939 14.3357 6.52785 16.6345 9.06286C16.9002 9.35619 17.0864 9.66746 16.9589 10.103C16.782 10.7062 16.1439 10.925 15.6939 10.535C15.6045 10.457 15.5258 10.3632 15.4451 10.2741C13.3832 7.99792 11.3219 5.72035 9.25999 3.44415C9.17999 3.35581 9.09686 3.2723 8.99498 3.16463L8.99436 3.16394Z"
                                            fill="#292929" stroke="#292929" />
                                    </svg>
                                </a>
                            </div>

                        </section>
                        <!-- end category list section -->
                    </div>
                </main>
                <aside class="cart-sidebar sticky-top h-lg-100vh cartSidebarCustom">
                    <div class="offcanvas-xxl offcanvas-end h-100 overflow-auto cartoffCanvas" tabindex="-1"
                        id="bdSidebarCart" aria-labelledby="bdSidebarCartOffcanvasLabel">
                        <div class="offcanvas-header p-0" style="display: block"></div>
                        <div class="offcanvas-body position-relative space-for-close pb-xxl-3">
                            <h4
                                class="d-block position-absolute d-xxl-none start-0 top-0 pt-2 d-xxl-none text-center end-0 mx-auto head-title top-head-title">
                                <?php echo e(trans('user.cart.title')); ?> </h4>
                            <button type="button"
                                class="btn-close d-block position-absolute d-xxl-none top-0 mt-1 me-md-2 mt-md-2 end-0 ms-2 bg-arrow-mobile"
                                data-bs-dismiss="offcanvas" aria-label="Close" data-bs-target="#bdSidebarCart">
                                <i class="fa-solid fa-angle-left d-none"></i>
                            </button>
                            <div class="navbar navbar-expand-lg pt-3 pt-xxl-0 h-lg-100">
                                <div class="cart-sidebar-content position-relative h-100">
                                    <div class="navbar-collapse cartbox-collapse h-100">
                                        <div class="cart-custom-tab cart-tab custom-tabs d-flex flex-column h-100">
                                            <!--                                            <ul class="nav nav-fill nav-fillMobile cart-top-tab" id="pills-tab"
                                                                                    role="tablist">
                                                                                    <li class="nav-item delivery-tab" role="presentation">
                                                                                        <button
                                                                                            class="nav-link <?php echo e($zipcode || ($user != '' && $user->cart && $user->cart->order_type == 1) ? 'active' : ''); ?> pills-delivery-tab delivery-tab"
                                                                                            id="pills-home-tab" data-bs-toggle="pill"
                                                                                            data-type="<?php echo e(\App\Enums\OrderType::Delivery); ?>"
                                                                                            data-bs-target="#pills-home" type="button" role="tab"
                                                                                            aria-controls="pills-home" aria-selected="true">
                                                                                            <img src="<?php echo e(asset('images/scoter1.svg')); ?>" alt=""
                                                                                                class="svg" height="23" width="26" />
                                                                                            <div class="btn-text">
                                                                                                <?php echo e(trans('user.cart.delivery')); ?>

                                                                                <span> <?php echo e($deliveryTime); ?></span>
                                                                                            </div>
                                                                                        </button>

                                                                                        <input type="hidden" value="<?php echo e($house_no); ?>" id="del-house-no">
                                                                                        <input type="hidden" value="<?php echo e($zipcode); ?>" id="del-zipcode">
                                                                                    </li>
                                                                                    <li class="nav-item TakeAway-tab" role="presentation">
                                                                                        <button
                                                                                            class="nav-link <?php echo e(!$zipcode && ($user != '' && $user->cart && $user->cart->order_type == 2) ? 'active' : ''); ?> pills-delivery-tab TakeAway-tab"
                                                                                            id="pills-profile-tab" data-bs-toggle="pill"
                                                                                            data-type="<?php echo e(\App\Enums\OrderType::TakeAway); ?>"
                                                                                            data-bs-target="#pills-profile" type="button" role="tab"
                                                                                            aria-controls="pills-profile" aria-selected="false">
                                                                                            <img src="<?php echo e(asset('images/takeaway-icon.svg')); ?>" alt=""
                                                                                                class="svg" height="23" width="23" />

                                                                                            <div class="btn-text">
                                                                                                <?php echo e(trans('user.cart.take_away')); ?>

                                                                                <span> <?php echo e($takeAwayTime); ?></span>
                                                                                            </div>
                                                                                        </button>

                                                                                    </li>
                                                                                </ul>-->
                                            <ul class="nav nav-fill nav-fillMobile cart-top-tab" id="pills-tab"
                                                role="tablist">
                                                <li class="nav-item delivery-tab" role="presentation">
                                                    <button
                                                        class="nav-link <?php echo e($zipcode || ($user && $user->cart && $user->cart->order_type == 1) ? 'active' : ''); ?> pills-delivery-tab delivery-tab"
                                                        id="pills-home-tab" data-bs-toggle="pill"
                                                        data-type="<?php echo e(\App\Enums\OrderType::Delivery); ?>"
                                                        data-bs-target="#pills-home" type="button" role="tab"
                                                        aria-controls="pills-home" aria-selected="true">
                                                        <img src="<?php echo e(asset('images/scoter1.svg')); ?>" alt=""
                                                            class="svg" height="23" width="26" />
                                                        <div class="btn-text">
                                                            <?php echo e(trans('user.cart.delivery')); ?>

                                                            <span> <?php echo e($deliveryTime); ?></span>
                                                        </div>
                                                    </button>

                                                    <input type="hidden" value="<?php echo e($house_no); ?>" id="del-house-no">
                                                    <input type="hidden" value="<?php echo e($zipcode); ?>" id="del-zipcode">
                                                </li>
                                                <li class="nav-item TakeAway-tab" role="presentation">
                                                    <button
                                                        class="nav-link <?php echo e(!$zipcode && (!$user || !$user->cart || $user->cart->order_type == 2) ? 'active' : ''); ?> pills-delivery-tab TakeAway-tab"
                                                        id="pills-profile-tab" data-bs-toggle="pill"
                                                        data-type="<?php echo e(\App\Enums\OrderType::TakeAway); ?>"
                                                        data-bs-target="#pills-profile" type="button" role="tab"
                                                        aria-controls="pills-profile" aria-selected="false">
                                                        <img src="<?php echo e(asset('images/takeaway-icon.svg')); ?>" alt=""
                                                            class="svg" height="23" width="23" />
                                                        <div class="btn-text">
                                                            <?php echo e(trans('user.cart.take_away')); ?>

                                                            <span> <?php echo e($takeAwayTime); ?></span>
                                                        </div>
                                                    </button>
                                                </li>
                                            </ul>

                                            <div class="d-flex flex-column flex-fill tab-content" id="pills-tabContent">
                                                <div class="pills-home tab-pane fade <?php echo e($zipcode || ($user && $user->cart && $user->cart->order_type == 1) ? 'show active' : ''); ?>"
                                                    id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab"
                                                    tabindex="0">

                                                    <div class="text-center d-flex justify-content-center">
                                                        <div class="cart-address-row w-100" style="cursor: pointer;"
                                                            data-bs-toggle="modal" data-bs-target="#addressChangeModal">
                                                            <img src="<?php echo e(asset('images/location-yellowicon-up.svg')); ?>"
                                                                alt="" class="svg" height="20"
                                                                width="20" />
                                                            <p id="zip_address" class="mb-0">
                                                                <?php if($street_name): ?>
                                                                    <?php echo e(($street_name ? $street_name : '') . ' ' . ($house_no ? $house_no : '')); ?>

                                                                <?php else: ?>
                                                                    <?php echo e($house_no ? $house_no . ', ' . $zipcode : ''); ?>

                                                                <?php endif; ?>
                                                            </p>
                                                        </div>
                                                    </div>

                                                    
                                                </div>

                                                <div class="tab-pane fade <?php echo e(!$zipcode && (!$user || !$user->cart || $user->cart->order_type == 2) ? 'show active' : ''); ?>"
                                                    id="pills-profile" role="tabpanel"
                                                    aria-labelledby="pills-profile-tab" tabindex="0">
                                                    <div class="form-group addressMobile cart-address-row flex-wrap w-100">

                                                        <div
                                                            class="d-flex align-items-center justify-content-center flex-full">
                                                            <div class="d-flex align-items-start address-field">
                                                                <img src="<?php echo e(asset('images/house-icon-up.svg')); ?>"
                                                                    alt="" class="svg" height="16"
                                                                    width="16">
                                                                <p class="mb-0 d-inline-block mt-0 ms-2">
                                                                    <?php echo e(getRestaurantDetail()->rest_address); ?> </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php if($user && $user->id): ?>
                                                    <!-- End address section & start cart section -->


                                                    <div class="cart-items-list">
                                                        <div class="cart-items-list-row">
                                                            <div class="cart-items">
                                                                <?php if(count($cart) > 0): ?>
                                                                    <?php $__currentLoopData = $cart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $dish): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <?php
                                                                        $dishOptionCategoryTotalAmount = getDishOptionCategoryTotalAmount($dish->orderDishOptionDetails->pluck('dish_option_id'));
                                                                        //                                                                        dump($dishOptionCategoryTotalAmount);
                                                                        $cartValue += $dish->qty * $dish->dish->price;
                                                                        $paidIngredient = $dish->orderDishPaidIngredients()->select(DB::raw('sum(quantity * price) as total'))->get()->sum('total');
                                                                        $cartValue += $dish->qty * $paidIngredient;
                                                                        $cartValue += $dish->qty * $dishOptionCategoryTotalAmount;
                                                                        $outOfStock = '';
                                                                        $outOfStockDisplay = 'd-none';
                                                                        //                                                                if ($dish->dish->qty == 0 || $dish->dish->out_of_stock == '1') {
                                                                        if ($dish->dish->out_of_stock == '1') {
                                                                            $outOfStock = 'nostock-card';
                                                                            $outOfStockDisplay = '';
                                                                        }
                                                                        ?>
                                                                        <div class="row stock-card mb-0 <?php echo e($outOfStock); ?>"
                                                                            id="cart-<?php echo e($dish->id); ?>">
                                                                            <div
                                                                                class="col-12 text-end d-flex align-items-center gap-2 mb-3 justify-content-end outof-stock-text <?php echo e($outOfStockDisplay); ?>">
                                                                                <strong><?php echo e(trans('user.cart.out_of_stock')); ?></strong>
                                                                                <a class="remove-cart-dish"
                                                                                    data-id="<?php echo e($dish->id); ?>"
                                                                                    data-dish-id="<?php echo e($dish->dish->id); ?>"
                                                                                    href="javascript:void(0)">
                                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                                        fill="#ff0000" viewBox="0 0 24 24"
                                                                                        width="20px" height="20px">
                                                                                        <path
                                                                                            d="M 10 2 L 9 3 L 4 3 L 4 5 L 5 5 L 5 20 C 5 20.522222 5.1913289 21.05461 5.5683594 21.431641 C 5.9453899 21.808671 6.4777778 22 7 22 L 17 22 C 17.522222 22 18.05461 21.808671 18.431641 21.431641 C 18.808671 21.05461 19 20.522222 19 20 L 19 5 L 20 5 L 20 3 L 15 3 L 14 2 L 10 2 z M 7 5 L 17 5 L 17 20 L 7 20 L 7 5 z M 9 7 L 9 18 L 11 18 L 11 7 L 9 7 z M 13 7 L 13 18 L 15 18 L 15 7 L 13 7 z" />
                                                                                    </svg>
                                                                                </a>
                                                                            </div>
                                                                            <div class="col-12">
                                                                                <div class="d-flex cart-item-row">

                                                                                    <div
                                                                                        class="cart-custom-w-col-img cart-name-price px-0">
                                                                                        <div
                                                                                            class="d-flex align-items-start">
                                                                                            <p id="quantity-<?php echo e($dish->id); ?>"
                                                                                                class="item-name pe-2 mb-0 item-order">
                                                                                                <?php echo e($dish->qty); ?></p>
                                                                                            <p class="d-inline-block item-name mb-0 text-decoration-underline"
                                                                                                onclick="customizeDish(<?php echo e($dish->dish->id); ?>, <?php echo e($dish->id); ?>);">
                                                                                                <?php echo e($dish->dish->name); ?>

                                                                                            </p>
                                                                                            <?php
                                                                                                $totalAmount = getOrderDishIngredientsTotal(
                                                                                                    $dish,
                                                                                                );
                                                                                            ?>
                                                                                            <span
                                                                                                class="cart-item-price ms-auto"
                                                                                                id="cart-item-price<?php echo e($dish->id); ?>">+€<?php echo e(number_format((float) ($dish->qty * $dish->dish->price) + $paidIngredient * $dish->qty + $dishOptionCategoryTotalAmount * $dish->qty, 2)); ?></span>
                                                                                        </div>
                                                                                    </div>


                                                                                    <?php
                                                                                        /*old code comment on 13-08-2024*/
                                                                                        $htmlString = getOrderDishIngredients1(
                                                                                            $dish,
                                                                                        );
                                                                                        $cleanedHtmlString = str_replace(
                                                                                            '"',
                                                                                            '',
                                                                                            $htmlString,
                                                                                        );
                                                                                    ?>

                                                                                    <ul class="items-additional mb-2"
                                                                                        id="item-ing-desc<?php echo e($dish->id); ?>">
                                                                                        <?php echo $cleanedHtmlString; ?>

                                                                                    </ul>

                                                                                    <div
                                                                                        class="cart-custom-w-col-img d-none">
                                                                                        <img src="<?php echo e($dish->dish->image); ?>"
                                                                                            alt="<?php echo e($dish->dish->name); ?>"
                                                                                            class="img-fluid"
                                                                                            width="86"
                                                                                            height="74px" />

                                                                                    </div>

                                                                                    <div class="cart-custom-w-col-detail">
                                                                                        <div class="cart-item-detail">
                                                                                            <?php if(count($dish->orderDishOptionDetails) > 0): ?>
                                                                                                <b><span
                                                                                                        style="font-size: 14px">
                                                                                                        Options </span></b>
                                                                                                <div
                                                                                                    class="d-flex align-items-center">
                                                                                                    <?php
                                                                                                        /*old code comment on 13-08-2024*/
                                                                                                        $htmlStringDishOptionCategory =
                                                                                                            getDishOptionCategoryName(
                                                                                                                $dish->orderDishOptionDetails->pluck(
                                                                                                                    'dish_option_id',
                                                                                                                ),
                                                                                                            ) ?? '';
                                                                                                        $cleanedDishOptionHtmlString = str_replace(
                                                                                                            '"',
                                                                                                            '',
                                                                                                            $htmlStringDishOptionCategory,
                                                                                                        );
                                                                                                    ?>

                                                                                                    <ul class="items-additional mb-2"
                                                                                                        id="dish-option-<?php echo e($dish->id); ?>">
                                                                                                        <?php echo $cleanedDishOptionHtmlString; ?>

                                                                                                    </ul>
                                                                                                    
                                                                                                    
                                                                                                    
                                                                                                </div>
                                                                                            <?php endif; ?>

                                                                                            <div
                                                                                                class="d-flex cart-item-bt">

                                                                                                <div
                                                                                                    class="from-group addnote-from-group mb-0">
                                                                                                    <div class="form-group mb-0 dish-group"
                                                                                                        data-dish-id="<?php echo e($dish->id); ?>">
                                                                                                        <label
                                                                                                            for="dishnameenglish"
                                                                                                            class="form-label mb-0 dish-notes-label"><?php echo e(trans('user.cart.add_notes')); ?></label>
                                                                                                        <input
                                                                                                            type="text"
                                                                                                            data-id="<?php echo e($dish->id); ?>"
                                                                                                            maxlength="50"
                                                                                                            class="form-control dish-notes d-none"
                                                                                                            value="<?php echo e($dish->notes); ?>"
                                                                                                            placeholder="<?php echo e(trans('user.cart.type_here')); ?>" />

                                                                                                        <a href="#"
                                                                                                            class="note-close-btn d-none"
                                                                                                            data-id="<?php echo e($dish->id); ?>">

                                                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                                                id="Outline"
                                                                                                                viewBox="0 0 24 24"
                                                                                                                width="20"
                                                                                                                height="20">
                                                                                                                <path
                                                                                                                    d="M18,6h0a1,1,0,0,0-1.414,0L12,10.586,7.414,6A1,1,0,0,0,6,6H6A1,1,0,0,0,6,7.414L10.586,12,6,16.586A1,1,0,0,0,6,18H6a1,1,0,0,0,1.414,0L12,13.414,16.586,18A1,1,0,0,0,18,18h0a1,1,0,0,0,0-1.414L13.414,12,18,7.414A1,1,0,0,0,18,6Z" />
                                                                                                            </svg>
                                                                                                        </a>
                                                                                                    </div>
                                                                                                </div>

                                                                                                <div class="foodqty mt-0">
                                                                                                    <span class="minus"
                                                                                                        onclick="updateDishQty('-',<?php echo e($dish->dish->qty); ?>,<?php echo e($dish->id); ?>)">
                                                                                                        <i
                                                                                                            class="fas fa-minus align-middle"></i>
                                                                                                    </span>
                                                                                                    <input type="number"
                                                                                                        readonly
                                                                                                        class="count cart-amt"
                                                                                                        id="qty-<?php echo e($dish->id); ?>"
                                                                                                        name="qty-<?php echo e($dish->id); ?>"
                                                                                                        value="<?php echo e($dish->qty); ?>"
                                                                                                        data-ing="<?php echo e($paidIngredient); ?>"
                                                                                                        data-id="<?php echo e($dish->id); ?>" />
                                                                                                    <input type="hidden"
                                                                                                        id="dish-price-<?php echo e($dish->id); ?>"
                                                                                                        value="<?php echo e($dish->dish->price + $totalAmount + $dishOptionCategoryTotalAmount); ?>" />
                                                                                                    <span class="plus"
                                                                                                        onclick="updateDishQty('+',<?php echo e($dish->dish->qty); ?>,<?php echo e($dish->id); ?>)">
                                                                                                        <i
                                                                                                            class="fas fa-plus align-middle"></i>
                                                                                                    </span>
                                                                                                </div>
                                                                                            </div>


                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="cart-section">
                                                        

                                                        <div class="cart-amount-cal-data" id="cart-amount-cal-data"
                                                            <?php echo e(count($cart) > 0 ? '' : 'style=display:none'); ?>>
                                                            <!--                                                      <div class="form-group prev-input-group custom-icon-input-group">
                                                                                                                                            <span class="input-group-icon">
                                                                                                                                              <img src="<?php echo e(asset('images/scoter-yellow.svg')); ?>" alt="" class="svg img-fluid" height="22" width="25">
                                                                                                                                            </span>
                                                                                                                                            <input type="text" class="form-control bg-gray custom-control-with-icon ps-5" id="delivery_instruction" maxlength="50" value="<?php echo e($user->cart ? $user->cart->delivery_note : ''); ?>" placeholder="<?php echo e(trans('user.cart.instruction')); ?>" />
                                                                                                                                          </div>-->
                                                            <div class="mb-4 pb-3">
                                                                <div
                                                                    class="form-group prev-input-group position-relative d-flex align-items-center mb-0">
                                                                    <span class="input-group-icon">
                                                                        <img src="<?php echo e(asset('images/coupons-menu-up.svg')); ?>"
                                                                            alt="" class="svg img-fluid"
                                                                            height="18" width="29">
                                                                    </span>
                                                                    <input type="text"
                                                                        class="form-control bg-white custom-control-with-icon ps-5 dashed-border"
                                                                        style="padding-right: 115px; box-shadow: 1px 2px 10px 8px rgba(0, 0, 0, 0.08);"
                                                                        placeholder="Coupon Code"
                                                                        value="<?php echo e($couponCode); ?>"
                                                                        <?php echo e(!empty($couponCode) ? 'readonly' : ''); ?>

                                                                        id="coupon_code">
                                                                    <div class="coupon-apply-btn">
                                                                        <button class="btn btn-xs-sm btn-site-theme"
                                                                            onclick="applyCoupon()"
                                                                            id="coupon_code_apply_btn"
                                                                            <?php echo e(!empty($couponCode) ? 'style=display:none' : ''); ?>>
                                                                            <span><?php echo e(trans('user.cart.apply')); ?>

                                                                        </button>
                                                                        <button class="btn btn-xs-sm btn-site-theme"
                                                                            onclick="removeCoupon()"
                                                                            id="coupon_code_remove_btn"
                                                                            <?php echo e(!empty($couponCode) ? '' : 'style=display:none'); ?>>
                                                                            <?php echo e(trans('user.cart.remove')); ?> </button>
                                                                    </div>
                                                                </div>
                                                                <label id="coupon-code-error"
                                                                    class="error d-none"></label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="empty-card-div w-100 mt-lg-5 pt-lg-5" id="empty-cart-div"
                                                        <?php echo e(count($cart) > 0 ? 'style=display:none' : ''); ?>>
                                                        <span>
                                                            
                                                            <img src="<?php echo e(getRestaurantDetail()->restaurant_logo); ?>"
                                                                class="web-logo opacity-50">
                                                        </span>
                                                        <p class="empty-card-text text-muted-1 mb-2">
                                                            <?php echo e(trans('user.cart.empty')); ?>

                                                        </p>
                                                    </div>
                                                    <!-- End cart section -->
                                                <?php else: ?>
                                                    <!-- start empty cart section -->
                                                    <div class="empty-card-div w-100 mt-lg-5 pt-lg-5">
                                                        <p class="empty-card-text text-muted-1 mb-2">
                                                            <?php echo e(trans('user.cart.empty')); ?>

                                                        </p>
                                                        <span>
                                                            
                                                            <img src="<?php echo e(getRestaurantDetail()->restaurant_logo); ?>"
                                                                class="web-logo opacity-50">
                                                        </span>
                                                    </div>
                                                    <!--end empty cart section -->
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bill-detail-invoice <?php echo e(count($cart) == 0 ? 'd-none' : ''); ?>" id="cart-bill-div">
                            <h6 class="cart-title mb-1 d-none"><?php echo e(trans('user.cart.bill_details')); ?></h6>
                            <div class="table-responsive">
                                <table class="table table-borderless mb-2">
                                    <tbody></tbody>
                                    <tbody>
                                        <tr>
                                            <td class="text-start">
                                                <span
                                                    class="text-muted-1 bill-count-name"><?php echo e(trans('user.cart.item_total')); ?></span>

                                                <span class="min_order_price" style="display: none">
                                                    <?php echo e(number_format($min_order_price, 2)); ?></span>
                                                <span class="text-muted-1 minimum_amount"
                                                    style="display: none">(<?php echo e(trans('user.cart.minimum_amount') . '' . number_format($min_order_price, 2)); ?>)
                                                </span>
                                            </td>
                                            <td class="text-end">
                                                <span class="bill-count"
                                                    id="total-cart-bill">€<?php echo e(number_format($cartValue, 2)); ?></span>
                                                <input type="hidden" id="total-cart-bill-amount"
                                                    value="<?php echo e($cartValue); ?>">
                                            </td>
                                        </tr>
                                        <tr <?php echo e($serviceCharge > 0 ? '' : 'style=display:none'); ?>>
                                            <td class="text-start">
                                                <span
                                                    class="text-muted-1 bill-count-name"><?php echo e(trans('user.cart.service_charge')); ?></span>
                                            </td>
                                            <td class="text-end">
                                                <span class="bill-count">€<?php echo e(number_format($serviceCharge, 2)); ?></span>
                                                <input type="hidden" id="service-charge" value="<?php echo e($serviceCharge); ?>">
                                            </td>
                                        </tr>

                                        <tr id="delivery-charge-tab">
                                            <td class="text-start">
                                                <span
                                                    class="text-muted-1 bill-count-name delivery_charge_name"><?php echo e(trans('user.cart.delivery_charge')); ?></span>
                                            </td>
                                            <td class="text-end">
                                                <span
                                                    class="bill-count delivery_charge_amount">€<?php echo e(number_format($delivery_charge, 2)); ?></span>
                                                <input type="hidden" id="delivery-charge"
                                                    value="<?php echo e($delivery_charge); ?>">
                                            </td>
                                        </tr>
                                        <tr class="item-discount" id="item-discount"
                                            <?php echo e(!empty($couponCode) ? '' : 'style=display:none'); ?>>
                                            <td class="text-start">
                                                <span
                                                    class="text-custom-light-green bill-count-name"><?php echo e(trans('user.cart.discount')); ?></span>
                                                <input type="hidden" id="coupon-discount"
                                                    value="<?php echo e($couponDiscount); ?>">
                                            </td>
                                            <td class="text-end">
                                                <span class="text-custom-light-green bill-count"
                                                    id="coupon-discount-text">-€<?php echo e(number_format((float) ($cartValue * $couponDiscountPercent), 2)); ?>

                                                </span>
                                                <input type="hidden" id="coupon-discount-percent"
                                                    value="<?php echo e($couponDiscountPercent); ?>">
                                            </td>
                                        </tr>
                                    </tbody>
                                    <?php
                                        $amount = number_format(
                                            (float) ($cartValue + $serviceCharge - $cartValue * $couponDiscountPercent),
                                            2,
                                        );
                                        if ($zipcode) {
                                            $amount = number_format(
                                                (float) ($cartValue +
                                                    $serviceCharge +
                                                    $delivery_charge -
                                                    $cartValue * $couponDiscountPercent),
                                                2,
                                            );
                                        }
                                    ?>
                                    <tfoot>
                                        <tr>
                                            <td class="text-start"><?php echo e(trans('user.cart.total')); ?></td>
                                            <td class="text-end">
                                                <span class="bill-total-count"
                                                    id="gross-total-bill">€<?php echo e($amount); ?></span>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <a class="btn btn-site-theme btn-default d-block checkout-sticky-btn show-hide-btn <?php echo e(count($cart) == 0 ? 'd-none' : ''); ?>"
                                id="checkout-cart" href="javascript:void(0)">
                                <span class="align-middle">
                                    <?php echo e(trans('user.cart.checkout')); ?>

                                    (<span class="bill-total-count"
                                        id="gross-total-bill1">€<?php echo e(number_format((float) ($cartValue + $serviceCharge + $delivery_charge - $cartValue * $couponDiscountPercent), 2)); ?></span>)
                                </span>
                            </a>

                            
                        </div>
                    </div>
                </aside>
            </div>
        </div>
        <!-- start footer -->
        <?php echo $__env->make('layouts.user.footer_design', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <!-- end footer -->
    </div>

    <?php echo $__env->make('user.modals.address', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('user.modals.customize-dish', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script>
        var app_name = '<?php echo env('APP_NAME'); ?>'

        var zipcode = <?php echo json_encode($zipcode); ?>;
    </script>
    <script type="text/javascript" src="<?php echo e(asset('js/user/dashboard.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.user-app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH E:\wamp\www\go-meal\resources\views/user/dashboard.blade.php ENDPATH**/ ?>