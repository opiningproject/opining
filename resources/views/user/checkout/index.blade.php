@extends('layouts.user-app')

<?php
$zipcode = session('zipcode');
$house_no = session('house_no');
$street_name = session('street_name');
$city = session('city');
$cartAmount = 0.0;
$deliveryCharges = 0.0;

if ($zipcode) {
    $deliveryCharges = getDeliveryCharges($zipcode)->delivery_charge;
}
$serviceCharge = getRestaurantDetail()->service_charge;

$address = session('address');
$phone_no = session('phone_no');
$addressData = null;
if ($address) {
    $addressData = getAddressDetails($address);
}
$restaurantOpen = getRestaurantOpenTime();

$couponDiscount = isset($user->cart->coupon) ? ($user->cart->coupon->percentage_off / 100) * getCartTotalAmount() : 0;

?>
@section('content')
    <div class="main footer-hide header-fixed-page">
        <div class="main-view">
            <div class="container-fluid bd-gutter bd-layout">
                @include('layouts.user.side_nav_bar')
                <main class="bd-main order-1">
                    <div class="main-content pb-5 mobile-scrolllable-content checkout-mobile-scrolllable-content">
                        <div class="section-page-title main-page-title mb-0 title-mobile events-title">
                            <button type="button"
                                class="btn-close d-block position-absolute d-xxl-none top-0 mt-1 me-md-2 mt-md-2 end-0 ms-2 bg-arrow-mobile"
                                data-bs-dismiss="offcanvas" aria-label="Close" data-bs-target="#bdSidebarCart"
                                onclick="window.location.href='{{ url('/user/dashboard') }}';">
                                <i class="fa-solid fa-angle-left d-none"></i>
                            </button>


                            <h1 class="page-title">{{ trans('user.checkout.title') }}</h1>

                            <button class="navbar-toggler checkout-bag-count cart-navbar-toggler-inn p-2 d-none at-top-head"
                                type="button" data-bs-toggle="offcanvas" data-bs-target="#bdSidebarCart"
                                aria-controls="bdSidebarCart" aria-label="Toggle docs navigation">
                                {{-- <img src="{{ asset('images/toggle-icon.svg') }}" class="svg" width="18" height="18"> --}}
                                <span class="count"
                                    id="cart-item-count">{{ isset(Auth::user()->cart) ? Auth::user()->cart->dishDetails->count() : 0 }}</span>

                                <svg width="22px" height="22px" viewBox="-4 0 32 32" version="1.1"
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

                        <section class="custom-section checkout-section pt-0 pt-md-5 pb-0">
                            {{-- <h5 class="mobile-title mb-4 d-md-none all-validation-error" style="display: none"
                                id="all-validation-error">Please fill all details to continue with your order.</h5> --}}

                            <form id="final-checkout-form" class="final-checkout-form">
                                <input type="hidden" name="is_address_elected" value="{{ $address ?? 0 }}"
                                    id="address_selected">
                                <div class="row checkout-form-steps">
                                    <div class="checkout-form-item">
                                        <div class="form-step-icon">
                                            <div class="icon-form">
                                                <img src="{{ asset('images/user-white-icon.svg') }}" alt=""
                                                    class="svg" height="28" width="27">
                                            </div>
                                        </div>
                                        <div class="cart-form-card-body cursor-initial d-block">
                                            <div class="card custom-card h-100 custom-card-mobile-toggle">
                                                <div class="card-body checkout-form">
                                                    <div class="mobileStaticToggle" id="delivery-info-tab">
                                                        <div class="innerCon">
                                                            <div class="icon">
                                                                <img src="{{ asset('images/user-cart.svg') }}"
                                                                    alt="" />
                                                            </div>
                                                            <div class="textCon">
                                                                <h3>{{ session('zipcode') ? trans('user.checkout.delivery_address') : trans('user.checkout.takeaway_address') }}
                                                                </h3>
                                                                <p class="mb-0">
                                                                    @if ($street_name)
                                                                        {{ ($street_name ? $street_name : '') . ' ' . ($house_no ? $house_no : '') }}
                                                                    @elseif (session('zipcode') && !$street_name)
                                                                        {{ $house_no ? $house_no . ', ' . $zipcode : '' }}
                                                                    @else
                                                                        {{ getRestaurantDetail()->rest_address }}
                                                                    @endif
                                                                </p>
                                                                <p class="without-check-error mb-0"
                                                                    id="deliviery-address-error"></p>

                                                            </div>


                                                            <span class="success-ico success-address">
                                                                <img src="{{ asset('images/success-icon.svg') }}"
                                                                    class="svg" width="14" height="11">
                                                            </span>

                                                            <span class="toggleIco ms-auto">
                                                                <i class="fa-solid fa-angle-right"></i>
                                                                <span>

                                                        </div>
                                                    </div>
                                                    @if (session('zipcode'))
                                                        <div class="mobilecheckoutContent" id="delivery-mobile-content">
                                                            <div class="delivery-details">
                                                                <h4 class="custom-card-title-1 form-group mobile-hide">
                                                                    {{ trans('user.checkout.delivery_address') }}</h4>
                                                                <div class="row">
                                                                    <div
                                                                        class="col-xxl-6 col-xl-6 col-lg-4 col-md-6 col-sm-12 col-12">
                                                                        <div class="form-group">
                                                                            <label for="streetname"
                                                                                class="form-label">{{ trans('user.checkout.delivery_address') }}</label>
                                                                            @if (session('street_name') && !$addressData)
                                                                                <input type="text" name="street_name"
                                                                                    id="street_name" class="form-control"
                                                                                    required
                                                                                    value="{{ session('street_name') ? session('street_name') : '' }}" />
                                                                            @else
                                                                                <input type="text" name="street_name"
                                                                                    id="street_name" class="form-control"
                                                                                    required
                                                                                    value="{{ $addressData->street_name ?? '' }}" />
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                    <div
                                                                        class="col-xxl-6 col-xl-6 col-lg-4 col-md-6 col-sm-12 col-12">
                                                                        <div class="form-group">
                                                                            <label for="housenumber"
                                                                                class="form-label">{{ trans('user.checkout.house_no') }}</label>
                                                                            <input type="text" class="form-control"
                                                                                maxlength="10"
                                                                                placeholder="{{ trans('modal.address.house_no') }}"
                                                                                value="{{ $addressData->house_no ?? $house_no }}"
                                                                                name="house_no" id="house_no" required />
                                                                        </div>
                                                                    </div>
                                                                    <div
                                                                        class="col-xxl-6 col-xl-6 col-lg-4 col-md-6 col-sm-12 col-12">
                                                                        <div class="form-group">
                                                                            <label for="zipcode"
                                                                                class="form-label">{{ trans('user.checkout.zip_code') }}</label>
                                                                            <input type="text" name="zipcode"
                                                                                id="zipcode" class="form-control"
                                                                                value="{{ $addressData->zipcode ?? $zipcode }}"
                                                                                readonly />
                                                                        </div>
                                                                    </div>
                                                                    <div
                                                                        class="col-xxl-6 col-xl-6 col-lg-4 col-md-6 col-sm-12 col-12">
                                                                        <div class="form-group">
                                                                            <label for="city"
                                                                                class="form-label">{{ trans('user.checkout.city') }}</label>
                                                                            @if (session('city') && !$addressData)
                                                                                <input type="text" maxlength="25"
                                                                                    required name="city" id="city"
                                                                                    class="form-control"
                                                                                    value="{{ session('city') ? session('city') : '' }}" />
                                                                            @else
                                                                                <input type="text" maxlength="25"
                                                                                    required name="city" id="city"
                                                                                    class="form-control"
                                                                                    value="{{ $addressData->city ?? '' }}" />
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                    <div
                                                                        class="col-xxl-6 col-xl-6 col-lg-4 col-md-6 col-sm-12 col-12">
                                                                        <div class="form-group">
                                                                            <label for="companyname"
                                                                                class="form-label">{{ trans('user.checkout.company_name') }}</label>
                                                                            <input type="text" maxlength="30"
                                                                                class="form-control" name="company_name"
                                                                                value="{{ $addressData->company_name ?? '' }}" />
                                                                        </div>
                                                                    </div>
                                                                    <div
                                                                        class="col-xxl-6 col-xl-6 col-lg-4 col-md-6 col-sm-12 col-12">
                                                                        <div class="form-group">
                                                                            <label for="companyname"
                                                                                class="form-label">{{ trans('user.checkout.instruction') }}</label>
                                                                            <input type="text" class="form-control"
                                                                                name="instructions" maxlength="50"
                                                                                value="{{ $user->cart->delivery_note }}" />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    <div class="mobilecheckoutContent" id="delivery-user-mobile-content">
                                                        <h4 class="custom-card-title-1 form-group">
                                                            {{ trans('user.checkout.personal_detail') }}
                                                            <span
                                                                class="text-muted-lead-2">{{ trans('user.checkout.personal_detail_note') }}
                                                            </span>
                                                        </h4>
                                                        <div class="row">
                                                            <div
                                                                class="col-xxl-6 col-xl-6 col-lg-4 col-md-6 col-sm-12 col-12">
                                                                <div class="form-group">
                                                                    <label for="firstname"
                                                                        class="form-label">{{ trans('user.checkout.first_name') }}</label>
                                                                    <input type="text" class="form-control"
                                                                        name="first_name" required id="first_name"
                                                                        value="{{ $user->first_name }}" />
                                                                </div>
                                                            </div>
                                                            <div
                                                                class="col-xxl-6 col-xl-6 col-lg-4 col-md-6 col-sm-12 col-12">
                                                                <div class="form-group">
                                                                    <label for="lastname"
                                                                        class="form-label">{{ trans('user.checkout.last_name') }}</label>
                                                                    <input type="text" class="form-control"
                                                                        name="last_name" id="last_name"
                                                                        value="{{ $user->last_name }}" />
                                                                </div>
                                                            </div>
                                                            <div
                                                                class="col-xxl-6 col-xl-6 col-lg-4 col-md-6 col-sm-12 col-12">
                                                                <div class="form-group">
                                                                    <label for="restaurantpermit"
                                                                        class="form-label">{{ trans('user.checkout.phone') }}</label>
                                                                    <div class="input-group countrycode-phone-control">
                                                                        <button class="dropdown-toggle no-arrow"
                                                                            type="button" data-bs-toggle="dropdown"
                                                                            aria-expanded="false">
                                                                            <img src="{{ asset('images/netherlands-flag.svg') }}"
                                                                                alt="netherlands Flag" class="img-fluid">
                                                                        </button>
                                                                        <input type="text"
                                                                            class="form-control countrycode-input" readonly
                                                                            value="+31">
                                                                        <input type="number" class="form-control"
                                                                            minlength="9" maxlength="9" required
                                                                            name="phone_no" min="0" id="phone_no"
                                                                            value="{{ $user->phone_no == '' ? $phone_no : $user->phone_no }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div
                                                                class="col-xxl-6 col-xl-6 col-lg-4 col-md-6 col-sm-12 col-12">
                                                                <div class="form-group">
                                                                    <label for="email"
                                                                        class="form-label">{{ trans('user.checkout.email') }}</label>
                                                                    <input type="email" name="email" required
                                                                        id="email" class="form-control"
                                                                        value="{{ $user->email }}" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="checkout-form-item">
                                        <div class="form-step-icon">
                                            <div class="icon-form">
                                                <img src="{{ asset('images/delivery-time-icon.svg') }}" alt=""
                                                    class="svg" height="28" width="28">
                                            </div>
                                        </div>
                                        <div class="cart-form-card-body cursor-initial d-block">
                                            <div class="card custom-card h-100 custom-card-mobile-toggle">
                                                <div class="card-body pb-4 checkout-form">
                                                    <div class="mobileStaticToggle" id="delivery-time-tab">
                                                        <div class="innerCon">
                                                            <div class="icon">
                                                                <img src="{{ asset('images/checkout-clock.svg') }}"
                                                                    alt="" />
                                                            </div>
                                                            <div class="textCon">
                                                                <h3>{{ trans('user.checkout.delivery_time') }}</h3>
                                                                <p class="mb-0" id="del-type-mobile-text">
                                                                    {{ trans('user.checkout.asap') }}</p>
                                                                <p class="without-check-error mb-0"
                                                                    id="delivery-time-error"></p>
                                                            </div>
                                                            <span class="success-ico success-delivery-time">
                                                                <img src="{{ asset('images/success-icon.svg') }}"
                                                                    class="svg" width="14" height="11">
                                                            </span>
                                                            <span class="toggleIco ms-auto">
                                                                <i class="fa-solid fa-angle-right"></i>
                                                                <span>

                                                        </div>
                                                    </div>
                                                    <div class="mobilecheckoutContent" id="delivery-type-mobile-content">
                                                        <h4 class="custom-card-title-1 form-group mobile-hide">
                                                            {{ trans('user.checkout.delivery_time') }}</h4>
                                                        <div class="row">
                                                            <div
                                                                class="col-xxl-6 col-xl-6 col-lg-4 col-md-12 col-sm-12 col-12 my-auto">
                                                                <div class="custom-radio custom-checkbox-group mb-2 flex-wrap radio-flex-row"
                                                                    style="margin-bottom: 30px">
                                                                    <div class="radio delivery-time selected-radio">
                                                                        <input id="radio-1" name="del_radio"
                                                                            type="radio" class="radio-del-time" checked
                                                                            value="asap">
                                                                        <label for="radio-1"
                                                                            class="radio-label radio-del-time"
                                                                            id="asap">{{ trans('user.checkout.asap') }}</label>
                                                                    </div>
                                                                    <div class="radio delivery-time">
                                                                        <input id="radio-2" name="del_radio"
                                                                            type="radio" class="radio-del-time"
                                                                            value="customize-time">
                                                                        <label for="radio-2" id="customize-time"
                                                                            class="radio-label radio-del-time">{{ trans('user.checkout.customize_time') }}
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-xxl-3 col-xl-6 col-lg-4 col-md-6 col-sm-12 col-12 customize-time-div"
                                                                style="display: none">
                                                                <div class="form-group">
                                                                    <label for="selecttime"
                                                                        class="form-label">{{ trans('user.checkout.select_time') }}</label>
                                                                    {{--                                <input type="text" class="timepicker form-control time-form-control" name="custom-delivery-time" id="custom-delivery-time" style="max-height: fit-content"> --}}
                                                                    <select class="form-control time-form-control"
                                                                        name="del_time" id="custom-delivery-time">
                                                                        <option value="">Please Select Time</option>
                                                                        <?php
                                                                        $current_time = new DateTime();
                                                                        $current_minute = (int) $current_time->format('i');
                                                                        $current_hour = (int) $current_time->format('H');
                                                                        ?>

                                                                        <?php


                                                                        if ($current_minute > 30) {

                                                                            $current_hour += 2;
                                                                            $current_minute = 0;
                                                                        } elseif ($current_minute > 0) {

                                                                            $current_hour += 1;
                                                                            $current_minute = 30;
                                                                        } else {

                                                                            $current_hour += 1;
                                                                            $current_minute = 0;
                                                                        }


                                                                        $current_time->setTime($current_hour % 24, $current_minute);


                                                                        for ($i = 0; $i < 24; $i++) {
                                                                        $time_options = $current_time->format('H:i');
                                                                        $current_time->modify('+30 minutes'); ?>
                                                                        <option value="{{ $time_options }}">
                                                                            {{ $time_options }}</option>
                                                                        <?php  } ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <span class="selectTimeValidation"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="checkout-form-item">
                                        <div class="form-step-icon">
                                            <div class="icon-form">
                                                <img src="{{ asset('images/timer.svg') }}" alt="" class="svg"
                                                    height="26" width="26">
                                            </div>
                                        </div>
                                        <div
                                            class="cart-form-card-body cursor-initial cart-form-card-body-last d-block pb-0">
                                            <div class="card custom-card h-100 mb-4 custom-card-mobile-toggle">
                                                <div class="card-body pb-0 checkout-form">
                                                    <div class="mobileStaticToggle" id="payment-type-mobile-tab">
                                                        <div class="innerCon">
                                                            <div class="icon">
                                                                <img src="{{ asset('images/checkout-wlt.svg') }}"
                                                                    alt="" />
                                                            </div>
                                                            <div class="textCon">
                                                                <h3>{{ trans('user.checkout.payment_method') }}</h3>
                                                                <p class="mb-0" id="mobile-payment-type-text">iDEAL</p>
                                                                <p class="without-check-error mb-0"
                                                                    id="payment-method-error"></p>
                                                            </div>
                                                            <span class="success-ico success-payment-method">
                                                                <img src="{{ asset('images/success-icon.svg') }}"
                                                                    class="svg" width="14" height="11">
                                                            </span>
                                                            <span class="toggleIco ms-auto">
                                                                <i class="fa-solid fa-angle-right"></i>
                                                                <span>
                                                        </div>
                                                    </div>
                                                    <div class="mobilecheckoutContent" id="payment-type-mobile-content">
                                                        <div class=" payment-nav payment-nav-mobile mb-0">
                                                            <div class="payment-navigation">
                                                                <h4 class="custom-card-title-1 form-group mobile-hide">
                                                                    {{ trans('user.checkout.payment') }}</h4>
                                                                <div class="nav flex-column nav-pills custom-radio-place overflow-initial"
                                                                    id="v-pills-tab" role="tablist"
                                                                    aria-orientation="vertical">
                                                                    <button
                                                                        class="nav-link active payment-type-tab radio-del-time1"
                                                                        id="v-pills-ideal-tab" data-type="3"
                                                                        data-bs-toggle="pill"
                                                                        data-bs-target="#v-pills-ideal" type="button"
                                                                        role="tab" aria-controls="v-pills-ideal"
                                                                        aria-selected="true">
                                                                        <img src="{{ asset('images/ideal.svg') }}"
                                                                            alt="" height="22" width="25"
                                                                            class="svg">
                                                                        iDEAL

                                                                        <div class="custom-radio">
                                                                            <div class="radio">
                                                                                <input id="ideal-radio"
                                                                                    name="del_radio_new" type="radio"
                                                                                    class="radio-ideal" checked=""
                                                                                    value="asap">
                                                                                <label for="radio-1"
                                                                                    class="radio-label radio-ideal"
                                                                                    id="ideal-card"></label>
                                                                            </div>
                                                                        </div>

                                                                    </button>
                                                                    <button
                                                                        class="nav-link payment-type-tab radio-del-time1"
                                                                        data-type="1" id="v-pills-creditanddebitcard-tab"
                                                                        data-bs-toggle="pill"
                                                                        data-bs-target="#v-pills-creditanddebitcard"
                                                                        type="button" role="tab"
                                                                        aria-controls="v-pills-creditanddebitcard"
                                                                        aria-selected="false">
                                                                        <img src="{{ asset('images/stripe.svg') }}"
                                                                            alt="" height="20" width="27"
                                                                            class="svg">
                                                                        {{ trans('user.checkout.cc_card') }}

                                                                        <div class="custom-radio">
                                                                            <div class="radio">
                                                                                <input id="cc-radio" name="del_radio_new"
                                                                                    type="radio" class="radio-cc"
                                                                                    value="asap">
                                                                                <label for="radio-1"
                                                                                    class="radio-label radio-cc"
                                                                                    id="cc_card"></label>
                                                                            </div>
                                                                        </div>
                                                                    </button>
                                                                    <button
                                                                        class="nav-link payment-type-tab radio-del-time1"
                                                                        id="v-pills-cashondelivery-tab" data-type="2"
                                                                        data-bs-toggle="pill"
                                                                        data-bs-target="#v-pills-cashondelivery"
                                                                        type="button" role="tab"
                                                                        aria-controls="v-pills-cashondelivery"
                                                                        aria-selected="false">
                                                                        <img src="{{ asset('images/cod_new.svg') }}"
                                                                            alt="" height="30" width="31"
                                                                            class="svg">
                                                                        {{ trans('user.checkout.cod') }}
                                                                        <div class="custom-radio">
                                                                            <div class="radio">
                                                                                <input id="cod-radio" name="del_radio_new"
                                                                                    type="radio" class="radio-cod"
                                                                                    value="asap">
                                                                                <label for="radio-1"
                                                                                    class="radio-label radio-cod"
                                                                                    id="cc_cod"></label>
                                                                            </div>
                                                                        </div>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            <div class="w-100">
                                                                <div class="tab-content w-100" id="v-pills-tabContent">
                                                                    <div class="tab-pane fade show active"
                                                                        id="v-pills-ideal" role="tabpanel"
                                                                        aria-labelledby="v-pills-ideal-tab"
                                                                        tabindex="0">
                                                                        <main class="bd-main order-1">
                                                                            <div class="d-flex flex-column p-0 w-100">
                                                                                <div
                                                                                    class="section-page-title main-page-title row justify-content-between d-none d-sm-block">
                                                                                    <div class="col-12">
                                                                                        <h4
                                                                                            class="custom-card-title-1 form-group mobile-hide">
                                                                                            {{ trans('user.checkout.order_payment') }}
                                                                                        </h4>
                                                                                    </div>
                                                                                </div>
                                                                                <form id="payment-form">
                                                                                    <label for="ideal-bank-element"
                                                                                        class="mb-2">
                                                                                        <strong>{{ trans('user.checkout.banks') }}</strong>
                                                                                    </label>
                                                                                    <div id="ideal-bank-element"
                                                                                        class="custom_select">
                                                                                        <!-- A Stripe Element will be inserted here. -->
                                                                                    </div>
                                                                                    {{-- <button type="submit">Pay</button> --}}
                                                                                    <!-- Used to display form errors. -->
                                                                                    <div id="error-message"
                                                                                        role="alert"></div>
                                                                                </form>
                                                                                <div id="messages" role="alert"
                                                                                    style="display: none;"></div>
                                                                            </div>
                                                                        </main>
                                                                    </div>
                                                                    <div class="tab-pane fade"
                                                                        id="v-pills-creditanddebitcard" role="tabpanel"
                                                                        aria-labelledby="v-pills-creditanddebitcard-tab"
                                                                        tabindex="0">
                                                                        <h4
                                                                            class="custom-card-title-1 form-group mobile-hide">
                                                                            {{ trans('user.checkout.add_card') }}</h4>
                                                                        <div class="payment-form-card">
                                                                            <input type="text"
                                                                                class="form-control cardNumber card-validate"
                                                                                name="card_number" readonly required
                                                                                placeholder="{{ trans('user.checkout.card_no') }}">
                                                                            <div class="row g-0">
                                                                                <div
                                                                                    class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                                                    <input type="text" name="exp_date"
                                                                                        required id="exp_date"
                                                                                        class="form-control expireYear card-validate"
                                                                                        readonly
                                                                                        placeholder="{{ trans('user.checkout.valid_till') }} (MM/YY)">
                                                                                </div>
                                                                                <div
                                                                                    class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                                                                    <input type="number" name="cvv"
                                                                                        required
                                                                                        class="form-control form-control-br-left card-validate"
                                                                                        id="cvv" readonly
                                                                                        placeholder="CVV" minlength="3"
                                                                                        maxlength="3">
                                                                                </div>
                                                                            </div>
                                                                            <input type="text"
                                                                                class="form-control border-0 card-validate"
                                                                                name="card_name" required readonly
                                                                                id="card_name"
                                                                                placeholder="{{ trans('user.checkout.card_name') }}">
                                                                        </div>
                                                                    </div>
                                                                    <div class="tab-pane fade" id="v-pills-cashondelivery"
                                                                        role="tabpanel"
                                                                        aria-labelledby="v-pills-cashondelivery-tab"
                                                                        tabindex="0"></div>
                                                                </div>
                                                            </div>
                                                            <input type="hidden" value="3" id="payment_type"
                                                                name="payment_type">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-check form-group custom-checkbox">
                                                <input class="form-check-input check-input-secondary" type="checkbox"
                                                    name="receive_mail" id="receiveemail" value="1"
                                                    {{ $user->enable_email_notification == '1' ? 'checked' : '' }}>
                                                <label class="form-check-label text-capitalize align-middle"
                                                    for="receiveemail"> {{ trans('user.checkout.receive_update_emails') }}
                                                </label>
                                            </div>
                                            <div class="row">
                                                <div class="col-xxl-6 col-xl-6 col-lg-4 col-md-6 col-sm-12 col-12">
                                                    <div class="form-group">
                                                        <button type="submit"
                                                            class="align-middle btn btn-custom-yellow btn-default d-block w-100 checkout-btn-sticky">{{ trans('user.checkout.pay') }}
                                                            €{{ orderTotalPayAmount() }} {{ trans('user.checkout.with') }}
                                                            <span>&nbsp;<span id="total-amt-pay-btn">iDEAL</span></span>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </section>
                    </div>


                    <aside class="cart-sidebar cart-order-details-sidebar position-relative">
                        <div class="offcanvas-xxl offcanvas-end h-100" tabindex="-1" id="bdSidebarCart"
                            aria-labelledby="bdSidebarCartOffcanvasLabel">
                            <div class="offcanvas-header p-0" style="display: block;"></div>
                            <div class="offcanvas-body pt-3 h-100">

                                <button type="button"
                                    class="btn-close d-block position-absolute d-none d-md-block d-xxl-none top-0 mt-1 me-md-2 mt-md-2 end-0 ms-2 bg-arrow-mobile"
                                    data-bs-dismiss="offcanvas" aria-label="Close" data-bs-target="#bdSidebarCart"
                                    onclick="window.location.href='{{ url('/user/dashboard') }}';">
                                    <i class="fa-solid fa-angle-left d-none"></i>
                                </button>

                                <div class="mobile-order-page">
                                    <div class="d-block d-md-none">
                                        <div class="mobile-head-belt">
                                            <button type="button" class="btn-close bg-arrow-mobile"
                                                data-bs-dismiss="offcanvas" aria-label="Close"
                                                data-bs-target="#bdSidebarCart">
                                                <i class="fa-solid fa-angle-left d-none"></i>
                                            </button>
                                            <h1>{{ trans('user.my_orders.order_details') }}</h1>
                                        </div>
                                    </div>

                                    <div class="order-details-block">
                                        <div class="navbar navbar-expand-lg pt-0 h-100">
                                            <div class="cart-sidebar-content position-relative h-100">
                                                <div class="navbar-collapse cartbox-collapse">
                                                    <div class="cart-section cart-checkout-section">

                                                        <h6 class="cart-title d-none d-md-block">
                                                            {{ trans('user.my_orders.order_details') }}</h6>

                                                        @foreach ($user->cart->dishDetails as $dishDetails)
                                                            <div class="cart-items">
                                                                <div class="row">
                                                                    <div class="col-12">
                                                                        <div class="row stock-card mb-0 ">
                                                                            <div class="d-flex cart-item-row">
                                                                                <div class="cart-custom-w-col-detail ps-0">
                                                                                    <div class="cart-item-detail">

                                                                                        <div
                                                                                            class="d-flex align-items-center justify-content-between">
                                                                                            <p
                                                                                                class="d-inline-flex flex-nowrap item-name mb-0">
                                                                                                {{--                                                                                    <span class="order-total-item pe-2 mb-0">{{ $dishDetails->qty }}</span> --}}
                                                                                                <span
                                                                                                    class="order-total-item pe-2 mb-0">{{ $dishDetails->qty }}</span>
                                                                                                <span
                                                                                                    class="text-decoration-underline">
                                                                                                    {{ $dishDetails->dish->name }}</span>
                                                                                            </p>
                                                                                            <span
                                                                                                class="cart-item-price ms-auto">+€{{ $dishDetails->dish->price }}</span>
                                                                                        </div>
                                                                                        <div class="d-flex">
                                                                                            <div class="text "
                                                                                                id="order-ingredient-{{ $dishDetails->id }}">
                                                                                                <p
                                                                                                    class="mb-0 item-options mb-0">
                                                                                                    {{ $dishDetails->dishOption->name ?? '' }}
                                                                                                </p>
                                                                                                @php
                                                                                                    $htmlString = getOrderDishIngredients1(
                                                                                                        $dishDetails,
                                                                                                    );
                                                                                                    $cleanedHtmlString = str_replace(
                                                                                                        '"',
                                                                                                        '',
                                                                                                        $htmlString,
                                                                                                    );
                                                                                                @endphp

                                                                                                <ul class="items-additional mb-2"
                                                                                                    id="item-ing-desc{{ $dishDetails->id }}">
                                                                                                    {!! $cleanedHtmlString !!}
                                                                                                </ul>
                                                                                                {{--                                                                                    {{ getOrderDishIngredients($dishDetails) }} --}}
                                                                                            </div>

                                                                                            {{-- <div class="text">
                                                                                            <a class="item-customize"
                                                                                                href="javascript:void(0)"
                                                                                                id="read-more-{{ $dishDetails->id }}"
                                                                                                onclick="readMore({{ $dishDetails->id }})">
                                                                                                {{ trans('user.my_orders.read_more') }}</a>
                                                                                            <a class="item-customize"
                                                                                                href="javascript:void(0)"
                                                                                                style="display:none;"
                                                                                                id="close-{{ $dishDetails->id }}"
                                                                                                onclick="hideReadMore({{ $dishDetails->id }})">
                                                                                                Close</a>
                                                                                        </div> --}}
                                                                                        </div>

                                                                                        <div class="cart-items-list-row-n">
                                                                                            <div
                                                                                                class="from-group addnote-from-group mb-0 mb-1">
                                                                                                <div class="form-group mb-0 dish-group"
                                                                                                    data-dish-id="198">
                                                                                                    <label
                                                                                                        for="dishnameenglish"
                                                                                                        class="form-label mb-0 {{ !empty($dishDetails->notes) ? 'd-none' : '' }}">Add
                                                                                                        Notes</label>
                                                                                                    <input type="text"
                                                                                                        data-id="198"
                                                                                                        maxlength="50"
                                                                                                        class="form-control dish-notes {{ !empty($dishDetails->notes) ? '' : 'd-none' }}"
                                                                                                        value="{{ $dishDetails->notes }}"
                                                                                                        data-id="{{ $dishDetails->id }}"
                                                                                                        placeholder="{{ trans('user.my_orders.type_here') }}">
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>

                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                        <div class="bill-detail-invoice pt-md-3">
                                                            <h6 class="cart-title d-none d-md-block">
                                                                {{ trans('user.my_orders.bill_details') }}</h6>
                                                            <div class="table-responsive">
                                                                <table class="table table-borderless">
                                                                    <tbody>
                                                                        <tr>
                                                                            <td class="text-start">
                                                                                <span
                                                                                    class="text-muted-1 bill-count-name">{{ trans('user.my_orders.item_total') }}</span>
                                                                            </td>
                                                                            <td class="text-end">
                                                                                <span
                                                                                    class="bill-count">€{{ number_format(getCartTotalAmount(), 2) }}</span>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="text-start">
                                                                                <span
                                                                                    class="text-muted-1 bill-count-name">{{ trans('user.my_orders.service_charge') }}</span>
                                                                            </td>
                                                                            <td class="text-end">
                                                                                <span
                                                                                    class="bill-count">€{{ number_format($serviceCharge, 2) }}</span>
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td class="text-start">
                                                                                <span
                                                                                    class="text-muted-1 bill-count-name">{{ trans('user.my_orders.delivery_charge') }}</span>
                                                                            </td>
                                                                            <td class="text-end">
                                                                                <span
                                                                                    class="bill-count">€{{ number_format($deliveryCharges, 2) }}</span>
                                                                            </td>
                                                                        </tr>
                                                                        <tr
                                                                            {{ isset($user->cart->coupon) ? '' : 'style=display:none' }}>
                                                                            <td class="text-start">
                                                                                <span
                                                                                    class="text-custom-light-green bill-count-name">Coupon
                                                                                    Discount({{ $user->cart->coupon_code }})</span>
                                                                            </td>
                                                                            <td class="text-end">
                                                                                <span
                                                                                    class="text-custom-light-green bill-count">-€{{ number_format($couponDiscount, 2) }}</span>
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                    <tfoot>
                                                                        <tr>
                                                                            <td class="text-start">
                                                                                {{ trans('user.my_orders.total') }}</td>
                                                                            <td class="text-end">
                                                                                <span class="bill-total-count"
                                                                                    id="total-payment-text">€{{ orderTotalPayAmount() }}</span>
                                                                            </td>
                                                                        </tr>
                                                                    </tfoot>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- <div class="d-flex justify-content-end mb-2">
                                    <button type="button" class="btn-close d-block d-xxl-none"
                                            data-bs-dismiss="offcanvas" aria-label="Close"
                                            data-bs-target="#bdSidebarCart"></button>
                                </div> --}}

                            </div>
                        </div>
                    </aside>
                </main>
            </div>
        </div>
        <!-- start footer -->
        @include('layouts.user.footer_design')
        <!-- end footer -->
    </div>
@endsection

@section('script')
    <script>
        var validationMsg = {
            asap: '{{ trans('user.checkout.asap') }}',
            customize_time: '{{ trans('user.checkout.customize_time') }}',
            card: '{{ trans('user.my_orders.card') }}',
            cash: '{{ trans('user.my_orders.cash') }}',
            ideal: '{{ trans('user.checkout.ideal') }}',
        }
    </script>
    <script type="text/javascript" async
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCgn-yE-BywHdBacEmRH9IWEFbuaM4PWGw&loading=async"></script>
    <script type="text/javascript" src="https://js.stripe.com/v3/"></script>
    <script src="https://cdn.socket.io/4.7.5/socket.io.min.js"
        integrity="sha384-2huaZvOR9iDzHqslqwpR87isEmrfxqyWOF7hr7BY6KG0+hVKLoEXMPUJw3ynWuhO" crossorigin="anonymous">
    </script>

    <script type="text/javascript" src="{{ asset('js/user/check-out.js') }}"></script>
    <script>
        function isDesktopView() {
            return $(window).width() >= 768;
        }

        $(".success-ico.success-address").hide();
        $(".success-ico.success-delivery-time").hide();
        $(".success-ico.success-payment-method").hide();


        // Mobile view radio button
        $(document).on('click', '.radio-del-time1', function() {
            let paymentType = $(this).data("type");
            if (paymentType == 1) {

                $('#cc-radio').prop('checked', true);
            } else if (paymentType == 2) {

                $('#cod-radio').prop('checked', true);
            } else {
                $('#ideal-radio').prop('checked', true);
            }
        });
        // Mobile view radio button
        $(".radio-del-time").change(function() {
            $(".radio").removeClass('selected-radio');

            if ($(this).is(":checked")) {
                $(this).parent().addClass('selected-radio');
            }
        });

        var socket = io("https://gomeal-qa.inheritxdev.in/web-socket", {
            transports: ['websocket', 'polling', 'flashsocket']
        });
        var public_key = '{{ config('params.stripe.sandbox.public_key') }}';
        const stripe = Stripe(public_key, {
            apiVersion: '2020-08-27'
        });

        const elements = stripe.elements();
        const options = {
            // Custom styling can be passed to options when creating an Element
            style: {
                base: {
                    padding: '10px 12px',
                    color: '#32325d',
                    fontSize: '16px',
                    '::placeholder': {
                        color: '#aab7c4'
                    },
                },
            },
        };

        const idealBank = elements.create('idealBank', options);

        idealBank.mount('#ideal-bank-element');
        var selectedBank = false

        $(function() {
            var startTime = '<?= date('H:i', strtotime('+30 mins')) ?>';
            var endTime = '<?= $restaurantOpen->end_time ?>';
            $('.timepicker').timepicker({
                timeFormat: 'HH:mm',
                interval: 30,
                dynamic: true,
                dropdown: true,
                scrollbar: true,
                minTime: startTime,
                maxTime: endTime,
            });
            idealBank.on('change', function(event) {
                selectedBank = true
            });
        })


        $("#custom-delivery-time").change(function() {

            var deliveryType = $('input[name=del_radio]:checked').val()
            if (deliveryType == 'customize-time' && $('#custom-delivery-time').val() == '') {
                // alert('Please select time')
                if (isDesktopView()) {
                    alert('Please select time.');
                }
                $("#delivery-time-error").text("Choose a delivery time");
                return false;
            }
            $("#delivery-time-error").text("");

        });

        async function addOrder() {

            var deliveryType = $('input[name=del_radio]:checked').val()
            var paymentType = $('#payment_type').val()
            var zipcode = $('#zipcode').val()
            console.log('zipcode', zipcode)

            let first_name = $('#first_name').val();
            let last_name = $('#last_name').val();
            let email = $('#email').val();
            let phone_no = $('#phone_no').val();

            // if (deliveryType == 'customize-time' && $('#custom-delivery-time').val() == '') {
            //     alert('Please select time')
            //     return false
            // }

            if (!isDesktopView()) {
                if (first_name == '' || last_name == '' || email == '' || phone_no == '') {
                    $(".success-ico.success-address").hide();
                    $("#deliviery-address-error").text("Please fill all address details.");
                    return false
                } else {
                    $("#deliviery-address-error").text("");
                    $(".success-ico.success-address").show();
                }
            }

            if (deliveryType == 'customize-time' && $('#custom-delivery-time').val() == '') {
                if (isDesktopView()) {
                    alert('Please select time.');
                    return false
                }
                // alert('Please select time');

                $("#delivery-time-error").text("Choose a delivery time");
                $(".success-ico.success-delivery-time").hide();
                return false
            } else {
                if (!isDesktopView()) {
                    $(".success-ico.success-delivery-time").show();
                    $("#delivery-time-error").text(" ");
                }
            }

            var checkoutData = new FormData(document.getElementById('final-checkout-form'))
            var latitude = ''
            var longitude = ''

            if (paymentType == '3' && selectedBank == false) {

                if (isDesktopView()) {
                    alert('Please select bank to continue');
                    return false
                }

                $("#payment-method-error").text("Please select bank to continue");
                $(".success-ico.success-payment-method").hide();
                return false
            } else {
                if (!isDesktopView()) {
                    $("#payment-method-error").text("");
                    $(".success-ico.success-payment-method").show();
                }

            }


            if (zipcode != undefined) {
                var streetName = $('#street_name').val()
                var houseNo = $('#house_no').val()
                var city = $('#city').val()
                var address = houseNo + ' ' + streetName + ' ' + city

                try {
                    var geocoder = new google.maps.Geocoder();

                    await geocoder.geocode({
                        'address': address
                    }, function(results, status) {

                        if (status == google.maps.GeocoderStatus.OK) {
                            latitude = results[0].geometry.location.lat();
                            longitude = results[0].geometry.location.lng();
                        }
                    });

                } catch (err) {
                    //alert(err)
                }
            }

            checkoutData.append('longitude', longitude)
            checkoutData.append('latitude', latitude)

            await $.ajax({
                url: baseURL + '/user/place-order',
                type: 'POST',
                processData: false,
                contentType: false,
                data: checkoutData,
                async success(response) {
                    if (response.status == 200) {
                        socket.emit('sendOrderNotification');
                        if (paymentType == '2') {
                            toastr.success(response.message.data)

                            setTimeout(function() {
                                window.location.replace(baseURL + '/user/orders')
                            }, 2000);

                        } else if (paymentType == '3') {
                            const {
                                error,
                                paymentIntent
                            } = await stripe.confirmIdealPayment(
                                response.message.paymentIntent.client_secret, {
                                    payment_method: {
                                        ideal: idealBank,
                                    },
                                    return_url: baseURL + '/user/redirect-online-payment',
                                },
                            );
                            if (error) {
                                alert(error.message);
                                return;
                            }
                        } else {
                            if (response.message.cardPayment == 200) {
                                toastr.success(response.message.data)
                                setTimeout(function() {
                                    window.location.replace(baseURL + '/user/orders')
                                }, 2000);
                            } else if (response.message.cardPayment == 402) {
                                window.location.replace(response.message.redirectionUrl)
                            }
                        }
                    } else {
                        alert(response.message)
                    }
                },
                error(response) {

                }
            })

        }


        $(document).on('click', '.dish-group .form-label', function() {
            var formGroup = $(this).closest('.dish-group');
            var inputField = formGroup.find('input.dish-notes');

            $(this).addClass("d-none");
            inputField.removeClass("d-none");
        })
    </script>
@endsection
