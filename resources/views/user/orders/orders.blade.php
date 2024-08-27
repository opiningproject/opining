@extends('layouts.user-app')
@section('content')
    <?php

    use App\Enums\OrderStatus;
    use App\Enums\OrderType;
    use App\Enums\PaymentStatus;
    use App\Enums\PaymentType;
    use App\Enums\RefundStatus;

    ?>

    <div class="overlay-custom"></div>
    <div class="main">
        <div class="main-view">
            <div class="container-fluid bd-gutter bd-layout">
                @include('layouts.user.side_nav_bar')
                <main class="bd-main order-1">
                    <div class="main-content">
                        @php
                            $isNew = request()->query('order');
                        @endphp
                        @if($isNew == 'is_new')
                            @include('user.orders.accept-order')
                        @endif

                        <div class="position-relative order-position-relative">
                            <div
                                class="section-page-title main-page-title row justify-content-between d-sm-block title-mobile">
                                <div class="col-xxl-6 col-xl-6 col-lg-5 col-md-6 col-sm-6 col-12">
                                    <h1 class="page-title">{{ trans('user.my_orders.title') }}</h1>
                                </div>
                            </div>
                            <div class="d-flex orders-main order-non-active">
                                <div class="orders d-flex order-mobile">
                                    <div class="orders-type">
                                        <div class="orders-title mb-1">{{ trans('user.my_orders.active_orders') }}</div>
                                        @if (count($active_orders))
                                            <div class="orders-list py-3 px-0 pb-0">
                                                @foreach ($active_orders as $key => $a_order)
                                                    <div onclick="orderDetail({{ $a_order->id }})" style="cursor: pointer;"
                                                        class="{{ $a_order->id == $order->id ? 'active' : '' }} orders-item d-flex align-items-center justify-content-between gap-2"
                                                        id="order-{{ $a_order->id }}">
                                                        <div class="text-grp">
                                                            <div class="title">{{ trans('user.my_orders.order') }}
                                                                #{{ $a_order->id }}</div>
                                                            <div class="text">{{ $a_order->created_at }}</div>
                                                        </div>
                                                        <div class="price">
                                                            <span>€</span>{{ number_format($a_order->total_amount, 2) }}
                                                        </div>
                                                        <button class="border-none outline-none arrow-with-bg">
                                                            <img src="{{ asset('images/chevron-down.svg') }}"
                                                                class="img-fluid svg" alt="" width="32"
                                                                height="32">
                                                        </button>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <span class="no-data">{{ trans('user.my_orders.no_orders') }}</span>
                                        @endif
                                    </div>

                                    @if (count($orders))
                                        <div class="orders-type">
                                            <div class="orders-title mb-1">{{ trans('user.my_orders.overview') }}</div>
                                            <span class="lastPage" style="display: none"> {{ $lastPage }}</span>
                                            <div class="orders-list overview-orders py-3 px-1">
                                                @foreach ($orders as $key => $ord)
                                                    <div onclick="orderDetail({{ $ord->id }})"
                                                        style="cursor: pointer;"
                                                        class="{{ $ord->id == $order->id ? 'active' : '' }} orders-item d-flex align-items-center justify-content-between gap-2"
                                                        id="order-{{ $ord->id }}">
                                                        <div class="text-grp">
                                                            <div class="title">{{ trans('user.my_orders.order') }}
                                                                #{{ $ord->id }}</div>
                                                            <div class="text">{{ $ord->created_at }}</div>
                                                        </div>
                                                        <div class="price">
                                                            <span>€</span>{{ number_format($ord->total_amount, 2) }}</div>
                                                        <button class="border-none outline-none arrow-with-bg">
                                                            <img src="{{ asset('images/chevron-down.svg') }}"
                                                                class="img-fluid svg" alt="" width="32"
                                                                height="32">
                                                        </button>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                </div>
                                @if (!empty($order))
                                    <div
                                        class="ordersdetails ordersdetails_sidebar mobile_ordersdetails ordersdetails_sidebar gap-0">
                                        <input type="hidden" name="order_id" id="order_id" value="{{ $order->id }}">
                                        <!-- with two button -->
                                        <div
                                            class="ordersdetails-header d-flex justify-content-between align-items-center mb-3">
                                            <button type="button"
                                                class="btn-close d-block d-md-none order-detail-close-btn">
                                            </button>
                                            <div class="ordersdetails-title me-auto">
                                                {{ trans('user.my_orders.order_details') }}</div>
                                            <div class="btn-grp d-flex flex-wrap">
                                                @if ($order->order_type == '1')
                                                    {{-- old code comment on 13-aug-2024 --}}
{{--                                                    <button--}}
{{--                                                        onclick="location.href='{{ route('user.order-location', ['order_id' => $order->id]) }}'">--}}
{{--                                                        <img src="{{ asset('images/trackorder-icon.svg') }}"--}}
{{--                                                            class="img-fluid svg" alt="" width="35"--}}
{{--                                                            height="32">--}}
{{--                                                        {{ trans('user.my_orders.track_order') }}--}}
{{--                                                    </button>--}}
                                                    <button
                                                        onclick="location.href='{{ route('user.order-location-new', ['order_id' => $order->id]) }}'">
                                                        <img src="{{ asset('images/trackorder-icon.svg') }}"
                                                            class="img-fluid svg" alt="" width="35"
                                                            height="32">
                                                        {{ trans('user.my_orders.track_order') }}
                                                    </button>
                                                @endif
                                                <button onclick="location.href='{{ route('user.chat') }}'">
                                                    <img src="{{ asset('images/needhelp-icon.svg') }}"
                                                        class="img-fluid svg" alt="" width="27" height="25">
                                                    {{ trans('user.my_orders.need_help') }}
                                                </button>
                                            </div>
                                        </div>

                                        <div class="orderdetails-main px-0 px-md-3 mb-3">
                                            <div
                                                class="orderdetails-maintop d-flex justify-content-between gap-2 gap-sm-3 flex-wrap align-items-center">
                                                <div class="textgrp d-flex flex-column gap-1 gap-sm-3">
                                                    <div class="title">{{ trans('user.my_orders.order') }}
                                                        #{{ $order->id }}</div>
                                                    <div class="text">{{ $order->created_at }}</div>
                                                </div>
                                                <button class="border-none outline-none">
                                                    @if ($order->order_status == OrderStatus::Accepted)
                                                        <img src="{{ asset('images/order-accepted.svg') }}"
                                                            class="img-fluid svg" alt="" width="20"
                                                            height="20">
                                                        {{ trans('user.order_status.accepted') }}
                                                    @elseif($order->order_status == OrderStatus::InKitchen)
                                                        <img src="{{ asset('images/orderinkitchen-icon.svg') }}"
                                                            class="img-fluid svg" alt="" width="26"
                                                            height="20">
                                                        {{ trans('user.order_status.in_kitchen') }}
                                                    @elseif($order->order_status == OrderStatus::Ready)
                                                        <img src="{{ asset('images/readytopickup-icon.svg') }}"
                                                            class="img-fluid svg" alt="" width="16"
                                                            height="20">
                                                        {{ trans('user.order_status.ready') }}
                                                    @elseif($order->order_status == OrderStatus::ReadyForPickup)
                                                        <img src="{{ asset('images/readytopickup-icon.svg') }}"
                                                            class="img-fluid svg" alt="" width="16"
                                                            height="20">
                                                        {{ trans('user.order_status.ready_for_pickup') }}
                                                    @elseif($order->order_status == OrderStatus::OutForDelivery)
                                                        <img src="{{ asset('images/outfordelivery-icon.svg') }}"
                                                            class="img-fluid svg" alt="" width="31"
                                                            height="20">
                                                        {{ trans('user.order_status.out_for_delivery') }}
                                                    @else
                                                        <img src="{{ asset('images/delivered-icon.svg') }}"
                                                            class="img-fluid svg" alt="" width="21"
                                                            height="20">
                                                        {{ trans('user.order_status.delivered') }}
                                                    @endif
                                                </button>
                                            </div>
                                            <div
                                                class="orderdetails-address d-flex justify-content-between flex-wrap gap-3">
                                                <div class="textgrp">
                                                    <div class="title">{{ trans('user.my_orders.order_for') }}</div>
                                                    <div class="text">
                                                        {{ $order->order_type == OrderType::Delivery ? trans('user.my_orders.delivery') : trans('user.my_orders.pickup') }}
                                                    </div>
                                                </div>

                                                @if ($order->order_type == OrderType::Delivery)
                                                    <div class="textgrp">
                                                        <div class="title">{{ trans('user.my_orders.delivery_address') }}
                                                        </div>
                                                        <div class="text">
                                                            <img src="{{ asset('images/location-yellowicon.svg') }}"
                                                                class="img-fluid svg me-2" alt="" width="12"
                                                                height="16">
                                                            <?php
                                                            $address = $order->orderUserDetails;

                                                            echo $address->house_no . ', ' . $address->street_name . ', ' . $address->city . ', ' . $address->zipcode;
                                                            ?>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="textgrp">
                                                        <div class="title">
                                                            {{ trans('user.my_orders.restaurant_address') }}</div>
                                                        <div class="text">
                                                            <img src="{{ asset('images/house-icon.svg') }}"
                                                                class="img-fluid svg me-2" alt="" width="18"
                                                                height="18">
                                                            {{ getRestaurantDetail()->rest_address }}
                                                        </div>
                                                    </div>
                                                @endif

                                                <div class="textgrp">
                                                    <div class="title">{{ trans('user.my_orders.payment') }}</div>
                                                    <div class="text">
                                                        {{ $order->payment_type == PaymentType::Card ? trans('user.my_orders.card') : ($order->payment_type == PaymentType::Cash ? trans('user.my_orders.cash') : 'Ideal') }}
                                                    </div>
                                                </div>
                                                <div class="textgrp">
                                                    <div class="title">{{ trans('user.my_orders.payment_status') }}</div>
                                                    <div class="text">
                                                        {{ $order->payment_status == PaymentStatus::Pending ? trans('user.my_orders.pending') : ($order->payment_status == PaymentStatus::Success ? trans('user.my_orders.success') : trans('user.my_orders.fail')) }}
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="orderdetails-desclist">
                                                <?php $itemTotalPrice = 0; ?>
                                                @foreach ($order->dishDetails as $key => $dish)
                                                    <div class="orderdetails-desc custom-orderdetails-desc">
                                                        <div class="orderdetails-desc-main orderdetails-desc-320">
                                                            <div class="orderdetails-desc-count">
                                                                x{{ $dish->qty }}
                                                            </div>
                                                            <div class="orderdetails-desc-card orderdetails-flex-200">
                                                                <div class="text-grp ps-3">
                                                                    <div class="title">{{ $dish->dish->name }}</div>
                                                                    <div class="text"
                                                                        id="order-ingredient-{{ $dish->id }}">
                                                                        {{-- remove line-clamp-2 class --}}
{{--                                                                        <b class="mb-0 item-options">--}}
{{--                                                                            {{ $dish->dishOption->name ?? '' }} </b>--}}
{{--                                                                        {{ getOrderDishIngredients($dish) }}--}}
                                                                        @if(count($dish->orderDishOptionDetails) > 0)
                                                                            <b class="mb-0 item-options"> {{ getDishOptionCategoryName($dish->orderDishOptionDetails->pluck('dish_option_id')) ?? '' }} </b>
                                                                            <br>
                                                                        @endif
                                                                        {{ getOrderDishIngredients($dish) }}
                                                                    </div>
                                                                    {{--<div
                                                                        class="text {{ getOrderDishIngredients($dish) == '' ? 'd-none' : '' }}">
                                                                        <a href="javascript:void(0)"
                                                                            id="read-more-{{ $dish->id }}"
                                                                            onclick="readMore({{ $dish->id }})">
                                                                            {{ trans('user.my_orders.read_more') }}
                                                                        </a>
                                                                        <a href="javascript:void(0)" style="display:none;"
                                                                            id="close-{{ $dish->id }}"
                                                                            onclick="hideReadMore({{ $dish->id }})">
                                                                            {{ trans('user.my_orders.close') }}
                                                                        </a>
                                                                    </div>--}}
                                                                </div>
                                                            </div>
                                                        </div>
                                                        @if (!empty($dish->notes))
                                                            <div class="orderdetails-desc-note">
                                                                <Label>{{ trans('user.my_orders.notes') }}</Label>
                                                                <input type="text" placeholder="{{ $dish->notes }}"
                                                                    readonly>
                                                            </div>
                                                        @endif
                                                        <div class="orderdetails-desc-price">
                                                            <?php
                                                            $itemPrice = $dish->price * $dish->qty + $dish->paid_ingredient_total;
                                                            ?>
                                                            €{{ number_format($itemPrice, 2) }}
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>

                                            <div class="orderdetails-bill">
                                                <div class="title">{{ trans('user.my_orders.bill_details') }}</div>
                                                <div class="list">
                                                    <div class="list-item">
                                                        <div class="text">{{ trans('user.my_orders.item_total') }}</div>
                                                        <div class="number">
                                                            €{{ number_format(getOrderGrossAmount($order), 2) }}</div>
                                                    </div>
                                                    <div class="list-item"
                                                        {{ $order->platform_charge > 0 ? '' : 'style=display:none' }}>
                                                        <div class="text">{{ trans('user.my_orders.service_charge') }}
                                                        </div>
                                                        <div class="number">
                                                            €{{ number_format($order->platform_charge, 2) }}</div>
                                                    </div>
                                                    <div class="list-item"
                                                        {{ $order->order_type == '2' ? 'style=display:none' : '' }}>
                                                        <div class="text">
                                                            {{ $order->delivery_charge ? 'Delivery Charge' : 'Free Delivery' }}
                                                        </div>
                                                        <div class="number">
                                                            €{{ number_format($order->delivery_charge, 2) }}</div>
                                                    </div>
                                                    <div class="list-item active"
                                                        {{ isset($order->coupon) ? '' : 'style=display:none' }}>
                                                        <div class="text">{{ trans('user.my_orders.item_discount') }}
                                                        </div>
                                                        <div class="number">
                                                            -€{{ number_format($order->coupon_discount, 2) }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="orderdetails-total">
                                                <div class="list">
                                                    <div class="list-item">
                                                        <div class="text">{{ trans('user.my_orders.total') }}</div>
                                                        <div class="number">€{{ $order->total_amount }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="orderdetails-footer">
                                            <div class="btn-grp d-flex flex-wrap">
                                                <a href="{{ route('user.orders.printLabel', ['order_id' => $order->id]) }}"
                                                    target="_blank" class="customize-foodlink button active">
                                                    <img src="{{ asset('images/download-icon.svg') }}"
                                                        class="img-fluid svg" alt="" width="14"
                                                        height="14">
                                                    <div class="text-truncate">
                                                        {{ trans('user.my_orders.download_invoice') }}
                                                    </div>
                                                </a>
                                                @if ($order->payment_status == PaymentStatus::Success && $order->order_status == OrderStatus::Delivered)
                                                    @if ($order->refund_status == null)
                                                        <a href="javascript:void(0);"
                                                            class="customize-foodlink button active"
                                                            data-bs-toggle="modal" data-bs-target="#refundModal"
                                                            id="refund-req-btn">
                                                            <img src="{{ asset('images/refund-icon.svg') }}"
                                                                class="img-fluid svg" alt="" width="18"
                                                                height="18">
                                                            <div class="text-truncate" id="refund-status-lable">
                                                                {{ trans('user.refund_req.request') }}
                                                            </div>
                                                        </a>
                                                    @else
                                                        <a href="javascript:void(0);" class="customize-foodlink button"
                                                            style="pointer-events: none">
                                                            <img src="{{ asset('images/refund-icon.svg') }}"
                                                                class="img-fluid svg" alt="" width="18"
                                                                height="18">
                                                            <div class="text-truncate" id="refund-status-lable">
                                                                @if ($order->refund_status == RefundStatus::Accepted)
                                                                    {{ trans('user.refund_req.accepted') }}
                                                                @elseif($order->refund_status == RefundStatus::Rejected)
                                                                    {{ trans('user.refund_req.rejected') }}
                                                                @else
                                                                    {{ trans('user.refund_req.submitted') }}
                                                                @endif
                                                            </div>
                                                        </a>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                    </div>
                </main>
            </div>
        </div>


    @if(!$isNew)
        @include('layouts.user.footer_design')
    @endif
        <!-- start footer -->

        <!-- end footer -->

    </div>
    @include('user.modals.refund')
@endsection
