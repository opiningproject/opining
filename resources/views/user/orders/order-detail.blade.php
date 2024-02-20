<?php

use App\Enums\OrderStatus;
use App\Enums\OrderType;
use App\Enums\PaymentStatus;
use App\Enums\PaymentType;
use App\Enums\RefundStatus;

?>
<input type="hidden" name="order_id" id="order_id" value="{{ $order->id }}">
<div class="ordersdetails-header d-flex justify-content-between align-items-center">
    <div class="ordersdetails-title">Order Details</div>
    <div class="btn-grp d-flex flex-wrap">
        @if($order->order_type == '1')
            <button onclick="location.href='{{ route('user.order-location',['order_id' => $order->id]) }}'">
                <img src="{{ asset('images/trackorder-icon.svg') }}" class="img-fluid svg" alt="" width="35"
                     height="32">
                Track order
            </button>
        @endif
        <button onclick="location.href='{{ route('user.chat') }}'">
            <img src="{{ asset('images/needhelp-icon.svg') }}" class="img-fluid svg" alt="" width="27" height="25">Need
            help
        </button>
    </div>
</div>

<div class="orderdetails-main">
    <div class="orderdetails-maintop d-flex justify-content-between gap-2 gap-sm-3 flex-wrap align-items-center">
        <div class="textgrp d-flex flex-column gap-1 gap-sm-3">
            <div class="title">Order #{{ $order->id }}</div>
            <div class="text">{{ $order->created_at }}</div>
        </div>
        <button class="border-none outline-none">
            @if($order->order_status == OrderStatus::Accepted)
                <img src="{{ asset('images/order-accepted.svg') }}" class="img-fluid svg" alt="" width="20" height="20">
                Order Accepted
            @elseif($order->order_status == OrderStatus::InKitchen)
                <img src="{{ asset('images/orderinkitchen-icon.svg') }}" class="img-fluid svg" alt="" width="26"
                     height="20">Order in a kitchen
            @elseif($order->order_status == OrderStatus::Ready)
                <img src="{{ asset('images/readytopickup-icon.svg') }}" class="img-fluid svg" alt="" width="16"
                     height="20">Ready for delivery
            @elseif($order->order_status == OrderStatus::ReadyForPickup)
                <img src="{{ asset('images/readytopickup-icon.svg') }}" class="img-fluid svg" alt="" width="16"
                     height="20">Ready for pickup
            @elseif($order->order_status == OrderStatus::OutForDelivery)
                <img src="{{ asset('images/outfordelivery-icon.svg') }}" class="img-fluid svg" alt="" width="31"
                     height="20">Out For Delivery
            @else
                <img src="{{ asset('images/delivered-icon.svg') }}" class="img-fluid svg" alt="" width="21" height="20">
                Order delivered
            @endif
        </button>
    </div>
    <div class="orderdetails-address d-flex justify-content-between flex-wrap gap-3">
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
                    <img src="{{ asset('images/location-yellowicon.svg') }}" class="img-fluid svg" alt="" width="12"
                         height="16">
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
                    <img src="{{ asset('images/house-icon.svg') }}" class="img-fluid svg" alt="" width="18"
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
            <div class="orderdetails-desc">
                <div class="orderdetails-desc-main">
                    <div class="orderdetails-desc-count">
                        x{{ $dish->qty }}
                    </div>
                    <div class="orderdetails-desc-card">
                        <img src="{{ $dish->dish->image }}" class="img-fluid" alt="" width="85">
                        <div class="text-grp">
                            <div class="title">{{ $dish->dish->name }}</div>
                            <div class="text line-clamp-2" id="order-ingredient-{{ $dish->id}}">
                                <b class="mb-0 item-options"> {{ $dish->dishOption->name ?? ''}} </b>
                                - {{ getOrderDishIngredients($dish) }}
                            </div>
                            <div class="text">
                                <a href="javascript:void(0)" id="read-more-{{ $dish->id}}"
                                   onclick="readMore({{ $dish->id}})">Read More</a>
                                <a href="javascript:void(0)" style="display:none;" id="close-{{ $dish->id}}"
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
                        $itemTotalPrice += $itemPrice;
                        ?>
                    €{{ $itemPrice }}
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
            <div class="list-item">
                <div class="text">{{ $order->delivery_charge ? 'Delivery Charge':'Free Delivery' }}</div>
                <div class="number">€{{ $order->delivery_charge }}</div>
            </div>
            <div class="list-item active">
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
            <img src="{{ asset('images/download-icon.svg') }}" class="img-fluid svg" alt="" width="14" height="14">
            <div class="text-truncate">
                Download invoice
            </div>
        </a>
        @if($order->payment_status == PaymentStatus::Success  && $order->order_status == OrderStatus::Delivered)
            @if($order->refund_status == null)
                <a href="javascript:void(0);" class="customize-foodlink button active" data-bs-toggle="modal"
                   data-bs-target="#refundModal" id="refund-req-btn">
                    <img src="{{ asset('images/refund-icon.svg') }}" class="img-fluid svg" alt="" width="18"
                         height="18">
                    <div class="text-truncate" id="refund-status-lable">
                        Refund request
                    </div>
                </a>
            @else
                <a href="javascript:void(0);" class="customize-foodlink button" style="pointer-events: none">
                    <img src="{{ asset('images/refund-icon.svg') }}" class="img-fluid svg" alt="" width="18"
                         height="18">
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
