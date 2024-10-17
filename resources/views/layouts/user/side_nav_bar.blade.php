<?php
use App\Models\Address;
$zipcode = session('zipcode');
$house_no = session('house_no');
$street_name = session('street_name');
$city = session('city');
$min_order_price = session('min_order_price');
$delivery_charge = session('delivery_charge');
$deliveryTime = getRestaurantDetail()->delivery_time;
$takeAwayTime = getRestaurantDetail()->take_away_time;
?>
@if (Route::currentRouteName() == 'user.dashboard')
<div class="d-none address-select-modal-mobile address--select-modal-mobile">
    <div class="address-select-modal-inn cart-sidebar-mobile">
        <ul class="nav nav-fill nav-fillMobile cart-top-tab" id="pills-tab" role="tablist">
            <li class="nav-item delivery-tab" role="presentation">
                <button
                    class="nav-link {{ $zipcode || ($user && $user->cart && $user->cart->order_type == 1) ? 'active' : '' }} pills-delivery-tab delivery-tab"
                    id="pills-home-tab" data-bs-toggle="pill" data-type="{{ \App\Enums\OrderType::Delivery }}"
                    data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home"
                    aria-selected="true">
                    <img src="{{ asset('images/scoter1.svg') }}" alt="" class="svg" height="23"
                        width="22" />
                    <div class="btn-text">
                        {{ trans('user.cart.delivery') }}
                        <span> {{ $deliveryTime }}</span>
                    </div>
                </button>

                <input type="hidden" value="{{ $house_no }}" id="del-house-no">
                <input type="hidden" value="{{ $zipcode }}" id="del-zipcode">
            </li>
            <li class="nav-item TakeAway-tab" role="presentation">
                <button
                    class="nav-link {{ !$zipcode && (!$user || !$user->cart || $user->cart->order_type == 2) ? 'active' : '' }} pills-delivery-tab TakeAway-tab"
                    id="pills-profile-tab" data-bs-toggle="pill" data-type="{{ \App\Enums\OrderType::TakeAway }}"
                    data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile"
                    aria-selected="false">
                    <img src="{{ asset('images/takeaway-icon.svg') }}" alt="" class="svg" height="23"
                        width="22" />
                    <div class="btn-text">
                        {{ trans('user.cart.take_away') }}
                        <span> {{ $takeAwayTime }}</span>
                    </div>
                </button>
            </li>
        </ul>

        <div class="tab-pane-mobile pb-1">
            <div class="delivery-tab-mobile">
                @if (count($addresses) > 0)
                    @foreach ($addresses as $key => $add)
                        <?php
                        $selectedAddress = '<span class="success-ico blank"></span>';
                        $selected = false;
                        $style = '';

                        if (session('address') == $add->id) {
                            $selected = true;
                            $addressText = 'Selected';
                            $selectedAddress = '<span class="success-ico"><img src="' . asset("images/success-icon.svg") . '" class="svg" width="14" height="11"></span>';
                            $style = 'pointer-events:none;cursor:default';
                        }
                        ?>
                        <div class="select-address-row d-flex justify-content-between align-items-center mb-3 "
                             id="address-mobile-{{ $add->id }}">
                            <div class="address-radio d-flex align-items-center">
                                <div class="radio-container">
                                    <input type="radio" name="selected_address" class="select-address-btn"
                                           id="radio{{ $add->id }}"
                                           value="{{ $add->id }}"
                                           {{ $selected ? 'checked' : '' }}  data-selected-address="{{session('address')}}">
                                    {{--                            <input type="radio" id="radio1" name="location">--}}
                                    <label class="radio-custom" for="radio{{ $add->id }}"></label>
                                    <span class="radio-label">{{ $add->street_name }}, {{ $add->house_no }}</span>
                                </div>
                            </div>
                            <a href="javascript:void(0)" class="delete-address">
                                <img src="{{ asset('images/add-delete-ico.svg') }}" alt="" class="svg"
                                     height="15" width="15"/></a>
                        </div>
                    @endforeach
                @endif
                <div
                    class="select-address-row d-flex justify-content-between align-items-center mb-1 add-select-address-row flex-wrap">
                    <div class="address-radio d-flex align-items-center mb-3">
                        <div class="add-radio-container">
                            <span class="icon">
                                <svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M6 1L6 11" stroke="black" stroke-width="1.5" stroke-linecap="round" />
                                    <path d="M11 6L1 6" stroke="black" stroke-width="1.5" stroke-linecap="round" />
                                </svg>
                            </span>
                            <span class="radio-label">Add new address</span>
                        </div>
                    </div>

                    <form action="" id="address-form-mobile" class="address-add-form d-flex gap-2">
                        @csrf
                        <div class="form-group mb-0 zip">
                            <input type="text" placeholder="Zip code" name="zipcode"
                                   id="zipcode" class="form-control" value="{{ $zipcode }}" required />
                        </div>

                        <div class="form-group house-number mb-0">
                            <input type="text" placeholder="House Number" name="house_no"
                                   id="house_no" class="form-control" value="{{ $house_no }}" required />
                        </div>

                        <div class="form-group btn-cl mb-0">
                            <button type="submit" class="btn btn-site-theme">
                                <img src="{{ asset('images/btn-arrow.svg') }}" alt="" class="svg"
                                     height="15" width="15"/>
                            </button>
                        </div>
                    </form>

                </div>
            </div>

            <div class="takeAway-tab-mobile d-none">

                <div class="radio-container">
                    <input type="radio" id="radio1" name="location">
                    <label class="radio-custom" for="radio1"></label>
                    <span class="radio-label">
                        <h3>pick up at</h3>
                        <p class="mb-0">Tochtstraat 40, 3036SK Rotterdam</p>
                    </span>
                </div>

            </div>
        </div>
    </div>

</div>
@endif
<aside class="menu-sidebar sticky-top">
    <div class="menu-sidebar-inner menu-sidebar--address">
        <div class="bd-navbar-toggle">
            <button class="navbar-toggler p-2" id="menu-sidebar" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#bdSidebar" aria-controls="bdSidebar" aria-label="Toggle docs navigation">
                <img src="{{ asset('images/toggle-icon-a.svg') }}" class="svg actual" width="24"
                    height="21">
                <span class="d-none fs-6 pe-1">Browse</span>
            </button>
        </div>

        <div class="siderbarmenu-brand">
            @if (Route::currentRouteName() == 'user.dashboard')
            <h4 class="pt-2 text-center end-0 mx-auto head-title top-head-title top-head-dropdown mb-0 d-none"
                id="head-dropdown-btn">
                <img src="{{ asset('images/map-t-icon.png') }}" width="15" alt="" />

                <p id="zip_address_mobile" class="mb-0">

                    @if($user || $user->cart && $user->cart->order_type == 1)
                        @if ($street_name)
                            {{ ($street_name ? $street_name : '') . ' ' . ($house_no ? $house_no : '') }}
                        @else
                            {{ $house_no ? $house_no . ', ' . $zipcode : '' }}
                        @endif
                    @else
                        {{ getRestaurantDetail()->rest_address }}
                    @endif
                </p>
                <p id="zip_address_mobile_takw_away" class="mb-0 d-none">
                    {{ getRestaurantDetail()->rest_address }}
                </p>
                <span class="arrow-icon">

                    <svg width="9" height="5" viewBox="0 0 9 5" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M4.5 5L0.602887 0.499999L8.39711 0.5L4.5 5Z" fill="black" />
                    </svg>

                </span>
            </h4>
            @endif

            <a href="{{ route('user.dashboard') }}" class="navbar-brand sidebar-logo">
                <img src="{{ getRestaurantDetail()->restaurant_logo }}" class="web-logo">
            </a>
        </div>

        <div class="bd-navbar-toggle cartsidebar-icon ms-auto align-items-center">
            <button class="navbar-toggler p-2 searcheatboxbtn d-none" type="button">
                <img src="{{ asset('images/toggle-icon.svg') }}" class="svg actual" width="18" height="18">
            </button>


            <!-- Just show in dahboard - Condition will added by Jamal -->
            <button
                class="navbar-toggler p-0 searchMobileIcon d-md-none {{ request()->segment(count(request()->segments())) != 'dashboard' && request()->segment(count(request()->segments()) - 1) != 'dashboard' ? 'd-none' : '' }} "
                id="mobilesearchToggle" type="button">
                <img class="svg actual" src="{{ asset('images/search-icon-up.svg') }}" alt=""
                    height="18" width="18">
            </button>

            @if (Route::currentRouteName() == 'user.dashboard')
                <button
                    class="navbar-toggler bag-count d-flex  dashboard-cart-navbar-toggler cart-navbar-toggler ms-3 p-0 d-flex"
                    type="button" data-bs-toggle="offcanvas" data-bs-target="#bdSidebarCart"
                    aria-controls="bdSidebarCart" aria-label="Toggle docs navigation">
                    <span class="count"
                        id="cart-item-count">{{ isset(Auth::user()->cart) ? Auth::user()->cart->dishDetails->count() : 0 }}</span>
                    <svg width="22px" height="22px" viewBox="-4 0 32 32" version="1.1"
                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                        xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                        <defs></defs>
                        <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"
                            sketch:type="MSPage">
                            <g id="Icon-Set" sketch:type="MSLayerGroup"
                                transform="translate(-572.000000, -723.000000)" fill="#191919">
                                <path
                                    d="M594,747 L574,747 L574,731 C574,729.896 574.896,729 576,729 L578,729 L578,735 L580,735 L580,729 L588,729 L588,735 L590,735 L590,729 L592,729 C593.104,729 594,729.896 594,731 L594,747 L594,747 Z M594,751 C594,752.104 593.104,753 592,753 L576,753 C574.896,753 574,752.104 574,751 L574,749 L594,749 L594,751 L594,751 Z M584,725 C586.209,725 588,725.619 588,727 L580,727 C580,725.619 581.791,725 584,725 L584,725 Z M592,727 L590,727 C590,724.791 587.313,723 584,723 C580.687,723 578,724.791 578,727 L576,727 C573.791,727 572,728.791 572,731 L572,751 C572,753.209 573.791,755 576,755 L592,755 C594.209,755 596,753.209 596,751 L596,731 C596,728.791 594.209,727 592,727 L592,727 Z"
                                    id="bag" sketch:type="MSShapeGroup"></path>
                            </g>
                        </g>
                    </svg>
                </button>
            @endif

            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"
                data-bs-target="#bdSidebarCart"></button>
        </div>

        <div class="offcanvas-lg offcanvas-start" tabindex="-1" id="bdSidebar"
            aria-labelledby="bdSidebarOffcanvasLabel">
            <div class="offcanvas-header border-bottom position-relative pb-lg-2 pt-lg-0">

                <div class="sidebar-mobile-head">
                    <div class="mobile-sidebar-logo">
                        <img src="{{ getRestaurantDetail()->restaurant_logo }}" class="web-logo block d-lg-none" />
                    </div>

                    <button type="button" class="btn-close d-block drawer-close d-lg-none" id="menu-sidebar-close"
                        data-bs-dismiss="offcanvas" aria-label="Close" data-bs-target="#bdSidebar">
                        <img src="{{ asset('images/menu-back.svg') }}" class="svg actual" height="24"
                            width="24" />
                    </button>
                </div>
            </div>

            <div class="offcanvas-body pb-0 pt-2">
                <nav class="w-100">
                    <div class="menu-sidebar-content d-flex flex-column align-items-center align-items-sm-start">
                        <div class="navbar-collapse menunavbar-collapse w-100" id="navbarSupportedContent">
                            <ul class="nav nav-pills side-bar-menu flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start"
                                id="menu">
                                <li class="nav-item">
                                    <a href="{{ route('user.dashboard') }}"
                                        class="nav-link {{ activeMenu('user.dashboard') }} align-middle">
                                        <div class="icon-span">
                                            <img src="{{ asset('images/menu-icons/dashboard-gray.svg') }}"
                                                class="svg actual" height="20" width="20" />

                                            <img src="{{ asset('images/menu-icons/dashboard-black.svg') }}"
                                                class="svg hoverable" height="20" width="20" />
                                        </div>
                                        <span
                                            class="d-sm-inline align-middle">{{ trans('user.sidebar.dashboard') }}</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('user.orders') }}"
                                        class="nav-link {{ activeMenu('user.orders') }} align-middle auth-link-check">
                                        <div class="icon-span">
                                            <img src="{{ asset('images/menu-icons/myorder-gray.svg') }}"
                                                class="svg actual" height="20" width="20" />

                                            <img src="{{ asset('images/menu-icons/myorder-black.svg') }}"
                                                class="svg hoverable" height="20" width="20" />
                                        </div>
                                        <span
                                            class="d-sm-inline align-middle">{{ trans('user.sidebar.my_order') }}</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('user.favorite') }}"
                                        class="nav-link {{ activeMenu('user.favorite') }} align-middle auth-link-check">
                                        <div class="icon-span">
                                            <img src="{{ asset('images/menu-icons/favourite-gray.svg') }}"
                                                class="svg actual" height="20" width="20" />

                                            <img src="{{ asset('images/menu-icons/favourite-black.svg') }}"
                                                class="svg hoverable" height="20" width="20" />
                                        </div>
                                        <span
                                            class="d-sm-inline align-middle">{{ trans('user.sidebar.favorite') }}</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('user.chat') }}"
                                        class="nav-link {{ activeMenu('user.chat') }} align-middle auth-link-check">
                                        <div class="icon-span">
                                            <img src="{{ asset('images/menu-icons/chat-gray.svg') }}"
                                                class="svg actual" height="20" width="20" />

                                            <img src="{{ asset('images/menu-icons/chat-black.svg') }}"
                                                class="svg hoverable" height="20" width="20" />
                                        </div>
                                        <span class="d-sm-inline align-middle">{{ trans('user.sidebar.chat') }}</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('user.points') }}"
                                        class="nav-link {{ activeMenu('user.points') }} align-middle auth-link-check">
                                        <div class="icon-span">
                                            <img src="{{ asset('images/menu-icons/points-gray.svg') }}"
                                                class="svg actual" height="20" width="20" />

                                            <img src="{{ asset('images/menu-icons/points-black.svg') }}"
                                                class="svg hoverable" height="20" width="20" />
                                        </div>
                                        <span
                                            class="d-sm-inline align-middle">{{ trans('user.sidebar.collected_points') }}</span>
                                    </a>
                                </li>
                                {{-- <li class="nav-item">
                                <a href="{{ route('user.coupons') }}" class="nav-link {{ activeMenu('user.coupons') }} align-middle auth-link-check">
                                    <img src="{{ asset('images/coupons-menu.svg') }}" class="svg actual" height="20" width="20">
                                    <span class="d-sm-inline align-middle"> trans('user.sidebar.my_coupons')</span>
                                </a>
                            </li> --}}

                                {{-- New Coupons menu --}}
                                <li class="nav-item">
                                    <a href="{{ route('user.coupons') }}"
                                        class="nav-link {{ activeMenu('user.coupons') }} align-middle auth-link-check">
                                        <div class="icon-span">
                                            <img src="{{ asset('images/menu-icons/coupons-gray.svg') }}"
                                                class="svg actual" height="20" width="20" />

                                            <img src="{{ asset('images/menu-icons/coupons-black.svg') }}"
                                                class="svg hoverable" height="20" width="20" />
                                        </div>
                                        <span
                                            class="d-sm-inline align-middle">{{ trans('user.sidebar.my_coupons') }}</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('user.settings') }}"
                                        class="nav-link {{ activeMenu('user.settings') }} align-middle auth-link-check">
                                        <div class="icon-span">
                                            <img src="{{ asset('images/menu-icons/setting-gray.svg') }}"
                                                class="svg actual" height="20" width="20" />

                                            <img src="{{ asset('images/menu-icons/setting-black.svg') }}"
                                                class="svg hoverable" height="20" width="20" />
                                        </div>
                                        <span
                                            class="d-sm-inline align-middle">{{ trans('user.sidebar.settings') }}</span>
                                    </a>
                                </li>
                            </ul>
                            {{-- <div class="sidebar-bottom mb-5">
                                <div class="card sidebar-offer-card position-relative">
                                    <div class="card-body">
                                        <p class="mb-0">{{ trans('user.sidebar.content') }}</p>
                                        <div class="circle-bg-shape">
                                            <img src="{{ asset('images/nav-grade.svg') }}" class="svg actual"
                                                width="90" height="95">
                                        </div>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </nav>

                <div class="sidebar-menu-top-box  position-relative border-top">
                    @if (!Auth::user())
                        <div class="auth_enter_btns">

                            <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#signInModal"
                                class="btn">Log In</a>
                            <!--                            <a href="#" data-bs-toggle="modal" data-bs-target="#signUpModal"
                               class="text-yellow-2">{{ trans('modal.button.sign_up') }}</a>-->
                            <a href="#" class="btn btn-site-theme" data-bs-toggle="modal"
                                data-bs-target="#signUpModal">Sign Up</a>

                        </div>
                        <div class="menu-signsignup-link d-none">
                            <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#signInModal">
                                <img src="{{ asset('images/user-icon-up.svg') }}" class="svg actual" width="22"
                                    height="22">
                                <p class="mb-0 d-inline-block align-middle">{{ trans('user.sidebar.sign_in') }} </p>
                            </a>
                        </div>
                    @else
                        <div class="d-flex gap-3 align-items-center">
                            <div class="userPhoto">
                                <img src="{{ Auth::user()->image }}" alt="" width="50"
                                    height="50" />
                            </div>
                            <div class="text-start">
                                <div class="dropdown">
                                    {{ Auth::user()->full_name }}
                                    <ul class="dropdown-menu py-0">
                                        <li>
                                            <a class="dropdown-item log-out-item" href="#"
                                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                <img src="{{ asset('images/log-out.svg') }}" class="svg actual"
                                                    width="25" height="26">
                                                {{ trans('user.sidebar.logout') }}
                                            </a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                class="d-none"> @csrf </form>
                                        </li>
                                    </ul>
                                </div>
                                <div class="text-truncate" style="color: #a4a4a4;">{{ Auth::user()->email }}
                                </div>
                            </div>

                            <div class="ms-auto">
                                <a class="dropdown-item log-out-item" href="#"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <img src="{{ asset('images/sign-out-up.svg') }}" class="svg actual"
                                        width="20" height="20" />
                                    {{-- {{ trans('user.sidebar.logout') }} --}}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                    class="d-none"> @csrf
                                </form>
                            </div>


                        </div>
                    @endif
                </div>
            </div>

            <div class="sidebar-menu-top-box d-none">
                @if (!Auth::user())
                    <div class="auth_enter_btns">

                    </div>
                    <div class="menu-signsignup-link d-none">
                        <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#signInModal">
                            <img src="{{ asset('images/user-icon-up.svg') }}" class="svg actual" width="22"
                                height="22">
                            <p class="mb-0 d-inline-block align-middle">{{ trans('user.sidebar.sign_in') }} </p>
                        </a>
                    </div>
                @else
                    <div class="d-flex gap-3 align-items-center">
                        <div class="userPhoto">
                            <img src="{{ Auth::user()->image }}" alt="" width="50" height="50" />
                        </div>
                        <div class="text-start">
                            <div class="dropdown">
                                {{-- <div class="dropdown-toggle custom-arrow" type="button" data-bs-toggle="dropdown"
                                    style="color: #191919;text-wrap: wrap;">
                                    {{ Auth::user()->full_name }}
                                </div> --}}
                                <ul class="dropdown-menu py-0">
                                    <li>
                                        <a class="dropdown-item log-out-item" href="#"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <img src="{{ asset('images/log-out.svg') }}" class="svg actual"
                                                width="25" height="26">
                                            {{ trans('user.sidebar.logout') }}
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                            class="d-none"> @csrf </form>
                                    </li>
                                </ul>
                            </div>
                            <div class="text-truncate" style="color: var(--theme-dark1);">{{ Auth::user()->email }}
                            </div>
                        </div>

                        <div class="ms-auto">
                            <a class="dropdown-item log-out-item" href="#"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <img src="{{ asset('images/sign-out-up.svg') }}" width="20" height="20" />
                                {{-- {{ trans('user.sidebar.logout') }} --}}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </div>
                @endif
            </div>



        </div>


    </div>


</aside>
