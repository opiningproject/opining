@extends('layouts.app')
@section('content')

    <?php

    use App\Enums\OrderStatus;
    use App\Enums\OrderType;
    use App\Enums\PaymentStatus;
    use App\Enums\PaymentType;
    use App\Enums\RefundStatus;
    ?>
    <div class="main">
        <div class="main-view">
            <div class="container-fluid bd-gutter bd-layout">
                @include('layouts.admin.side_nav_bar')
                <main class="bd-main updated_order order-1 w-100 position-relative">
                    <div class="main-content food-order-main-content d-flex flex-column h-100 order-page">
                        <div
                            class="section-page-title mb-0 d-flex align-items-center justify-content-end gap-2 order-page-bar">
                            <h1 class="page-title me-auto">{{ trans('rest.food_order.orders') }} <span
                                    class="count count-order"> {{ getOpenOrders() }} </span></h1>
                            <div class="btn-grp btn-grp-gap-10 d-flex align-items-center flex-wrap" id="order-dilters">
                                <div class="header-filter-order d-flex align-items-center flex-wrap">

                                    <div class="drop_with_search">
                                        <div class="select-options">
                                            <select class="form-control" id="order-tabs-dropdown">
                                                <option value="all" selected>{{ trans('rest.sidebar.all') }}
                                                </option>
                                                <option value="name">{{ trans('rest.food_order.name') }}</option>
                                                <option value="phone_number">{{ trans('rest.food_order.phone_number') }}
                                                </option>
                                                <option value="order_number">{{ trans('rest.food_order.order_number') }}
                                                </option>
                                                <option value="address">{{ trans('rest.food_order.address') }}</option>
                                                <option
                                                    value="zip_code">{{ trans('rest.food_order.zip_code') }}</option>
                                                <option value="dish">{{ trans('rest.food_order.dish') }}</option>
                                            </select>
                                        </div>
                                        <div class="search-has col order-filters-search">
                                            <span class="fa fa-search form-control-feedback"></span>
                                            <input type="text" class="form-control" id="search-order-new"
                                                   value="{{ request()->query('search', '') }}" placeholder="Search">
                                        </div>
                                    </div>
                                    <div class="dropdown custom-dropdown">
                                        <span class="count count-filter d-none"> </span>
                                        <button class="form-control dropdown-toggle" type="button"
                                                id="dropdownMenuButton"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                            {{ trans('rest.food_order.filter_orders') }}
                                        </button>
                                        <ul class="dropdown-menu order-filter" aria-labelledby="dropdownMenuButton">
                                            <li>
                                                <label class="checkbox-label">
                                                    <input type="checkbox" class="checkbox" id="all" name="all"><label
                                                        for="all" class="checkmark"></label>
                                                    {{ trans('rest.food_order.all') }}
                                                </label>
                                            </li>
                                            <li>
                                                <label class="checkbox-label">
                                                    <input type="checkbox" class="checkbox" id="online"
                                                           name="online"><label
                                                        for="online" class="checkmark"></label>
                                                    {{ trans('rest.food_order.online_orders') }}
                                                </label>
                                            </li>
                                            <li>
                                                <label class="checkbox-label">
                                                    <input type="checkbox" class="checkbox" id="manual"
                                                           name="manual"><label
                                                        for="manual" class="checkmark"></label>
                                                    {{ trans('rest.food_order.manual_orders') }}
                                                </label>
                                            </li>
                                            <li>
                                                <label class="checkbox-label">
                                                    <input type="checkbox" class="checkbox" id="delivery"
                                                           name="delivery"><label
                                                        for="delivery" class="checkmark"></label>
                                                    {{ trans('rest.food_order.delivery') }}
                                                </label>
                                            </li>
                                            <li>
                                                <label class="checkbox-label">
                                                    <input type="checkbox" class="checkbox" id="takeaway"
                                                           name="takeaway"><label
                                                        for="takeaway" class="checkmark"></label>
                                                    {{ trans('rest.food_order.take_away') }}
                                                </label>
                                            </li>
                                            <li>
                                                <label class="checkbox-label">
                                                    <input type="checkbox" class="checkbox" id="open" name="open"><label
                                                        for="open" class="checkmark"></label>
                                                    {{ trans('rest.food_order.open_orders') }}
                                                </label>
                                            </li>
                                            <li>
                                                <label class="checkbox-label">
                                                    <input type="checkbox" class="checkbox" id="delivered"
                                                           name="delivered"><label
                                                        for="delivered" class="checkmark"></label>
                                                    {{ trans('rest.food_order.delivered_orders') }}
                                                </label>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <button type="button" name="clear" value="all" id="clear"
                                        class="btn btn-site-theme clear-button order-filters-search">{{ trans('rest.food_order.create_order') }}</button>

                            </div>
                        </div>
                        <div class="orderList">
                            <div class="order-listing-container">
                                <div class="order-row">
                                    @foreach($allOrders as $key => $ord)
                                        <?php    $userDetails = $ord->orderUserDetails; ?>
                                        <div class="order-col" id="order-{{ $ord->id }}" data-id="{{ $ord->id }}">
                                            <div class="order-box">
                                                <div class="timing">
                                                    <h3 class="expectedDeliveryTime-{{$ord->id}}">{{ $ord->expected_delivery_time ? date('H:i', strtotime($ord->expected_delivery_time)) : date('H:i', strtotime(\Carbon\Carbon::parse($ord->created_at)->addMinutes($orderDeliveryTime))) }}</h3>
                                                    <label class="success">{{ $ord->delivery_time }}</label>
                                                    <h4 class="mt-2">
                                                        {{ $ord->order_type == OrderType::Delivery ? trans('rest.food_order.delivery') : trans('rest.food_order.pickup') }}
                                                    </h4>
                                                </div>

                                                <div class="details">
                                                    <div class="left">
                                                        <h4>{{ $userDetails->order_name }}</h4>
                                                        @if ($ord->order_type == OrderType::Delivery)
                                                            <p class="mb-0">
                                                                <?php
                                                                echo $userDetails->house_no . ', ' . $userDetails->street_name . ', ' . $userDetails->city . ', ' . $userDetails->zipcode;
                                                                ?>
                                                            </p>
                                                        @else
                                                            <p class="mb-0">
                                                                {{ getRestaurantDetail()->rest_address }}
                                                            </p>
                                                        @endif
                                                    </div>

                                                    <div class="right text-end ps-2">
                                                        <p class="mb-0">{{ date('d-m-Y H:i', strtotime($ord->created_at)) }}</p>
                                                        <p class="mb-0">Web #{{$ord->id}}</p>
                                                    </div>
                                                </div>

                                                <div class="actions">
                                                    <h5 class="mb-0 price_status">
                                                        <b>€{{ number_format($ord->total_amount, 2) }}</b>&nbsp;&nbsp;|&nbsp;&nbsp;{{ $ord->payment_type == PaymentType::Cash && $ord->order_status != OrderStatus::Delivered ? 'Unpaid' : 'Paid' }}
                                                    </h5>
                                                    <button
                                                        class="orderDetails order-status-{{ $ord->id }} btn {{orderStatusBox($ord)->color }}" onclick="orderDetailNew({{ $ord->id }})">
                                                        {{ orderStatusBox($ord)->text }}</button>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="d-flex justify-content-end align-items-center pt-3">
                                <!-- Pagination -->
                                <nav aria-label="Page navigation example">
                                    {{ $allOrders->links() }}
                                </nav>

                                <!-- Filter buttons -->
                                <div class="filter-btn-group">
                                    <button type="button" class="btn">
                                        <img src="{{ asset(path: 'images/bike-white.svg') }}" alt="Bike"/>
                                    </button>

                                    <button type="button" class="btn">
                                        <img src="{{ asset(path: 'images/map-white.svg') }}" alt="Bike"/>
                                    </button>

                                    <button type="button" class="btn order-setting">
                                        <img src="{{ asset(path: 'images/setting-white.svg') }}" alt="Bike"/>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <!-- start footer -->
{{--    @include('admin.orders.order-detail-popup')--}}
        <div class="modal fade custom-modal order-detail-popup"
             id="orderDetailModal" tabindex="-1" aria-labelledby="orderDetailModal" aria-hidden="true">
        </div>
    @include('admin.orders.order-setting-popup')
    @include('layouts.admin.footer_design')
    @include('admin.modals.change-order-status')
    <!-- end footer -->
    </div>
@endsection
@section('script')
    <script type="text/javascript" src="{{ asset('js/new-orders.js')}}"></script>
@endsection
