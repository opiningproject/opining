@extends('layouts.user-app')
@section('content')

    <?php

    $zipcode = session('zipcode');
    $house_no = session('house_no');

    $showModal = 0;

    if (!session('showLoginModal')) {
        $showModal = 1;
        Session::put('showLoginModal', '1', '1440');
    }

    $cartValue = 0;

    ?>
    <div class="main">
        <div class="main-view">
            <div class="container-fluid bd-gutter bd-layout"> @include('layouts.user.side_nav_bar')
                <main class="bd-main">
                    <div class="main-content">
                        <div class="section-page-title main-page-title row justify-content-between">
                            <div class="col-xxl-6 col-xl-6 col-lg-5 col-md-6 col-sm-6 col-12">
                                <h1 class="page-title">Dashboard</h1>
                            </div>
                            <div
                                class="form-group mb-0 has-search position-relative searcheatbox col-xxl-4 col-xl-4 col-lg-7 col-md-6 col-sm-12 col-12 text-end">
              <span class="form-control-feedback">
                <img class="svg" src="{{ asset('images/search.svg') }}" alt="" height="32" width="32">
              </span>
                                <input type="text" class="form-control text-transform-none"
                                       placeholder="What do you want eat today..." id="search-dish"/>
                            </div>
                        </div>
                        <div class="offer-card-banner offercard-slider">
                            <div class="card position-relative">
                                <div class="bg-offercard-circle-1">
                                    <img class="svg" src="{{ asset('images/ban-grade1.svg') }}" alt="" width="175"
                                         height="102">

                                </div>
                                <div class="bg-offercard-circle-2">
                                    <img class="svg" src="{{ asset('images/ban-grade2.svg') }}" alt="" width="285"
                                         height="114">

                                </div>
                                <div class="bg-offercard-circle-3">
                                    <img class="svg" src="{{ asset('images/ban-grade3.svg') }}" alt="" width="175"
                                         height="144">

                                </div>
                                <div class="card-body">
                                    <h2>Get Discount Voucher Up To 20%</h2>
                                    <p class="mb-0"> Every 5th order you will get a 20% discount voucher! </p>
                                </div>
                            </div>
                        </div>
                        <!-- start category section -->
                        <section class="custom-section category-section pb-0">
                            <div class="section-page-title">
                                <h1 class="section-title">Category</h1>
                                <div class="category-slider-navigation">
                                    <!-- Add Arrows -->
                                    <div class="swiper-button-prev"></div>
                                    <div class="swiper-button-next"></div>
                                </div>
                            </div>
                            <div class="swiper-container">
                                <div class="swiper category-swiper-slider">
                                    <div class="category-slider swiper-wrapper"> @foreach ($categories as $cat)
                                            <div class="category-element swiper-slide">
                                                <div
                                                    class="card {{ (isset($_GET['cat_id']) && $_GET['cat_id'] == $cat->id) ? 'active':'' }}">
                      <span class="dish-item-icon">
                        <img src="{{ $cat->image }}" class="img-fluid" alt="bakery" width="56" height="56"/>
                      </span>
                                                    <p class="mb-0 text-truncate text-muted"
                                                       title="{{ $cat->name }}">{{ $cat->name }}</p>
                                                    <a href="{{ route('user.dashboard',['cat_id'=>$cat->id]) }}"
                                                       class="stretched-link"></a>
                                                </div>
                                            </div>
                                        @endforeach </div>
                                </div>
                            </div>
                        </section>
                        <!-- end category section -->
                        <!-- start category list section -->
                        <section class="custom-section category-list-section pb-0">
                            <div class="section-page-title">
                                <h1 class="section-title">{{ $category ? $category->name : ''}}</h1>
                                <a href="{{ route('user.dashboard') }}?all=1" type="button" class="viewall-btn">View all
                                    <span>
                  <img src="{{ asset('images/view.svg') }}" alt="" class="svg" height="24" width="24">
                </span>
                                </a>
                            </div>

                            <div class="dish-details-div">
                                <div class="category-list-item-grid">
                                    @foreach ($dishes as $dish)
                                        <?php
                                            $disableBtn = '';
                                            $customizeBtn = false;
                                            if($dish->qty == 0 || $dish->out_of_stock == '1'){
                                                $disableBtn = 'disabled';
                                                $customizeBtn = true;
                                            }else if($dish->cart){
                                                $disableBtn = 'disabled';
                                            }
                                            ?>
                                        <div class="card food-detail-card">
                                            <p class="mb-0 offer-percantage">{{ $dish->percentage_off }}%</p>
                                            <p class="mb-0 food-favorite-icon {{ isset($dish->favorite) ? 'd-none':'' }}"
                                               onclick="favorite({{ $dish->id }})" id="unfavorite-icon-{{ $dish->id }}">
                                                <img src="{{ asset('images/favorite-before-icon.svg') }}" alt=""
                                                     class="svg" height="20" width="22">
                                            </p>
                                            <p class="mb-0 food-favorite-icon {{ isset($dish->favorite) ? '':'d-none' }}"
                                               onclick="unFavorite({{ $dish->id }})" id="favorite-icon-{{ $dish->id }}">
                                                <img src="{{ asset('images/favorite-after-icon.svg') }}" alt=""
                                                     class="svg" height="20" width="22">

                                            </p>
                                            <div class="food-image">
                                                <img src="{{ $dish->image }}" alt="burger imag" class="img-fluid"
                                                     width="100" height="100"/>
                                            </div>
                                            <h4 class="food-name-text">{{ $dish->name }}</h4>
                                            <p class="food-price">€{{ $dish->price }}</p>
                                            <button type="button" class="btn btn-xs-sm btn-custom-yellow"
                                                    onclick="addToCart({{ $dish->id }})"
                                                    id="dish-cart-lbl-{{ $dish->id }}" {{ $disableBtn }}>
                                                @if($dish->qty == 0 || $dish->out_of_stock == '1')
                                                    Out of stock
                                                @else
                                                    @if($dish->cart)
                                                        Added to cart
                                                    @else
                                                        Add
                                                        <img src="{{ asset('images/plus.svg') }}" alt="" class="svg"
                                                             height="9" width="9">
                                                    @endif
                                                @endif
                                            </button>
                                            @if(!$customizeBtn)
                                            <a href="javascript:void(0);" class="customize-foodlink"
                                               onclick="customizeDish({{ $dish->id }});">Customize</a>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </section>
                        <!-- end category list section -->
                    </div>
                </main>
                <aside class="cart-sidebar sticky-top h-lg-100vh">
                    <div class="offcanvas-lg offcanvas-end h-100 overflow-auto" tabindex="-1" id="bdSidebarCart"
                         aria-labelledby="bdSidebarCartOffcanvasLabel">
                        <div class="offcanvas-header p-0" style="display: block"></div>
                        <div class="offcanvas-body position-relative">

                            <button type="button"
                                    class="btn-close d-block position-absolute d-lg-none top-0 mt-2 start-0 ms-2"
                                    data-bs-dismiss="offcanvas" aria-label="Close" data-bs-target="#bdSidebarCart">
                            </button>

                            <div class="navbar navbar-expand-lg pt-0 h-lg-100">
                                <div class="cart-sidebar-content position-relative h-100">
                                    <div class="navbar-collapse cartbox-collapse h-100">
                                        <div class="cart-custom-tab cart-tab custom-tabs d-flex flex-column h-100">
                                            <ul class="nav nav-fill" id="pills-tab" role="tablist">
                                                <li class="nav-item" role="presentation">
                                                    <button
                                                        class="nav-link {{ $zipcode ? 'active' : ''}} pills-delivery-tab"
                                                        id="pills-home-tab" data-bs-toggle="pill"
                                                        data-type="{{ \App\Enums\OrderType::Delivery }}"
                                                        data-bs-target="#pills-home" type="button" role="tab"
                                                        aria-controls="pills-home" aria-selected="true">
                                                        <img src="{{ asset('images/scoter1.svg') }}" alt="" class="svg"
                                                             height="23" width="26">
                                                        Delivery
                                                    </button>
                                                    <input type="hidden" value="{{ $house_no }}" id="del-house-no">
                                                    <input type="hidden" value="{{ $zipcode }}" id="del-zipcode">
                                                </li>
                                                <li class="nav-item" role="presentation">
                                                    <button
                                                        class="nav-link {{ !$zipcode ? 'active' : ''}} pills-delivery-tab"
                                                        id="pills-profile-tab" data-bs-toggle="pill"
                                                        data-type="{{ \App\Enums\OrderType::TakeAway }}"
                                                        data-bs-target="#pills-profile" type="button" role="tab"
                                                        aria-controls="pills-profile" aria-selected="false">
                                                        <img src="{{ asset('images/takeaway-icon.svg') }}" alt=""
                                                             class="svg" height="23" width="23">
                                                        Take Away
                                                    </button>
                                                </li>
                                            </ul>
                                            <div class="d-flex flex-column flex-fill tab-content" id="pills-tabContent">
                                                <div class="tab-pane fade {{ $zipcode ? 'show active' : ''}}"
                                                     id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab"
                                                     tabindex="0">
                                                    <div class="form-group">
                                                        <label class="form-label">Delivery Address</label>
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <div class="d-flex align-items-center">
                                                                <img src="{{ asset('images/delivery-address.svg') }}"
                                                                     alt="" class="svg" height="23" width="32">

                                                                <p class="mb-0 d-inline-block ms-2 text-bold-1"> <?= $house_no ? $house_no . ', ' . $zipcode : ''; ?> </p>
                                                            </div>
                                                            @if($user && $user->id)
                                                                <a href="javascript:void(0);" data-bs-toggle="modal"
                                                                   data-bs-target="#addressChangeModal"
                                                                   class="btn btn-xs-sm btn-custom-yellow text-capitalize address-change-btn">Change</a>
                                                            @else
                                                                <a href="javascript:void(0);" data-bs-toggle="modal"
                                                                   data-bs-target="#signInModal"
                                                                   class="btn btn-xs-sm btn-custom-yellow text-capitalize address-change-btn">Change</a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade {{ !$zipcode ? 'show active' : ''}}"
                                                     id="pills-profile" role="tabpanel"
                                                     aria-labelledby="pills-profile-tab" tabindex="0">
                                                    <div class="form-group">
                                                        <label class="form-label">Restaurants Address</label>
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <div class="d-flex align-items-center">
                                                                <img src="{{ asset('images/rest-address.svg') }}" alt=""
                                                                     class="svg" height="29" width="29">

                                                                <p class="mb-0 d-inline-block ms-2 text-bold-1">{{ getRestaurantDetail()->rest_address }} </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                @if($user && $user->id)
                                                    <!-- End address section & start cart section -->
                                                    <div class="cart-section">
                                                        <h6 class="cart-title">Your Cart</h6>
                                                        <div class="cart-items">
                                                            @if(count($cart) > 0)
                                                                @foreach($cart as $key => $dish)
                                                                        <?php
                                                                        $cartValue += ($dish->qty * $dish->dish->price);
                                                                        $paidIngredient = isset($dish->orderDishPaidIngredients) ? $dish->orderDishPaidIngredients()->select(\Illuminate\Support\Facades\DB::raw('sum(quantity * price) as total'))->get()->sum('total') : 0;
                                                                        $cartValue += $paidIngredient;
                                                                        $outOfStock = '';
                                                                        $outOfStockDisplay = 'd-none';
                                                                        if($dish->dish->qty == 0 || $dish->dish->out_of_stock == '1'){
                                                                            $outOfStock = 'nostock-card';
                                                                            $outOfStockDisplay = '';
                                                                        }
                                                                        ?>
                                                                    <div class="row stock-card {{ $outOfStock }}" id="cart-{{ $dish->dish->id }}">

                                                                        <div class="col-12 text-end d-flex align-items-center gap-2 mb-3 justify-content-end outof-stock-text {{ $outOfStockDisplay }}">
                                                                            <strong>Out of stock</strong> <a class="remove-cart-dish" data-id="{{ $dish->id }}" data-dish-id="{{ $dish->dish->id }}" href="javascript:void(0)"><svg xmlns="http://www.w3.org/2000/svg" fill="#ff0000"  viewBox="0 0 24 24" width="20px" height="20px"><path d="M 10 2 L 9 3 L 4 3 L 4 5 L 5 5 L 5 20 C 5 20.522222 5.1913289 21.05461 5.5683594 21.431641 C 5.9453899 21.808671 6.4777778 22 7 22 L 17 22 C 17.522222 22 18.05461 21.808671 18.431641 21.431641 C 18.808671 21.05461 19 20.522222 19 20 L 19 5 L 20 5 L 20 3 L 15 3 L 14 2 L 10 2 z M 7 5 L 17 5 L 17 20 L 7 20 L 7 5 z M 9 7 L 9 18 L 11 18 L 11 7 L 9 7 z M 13 7 L 13 18 L 15 18 L 15 7 L 13 7 z"/></svg></a>
                                                                        </div>

                                                                        <div
                                                                            class="col-xx-3 col-xl-3 col-lg-3 col-md-4 col-sm-4 col-4 cart-custom-w-col-img">
                                                                            <img src="{{ $dish->dish->image }}"
                                                                                 alt="burger image" class="img-fluid"
                                                                                 width="86" height="74px"/>
                                                                            <div class="foodqty">
                                  <span class="minus">
                                    <i class="fas fa-minus align-middle"
                                       onclick="updateDishQty('-',{{ $dish->dish->qty }},{{ $dish->dish->id }})"></i>
                                  </span>
                                                                                <input type="number"
                                                                                       class="count cart-amt"
                                                                                       id="qty-{{ $dish->dish->id }}"
                                                                                       name="qty-{{ $dish->dish->id }}"
                                                                                       value="{{ $dish->qty }}"
                                                                                       data-ing="{{ $paidIngredient }}"
                                                                                       data-id="{{ $dish->dish->id }}"/>
                                                                                <input type="hidden"
                                                                                       id="dish-price-{{ $dish->dish->id }}"
                                                                                       value="{{ $dish->dish->price }}"/>
                                                                                <span class="plus">
                                    <i class="fas fa-plus align-middle"
                                       onclick="updateDishQty('+',{{ $dish->dish->qty }},{{ $dish->dish->id }})"></i>
                                  </span>
                                                                            </div>
                                                                        </div>
                                                                        <div
                                                                            class="col-xx-9 col-xl-9 col-lg-9 col-md-8 col-sm-12 col-8 cart-custom-w-col-detail">
                                                                            <div class="cart-item-detail">
                                                                                <div
                                                                                    class="d-flex align-items-center justify-content-between">
                                                                                    <p class="d-inline-block item-name mb-0"> {{ $dish->dish->name }} </p>
                                                                                    <span
                                                                                        class="cart-item-price">+€{{ $dish->dish->price }}</span>
                                                                                </div>
                                                                                <div class="d-flex">
                                                                                    <p class="mb-0 item-options mb-0">
                                                                                        {{ $dish->dishOption->name ?? '' }}</p>
                                                                                    <span class="item-desc">-{{ getOrderDishIngredients($dish) }}</span>
                                                                                    <p class="item-customize mb-0 ms-auto justify-content-end">
                                                                                        customize
                                                                                        <a href="javascript:void(0);"
                                                                                           onclick="customizeDish({{ $dish->dish->id }});">
                                                                                            <img
                                                                                                src="{{ asset('images/custom-dish.svg') }}"
                                                                                                alt="" class="svg"
                                                                                                height="13" width="14">

                                                                                        </a>
                                                                                    </p>
                                                                                </div>
                                                                                <div
                                                                                    class="from-group addnote-from-group mb-0">
                                                                                    <div class="form-group">
                                                                                        <label for="dishnameenglish"
                                                                                               class="form-label">Add
                                                                                            notes</label>
                                                                                        <input type="text" data-id="{{ $dish->id }}"
                                                                                               class="form-control dish-notes" value="{{ $dish->notes }}"
                                                                                               placeholder="Type here..."/>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                        <div class="cart-amount-cal-data"
                                                             id="cart-amount-cal-data" {{ count($cart) > 0 ? '' : "style=display:none" }}>
                                                            <div
                                                                class="form-group prev-input-group custom-icon-input-group">
                            <span class="input-group-icon">
                              <img src="{{ asset('images/scoter-yellow.svg') }}" alt="" class="svg" height="22"
                                   width="25">

                            </span>
                                                                <input type="text" class="form-control bg-gray" id="delivery_instruction" value="{{ $user->cart ? $user->cart->delivery_note : '' }}"
                                                                       placeholder="Add Delivery instruction"/>
                                                            </div>
                                                            <div class="mb-3">
                                                                <div
                                                                    class="form-group prev-input-group position-relative d-flex align-items-center mb-0">
                                <span class="input-group-icon">
                                  <img src="{{ asset('images/coupon-code.svg') }}" alt="" class="svg" height="18"
                                       width="29">

                                </span>
                                                                    <input type="text" class="form-control bg-gray"
                                                                           placeholder="Coupon Code"
                                                                           value="{{ $couponCode }}"
                                                                           {{ !empty($couponCode) ? 'readonly' : '' }} id="coupon_code">
                                                                    <div class="coupon-apply-btn">
                                                                        <button class="btn btn-xs-sm btn-custom-yellow"
                                                                                onclick="applyCoupon()"
                                                                                id="coupon_code_apply_btn" {{ !empty($couponCode) ? 'style=display:none' : '' }}>
                                                                            Apply
                                                                        </button>
                                                                        <button class="btn btn-xs-sm btn-custom-yellow"
                                                                                onclick="removeCoupon()"
                                                                                id="coupon_code_remove_btn" {{ !empty($couponCode) ? '' : 'style=display:none' }}>
                                                                            Remove
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                                <label id="coupon-code-error"
                                                                       class="error d-none"></label>
                                                            </div>
                                                            <div class="bill-detail-invoice">
                                                                <h6 class="cart-title">Bill Details</h6>
                                                                <div class="table-responsive">
                                                                    <table class="table table-borderless">
                                                                        <tbody></tbody>
                                                                        <tbody>
                                                                        <tr>
                                                                            <td class="text-start">
                                                                                <span
                                                                                    class="text-muted-1 bill-count-name">Item Total </span>
                                                                            </td>
                                                                            <td class="text-end">
                                                                                <span class="bill-count"
                                                                                      id="total-cart-bill">€{{ $cartValue }}</span>
                                                                                <input type="hidden"
                                                                                       id="total-cart-bill-amount"
                                                                                       value="{{ $cartValue }}">
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="text-start">
                                                                                <span
                                                                                    class="text-muted-1 bill-count-name">Service</span>
                                                                            </td>
                                                                            <td class="text-end">
                                                                                <span
                                                                                    class="bill-count">€{{ $serviceCharge }}</span>
                                                                                <input type="hidden" id="service-charge"
                                                                                       value="{{ $serviceCharge }}">
                                                                            </td>
                                                                        </tr>
                                                                        <!--                                  <tr>
                                                                                                            <td class="text-start">
                                                                                                              <span class="text-muted-1 bill-count-name">Free Delivery (25 mins)</span>
                                                                                                            </td>
                                                                                                            <td class="text-end">
                                                                                                              <span class="bill-count">-€00</span>
                                                                                                            </td>
                                                                                                          </tr>-->
                                                                        <tr class="item-discount"
                                                                            id="item-discount" {{ !empty($couponCode) ? '' : 'style=display:none' }}>
                                                                            <td class="text-start">
                                                                                <span
                                                                                    class="text-custom-light-green bill-count-name">Item discount</span>
                                                                                <input type="hidden"
                                                                                       id="coupon-discount"
                                                                                       value="{{ $couponDiscount }}">
                                                                            </td>
                                                                            <td class="text-end">
                                                                                <span
                                                                                    class="text-custom-light-green bill-count"
                                                                                    id="coupon-discount-text">-€{{ $cartValue * $couponDiscountPercent }}</span>
                                                                                <input type="hidden"
                                                                                       id="coupon-discount-percent"
                                                                                       value="{{ $couponDiscountPercent }}">
                                                                            </td>
                                                                        </tr>
                                                                        </tbody>
                                                                        <tfoot>
                                                                        <tr>
                                                                            <td class="text-start">Total</td>
                                                                            <td class="text-end">
                                                                                <span class="bill-total-count"
                                                                                      id="gross-total-bill">{{ ($cartValue + $serviceCharge) - ($cartValue * $couponDiscountPercent) }}</span>
                                                                            </td>
                                                                        </tr>
                                                                        </tfoot>
                                                                    </table>
                                                                </div>
                                                                <a class="btn btn-custom-yellow btn-default d-block"
                                                                   id="checkout-cart"
                                                                   {{--                                                                   href="{{ route('user.checkout') }}">--}}
                                                                   href="javascript:void(0)">
                                                                    <span class="align-middle">Checkout</span>
                                                                </a>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="empty-card-div w-100"
                                                         id="empty-cart-div" {{ count($cart) > 0 ? 'style=display:none' : "" }}>
                                                        <p class="empty-card-text text-muted-1"> Your cart is empty </p>
                                                        <span>
                            <img src="{{ asset('images/empty-card.svg') }}" alt="" class="svg" height="128" width="132">

                          </span>
                                                    </div>
                                                    <!-- End cart section -->
                                                @else
                                                    <!-- start empty cart section -->
                                                    <div class="empty-card-div w-100">
                                                        <p class="empty-card-text text-muted-1"> Your cart is empty </p>
                                                        <span>
                            <img src="{{ asset('images/empty-card.svg') }}" alt="" class="svg" height="128" width="132">

                          </span>
                                                    </div>
                                                    <!--end empty cart section -->
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
        <!-- start footer -->
        @include('layouts.user.footer_design')
        <!-- end footer -->
    </div>


    @include('user.modals.address')
    @include('user.modals.customize-dish')
@endsection
@section('script')
    <script type="text/javascript" src="{{ asset('js/user/dashboard.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/home.js') }}"></script>
@endsection

