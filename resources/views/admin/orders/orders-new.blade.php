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
                        <h1 class="page-title me-auto">Orders <span class="count">{{ getOpenOrders() }}</span></h1>
                        <div class="btn-grp btn-grp-gap-10 d-flex align-items-center flex-wrap" id="order-dilters">
                            <div class="header-filter-order d-flex align-items-center flex-wrap">

                                <div class="drop_with_search">
                                    <div class="select-options">
                                        <select class="form-control" id="order-tabs-dropdown">
                                            <option value="#all-orders" selected>{{ trans('rest.sidebar.all') }}
                                            </option>
                                            <option value="#open-orders">{{ trans('rest.sidebar.open') }}</option>
                                        </select>
                                    </div>
                                    <div class="search-has col order-filters-search">
                                        <span class="fa fa-search form-control-feedback"></span>
                                        <input type="text" class="form-control" id="search-order" placeholder="Search">
                                    </div>
                                </div>

                                <div class="select-options filter-options">
                                    <select class="form-control" id="filter-order-dropdown">
                                        <option value="" selected>Filter Orders</option>
                                        <option value="">Filter Orders 1</option>
                                    </select>
                                </div>
                            </div>
                            <button type="button" name="clear" value="all" id="clear"
                                class="btn btn-site-theme clear-button order-filters-search">Create Order</button>

                        </div>
                    </div>

                    <div class="order-listing-container">
                        <div class="order-row">
                            @foreach($allOrders as $key => $ord)
                                <?php $userDetails = $ord->orderUserDetails; ?>
                            <div class="order-col" id="order-{{ $ord->id }}" data-id="{{ $ord->id }}">
                                <div class="order-box">
                                    <div class="timing">
                                        <h3>{{ date('H:i',strtotime(\Carbon\Carbon::parse($ord->created_at)->addMinutes(45))) }}</h3>
                                        <label class="success">{{ $ord->delivery_time }}</label>
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
                                            <p class="mb-0">{{ date('d-m-y H:i',strtotime($ord->created_at)) }}</p>
                                            <p class="mb-0">web #{{$ord->id}}</p>
                                        </div>
                                    </div>
{{--                                    @dump($ord->status)--}}
                                    <div class="actions">
                                        <h5 class="mb-0 price_status"><b>€{{ number_format($ord->total_amount, 2) }}</b>&nbsp;&nbsp;|&nbsp;&nbsp;Paid</h5>
                                        <button class="orderDetails btn {{orderStatusBox($ord)->color }}">{{ orderStatusBox($ord)->text }}</button>
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
                                <img src="{{ asset(path: 'images/bike-white.svg') }}"
                                    alt="Bike"  />
                            </button>

                            <button type="button" class="btn">
                            <img src="{{ asset(path: 'images/map-white.svg') }}"
                            alt="Bike"  />
                            </button>

                            <button type="button" class="btn">
                            <img src="{{ asset(path: 'images/setting-white.svg') }}"
                            alt="Bike"  />
                            </button>
                        </div>
                    </div>

                </div>
            </main>
        </div>
    </div>
    <!-- start footer -->
    @include('admin.orders.order-detail-popup')
    @include('layouts.admin.footer_design')
    @include('admin.modals.change-order-status')
    <!-- end footer -->
</div>
