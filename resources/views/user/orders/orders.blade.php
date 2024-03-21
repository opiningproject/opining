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
                        <div class="section-page-title main-page-title row justify-content-between d-sm-block">
                            <div class="col-xxl-6 col-xl-6 col-lg-5 col-md-6 col-sm-6 col-12">
                                <h1 class="page-title">My Orders</h1>
                            </div>
                        </div>
                        <div class="d-flex orders-main order-non-active">
                            <div class="orders d-flex">
                                <div class=" orders-type">
                                    <div class="orders-title mb-1">Active orders</div>
                                    @if(count($active_orders))
                                        <div class="orders-list py-3 px-0 pb-0">
                                            @foreach($active_orders as $key => $a_order)
                                                <div onclick="orderDetail({{ $a_order->id }})" style="cursor: pointer;"
                                                    class="{{ $a_order->id == $order->id ? 'active':'' }} orders-item d-flex align-items-center justify-content-between gap-2"
                                                    id="order-{{ $a_order->id }}">
                                                    <div class="text-grp">
                                                        <div class="title">Order #{{ $a_order->id }}</div>
                                                        <div class="text">{{ $a_order->created_at }}</div>
                                                    </div>
                                                    <div class="price"><span>€</span>{{ $a_order->total_amount}}</div>
                                                    <button class="border-none outline-none arrow-with-bg">
                                                        <img src="{{ asset('images/chevron-down.svg') }}"
                                                             class="img-fluid svg" alt="" width="32" height="32">
                                                    </button>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="no-data">No orders</span>
                                    @endif
                                </div>

                                @if(count($orders))
                                    <div class="orders-type">
                                        <div class="orders-title mb-1">Orders overview</div>
                                        <div class="orders-list py-3 px-1">
                                            @foreach($orders as $key => $ord)
                                                <div  onclick="orderDetail({{ $ord->id }})" style="cursor: pointer;"
                                                    class="{{ $ord->id == $order->id ? 'active':'' }} orders-item d-flex align-items-center justify-content-between gap-2"
                                                    id="order-{{ $ord->id }}">
                                                    <div class="text-grp">
                                                        <div class="title">Order #{{ $ord->id }}</div>
                                                        <div class="text">{{ $ord->created_at }}</div>
                                                    </div>
                                                    <div class="price"><span>€</span>{{ $ord->total_amount}}</div>
                                                    <button class="border-none outline-none  arrow-with-bg">
                                                        <img src="{{ asset('images/chevron-down.svg') }}"
                                                             class="img-fluid svg" alt="" width="32" height="32">
                                                    </button>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                            </div>
                            @if(!empty($order))
                                <div class="ordersdetails ordersdetails_sidebar mobile_ordersdetails ordersdetails_sidebar">
                                    <input type="hidden" name="order_id" id="order_id" value="{{ $order->id }}">
                                    <!-- with two button -->
                                    <div class="ordersdetails-header d-flex justify-content-between align-items-center">
                                        <button type="button" class="btn-close d-block d-md-none order-detail-close-btn">
                                        </button>
                                        <div class="ordersdetails-title me-auto">Order Details</div>
                                        <div class="btn-grp d-flex flex-wrap">
                                            @if($order->order_type == '1')
                                                <button
                                                    onclick="location.href='{{ route('user.order-location',['order_id' => $order->id]) }}'">
                                                    <img src="{{ asset('images/trackorder-icon.svg') }}"
                                                         class="img-fluid svg" alt="" width="35" height="32"> Track
                                                    order
                                                </button>
                                            @endif
{{--                                            Commenting as this is not of Milestone 2 feature--}}
                                            {{--<button onclick="location.href='{{ route('user.chat') }}'">
                                                <img src="{{ asset('images/needhelp-icon.svg') }}" class="img-fluid svg"
                                                     alt="" width="27" height="25">Need help
                                            </button>--}}
                                        </div>
                                    </div>

                                    <div class="orderdetails-main">
                                        <div
                                            class="orderdetails-maintop d-flex justify-content-between gap-2 gap-sm-3 flex-wrap align-items-center">
                                            <div class="textgrp d-flex flex-column gap-1 gap-sm-3">
                                                <div class="title">Order #{{ $order->id }}</div>
                                                <div class="text">{{ $order->created_at }}</div>
                                            </div>
                                            <button class="border-none outline-none">
                                                @if($order->order_status == OrderStatus::Accepted)
                                                    <img src="{{ asset('images/order-accepted.svg') }}"
                                                         class="img-fluid svg" alt="" width="20" height="20">Order
                                                    Accepted
                                                @elseif($order->order_status == OrderStatus::InKitchen)
                                                    <img src="{{ asset('images/orderinkitchen-icon.svg') }}"
                                                         class="img-fluid svg" alt="" width="26" height="20">Order in a
                                                    kitchen
                                                @elseif($order->order_status == OrderStatus::Ready)
                                                    <img src="{{ asset('images/readytopickup-icon.svg') }}"
                                                         class="img-fluid svg" alt="" width="16" height="20">Ready for
                                                    delivery
                                                @elseif($order->order_status == OrderStatus::ReadyForPickup)
                                                    <img src="{{ asset('images/readytopickup-icon.svg') }}"
                                                         class="img-fluid svg" alt="" width="16" height="20">Ready for
                                                    pickup
                                                @elseif($order->order_status == OrderStatus::OutForDelivery)
                                                    <img src="{{ asset('images/outfordelivery-icon.svg') }}"
                                                         class="img-fluid svg" alt="" width="31" height="20">Out For
                                                    Delivery
                                                @else
                                                    <img src="{{ asset('images/delivered-icon.svg') }}"
                                                         class="img-fluid svg" alt="" width="21" height="20">Order
                                                    delivered
                                                @endif
                                            </button>
                                        </div>
                                        <div
                                            class="orderdetails-address d-flex justify-content-between flex-wrap gap-3">
                                            <div class="textgrp">
                                                <div class="title">Order For</div>
                                                <div class="text">
                                                    {{ $order->order_type == OrderType::Delivery ? 'Delivery':'Pickup' }}
                                                </div>
                                            </div>

                                            @if($order->order_type == OrderType::Delivery)
                                                <div class="textgrp">
                                                    <div class="title">Delivery Address</div>
                                                    <div class="text">
                                                        <img src="{{ asset('images/location-yellowicon.svg') }}"
                                                             class="img-fluid svg me-2" alt="" width="12" height="16">
                                                            <?php
                                                            $address = $order->orderUserDetails;

                                                            echo $address->house_no . ', ' . $address->street_name . ', ' . $address->city . ', ' . $address->zipcode;
                                                            ?>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="textgrp">
                                                    <div class="title">Restaurant Address</div>
                                                    <div class="text">
                                                        <img src="{{ asset('images/house-icon.svg') }}"
                                                             class="img-fluid svg me-2" alt="" width="18"
                                                             height="18">{{ getRestaurantDetail()->rest_address }}
                                                    </div>
                                                </div>
                                            @endif

                                            <div class="textgrp">
                                                <div class="title">Payment</div>
                                                <div class="text">
                                                    {{ $order->payment_type == PaymentType::Card ? 'Card': ($order->payment_type == PaymentType::Cash ? 'Cash':'Ideal') }}
                                                </div>
                                            </div>
                                            <div class="textgrp">
                                                <div class="title">Payment Status</div>
                                                <div class="text">
                                                    {{ $order->payment_status == PaymentStatus::Pending ? 'Pending': ($order->payment_status == PaymentStatus::Success ? 'Success':'Fail') }}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="orderdetails-desclist">
                                                <?php $itemTotalPrice = 0; ?>
                                            @foreach($order->dishDetails as $key => $dish)
                                                <div class="orderdetails-desc custom-orderdetails-desc">
                                                    <div class="orderdetails-desc-main orderdetails-desc-320">
                                                        <div class="orderdetails-desc-count">
                                                            x{{ $dish->qty }}
                                                        </div>
                                                        <div class="orderdetails-desc-card orderdetails-flex-200">
                                                            <img src="{{ $dish->dish->image }}" class="img-fluid" alt=""
                                                                 width="85">
                                                            <div class="text-grp">
                                                                <div class="title">{{ $dish->dish->name }}</div>
                                                                <div class="text line-clamp-2"
                                                                     id="order-ingredient-{{ $dish->id}}">
                                                                    <b class="mb-0 item-options"> {{ $dish->dishOption->name ?? '' }} </b>
                                                                    + {{ getOrderDishIngredients($dish) }}
                                                                </div>
                                                                <div class="text {{ getOrderDishIngredients($dish) == '' ? 'd-none' : '' }}">
                                                                    <a href="javascript:void(0)"
                                                                       id="read-more-{{ $dish->id}}"
                                                                       onclick="readMore({{ $dish->id}})">Read More</a>
                                                                    <a href="javascript:void(0)" style="display:none;"
                                                                       id="close-{{ $dish->id}}"
                                                                       onclick="hideReadMore({{ $dish->id}})">Close</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="orderdetails-desc-note">
                                                        <Label>Notes</Label>
                                                        <input type="text" placeholder="{{ $dish->notes }}" readonly>
                                                    </div>
                                                    <div class="orderdetails-desc-price">
                                                            <?php

                                                            $itemPrice = ($dish->price * $dish->qty) + $dish->paid_ingredient_total;
                                                            ?>
                                                        €{{ number_format($itemPrice,2) }}
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="orderdetails-bill">
                                            <div class="title">Bill Details</div>
                                            <div class="list">
                                                <div class="list-item">
                                                    <div class="text">Item Total</div>
                                                    <div class="number">€{{ getOrderGrossAmount($order) }}</div>
                                                </div>
                                                <div class="list-item">
                                                    <div class="text">Service Charge</div>
                                                    <div class="number">€{{ $order->platform_charge }}</div>
                                                </div>
                                                <div class="list-item" {{ $order->order_type == '2' ? 'style=display:none' : '' }}>
                                                    <div
                                                        class="text">{{ $order->delivery_charge ? 'Delivery Charge':'Free Delivery' }}</div>
                                                    <div class="number">€{{ $order->delivery_charge }}</div>
                                                </div>
                                                <div
                                                    class="list-item active" {{ isset($order->coupon) ? '' : 'style=display:none' }}>
                                                    <div class="text">Item Discount</div>
                                                    <div class="number">-€{{ $order->coupon_discount }}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="orderdetails-total">
                                            <div class="list">
                                                <div class="list-item">
                                                    <div class="text">Total</div>
                                                    <div class="number">€{{ $order->total_amount }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="orderdetails-footer">
                                        <div class="btn-grp d-flex flex-wrap">
                                            <a href="{{ route('user.download-invoice',['order_id' => $order->id]) }}"
                                               class="customize-foodlink button active">
                                                <img src="{{ asset('images/download-icon.svg') }}" class="img-fluid svg"
                                                     alt="" width="14" height="14">
                                                <div class="text-truncate">
                                                    Download invoice
                                                </div>
                                            </a>
                                            @if($order->payment_status == PaymentStatus::Success && $order->order_status == OrderStatus::Delivered)
                                                @if($order->refund_status == null)
                                                    <a href="javascript:void(0);"
                                                       class="customize-foodlink button active" data-bs-toggle="modal"
                                                       data-bs-target="#refundModal" id="refund-req-btn">
                                                        <img src="{{ asset('images/refund-icon.svg') }}"
                                                             class="img-fluid svg" alt="" width="18" height="18">
                                                        <div class="text-truncate" id="refund-status-lable">
                                                            Refund request
                                                        </div>
                                                    </a>
                                                @else
                                                    <a href="javascript:void(0);" class="customize-foodlink button"
                                                       style="pointer-events: none">
                                                        <img src="{{ asset('images/refund-icon.svg') }}"
                                                             class="img-fluid svg" alt="" width="18" height="18">
                                                        <div class="text-truncate" id="refund-status-lable">
                                                            @if($order->refund_status == RefundStatus::Accepted)
                                                                Refund request accepted
                                                            @elseif($order->refund_status == RefundStatus::Rejected)
                                                                Refund request rejected
                                                            @else
                                                                Refund request submitted
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
                </main>
            </div>
        </div>

        <!-- start footer -->
        @include('layouts.user.footer_design')
        <!-- end footer -->
    </div>

    @include('user.modals.refund')

@endsection

