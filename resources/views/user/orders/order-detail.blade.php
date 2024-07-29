<?php

use App\Enums\OrderStatus;
use App\Enums\OrderType;
use App\Enums\PaymentStatus;
use App\Enums\PaymentType;
use App\Enums\RefundStatus;

?>


<div class="mobile-order-page d-none">
    <div class="mobile-head-belt">
        <button type="button" class="btn-close bg-arrow-mobile">
            <i class="fa-solid fa-angle-left d-none"></i>
        </button>

        <h1>Order #53</h1>
    </div>

    <div class="order-details-block">
        <div class="accordion order-details-accordion" id="accordionExample">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Order Details
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                    data-bs-parent="#accordionExample">
                    <div class="accordion-body order-detail-body">
                        <table class="table mb-0">
                            <tbody>
                                <tr>
                                    <td>Order ID</td>
                                    <td class="text-end">#53</td>
                                </tr>
                                <tr>
                                    <td>Order Time</td>
                                    <td class="text-end">June 1, 2020, 08:22</td>
                                </tr>
                                <tr>
                                    <td>Order for</td>
                                    <td class="text-end">Delivery</td>
                                </tr>
                                <tr>
                                    <td>Payment</td>
                                    <td class="text-end">Completed</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        Shipping Adress
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                    data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <div class="cart-address-row d-flex gap-2 w-100">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 23 32" fill="none"
                                class="svg inlined-svg" height="20" width="20" role="img"
                                aria-labelledby="_edjx9teli">
                                <title id="_edjx9teli"></title>
                                <mask id="path-1-inside-1_2446_6934" fill="white">
                                    <path
                                        d="M11.5196 0C17.302 0.0399707 22.2227 4.60787 22.9177 10.5348C23.2665 13.5126 22.4671 16.2081 21.2627 18.8225C19.5298 22.5822 17.127 25.8661 14.4821 28.9675C13.6744 29.9156 12.8079 30.8087 11.9738 31.733C11.6682 32.0715 11.3902 32.099 11.0618 31.753C7.39106 27.8983 4.08463 23.7576 1.76689 18.8474C0.691909 16.5716 -0.0391248 14.2021 0.00162135 11.619C0.0938994 5.91067 4.57957 0.768187 10.0336 0.152388C10.5285 0.0961796 11.0247 0.0512125 11.5196 0ZM11.4932 17.5247C14.3766 17.5359 16.7735 15.0677 16.783 12.0749C16.7926 9.02089 14.4353 6.53521 11.5244 6.53022C8.63262 6.52522 6.24896 8.98092 6.23458 11.98C6.2202 15.0277 8.57629 17.5122 11.4944 17.5247H11.4932Z">
                                    </path>
                                </mask>
                                <path
                                    d="M11.5196 0C17.302 0.0399707 22.2227 4.60787 22.9177 10.5348C23.2665 13.5126 22.4671 16.2081 21.2627 18.8225C19.5298 22.5822 17.127 25.8661 14.4821 28.9675C13.6744 29.9156 12.8079 30.8087 11.9738 31.733C11.6682 32.0715 11.3902 32.099 11.0618 31.753C7.39106 27.8983 4.08463 23.7576 1.76689 18.8474C0.691909 16.5716 -0.0391248 14.2021 0.00162135 11.619C0.0938994 5.91067 4.57957 0.768187 10.0336 0.152388C10.5285 0.0961796 11.0247 0.0512125 11.5196 0ZM11.4932 17.5247C14.3766 17.5359 16.7735 15.0677 16.783 12.0749C16.7926 9.02089 14.4353 6.53521 11.5244 6.53022C8.63262 6.52522 6.24896 8.98092 6.23458 11.98C6.2202 15.0277 8.57629 17.5122 11.4944 17.5247H11.4932Z"
                                    stroke="#FFC00B" stroke-width="4" mask="url(#path-1-inside-1_2446_6934)"></path>
                            </svg>
                            <h4 class="mb-0">Molenstraat 16, 2513 BK Den Haag, Netherlands</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="order-wise-details bg-theme-box">
            <div class="items">
                <h3 class="mb-0">Order #53</h3>
            </div>
            <div class="items">
                <div class="order-items">
                    <div class="details-row">
                        <div class="left-details">
                            <div class="number">1</div>
                            <div class="details">
                                <h4>Pizza Margherita</h4>
                                <ul>
                                    <li>+ Onion (€1,50)</li>
                                    <li>- Peppers (€2,00)</li>
                                </ul>
                            </div>
                        </div>

                        <div class="right-details text-end">
                            <h5 class="mb-0">€ 23,50</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="items">
                <div class="order-items">
                    <div class="details-row">
                        <div class="left-details">
                            <div class="number">2</div>
                            <div class="details">
                                <h4>Coca Cola</h4>
                            </div>
                        </div>

                        <div class="right-details text-end">
                            <h5 class="mb-0">€ 9,00</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="items">
                <div class="order-items">
                    <div class="details-row">
                        <div class="left-details">
                            <div class="number">1</div>
                            <div class="details">
                                <h4>Pizza Peperoni</h4>
                            </div>
                        </div>

                        <div class="right-details text-end">
                            <h5 class="mb-0">€ 23,00</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="items">
                <table class="table total-price-table mb-0">
                    <tbody>
                        <tr>
                            <td>Subtotal</td>
                            <td class="text-end">€ 52,00</td>
                        </tr>
                        <tr>
                            <td>Service Charges</td>
                            <td class="text-end text-green">FREE</td>
                        </tr>
                        <tr>
                            <td>Delivery</td>
                            <td class="text-end text-green">FREE</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="items">
                <div class="order-items order-items-total">
                    <div class="details-row">
                        <div class="left-details">
                            <div class="details">
                                <h4>Total</h4>
                            </div>
                        </div>

                        <div class="right-details text-end">
                            <h5 class="mb-0">€ 52,00</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="accordion order-details-accordion order-payment-accordion" id="accordionPayment">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Payment Details
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                    data-bs-parent="#accordionPayment">
                    <div class="accordion-body order-detail-body">
                        <table class="table mb-0">
                            <tbody>
                                <tr>
                                    <td>Payment Status</td>
                                    <td class="text-end">Payment Done</td>
                                </tr>
                                <tr>
                                    <td>Payment type</td>
                                    <td class="text-end">IDEAL</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="accordion order-details-accordion order-details-options" id="accordionOrderOptions">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                        Download Invoice
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne"
                    data-bs-parent="#accordionOrderOptions">
                    <div class="accordion-body">
                        <button class="btn-acc">Download</button>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        Points Received
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                    data-bs-parent="#accordionOrderOptions">
                    <div class="accordion-body">
                        <h3>You received 1 point for this order</h3>
                        <button class="btn-acc">See Points</button>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        Need Help
                    </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree"
                    data-bs-parent="#accordionOrderOptions">
                    <div class="accordion-body">
                        <h3>Call us</h3>
                        <a href="#" class="btn-acc">010-41235898</a>
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingFour">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                        Cancel Order
                    </button>
                </h2>
                <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
                    data-bs-parent="#accordionOrderOptions">
                    <div class="accordion-body">
                        <p class="mb-0">
                            Once the order is in Kitchen, it is not possible to cancel order anymore. If you want to
                            cancel order what is not prepared yet, you can take contact and we help you further
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="d-none">
    <h3 class="text-center fs-5 mb-4 d-block d-md-none">{{ trans('user.my_orders.my_order') }}</h3>
    <button type="button"
        class="btn-close d-block d-md-none order-detail-close-btn position-absolute top-0 end-0 p-3"></button>
    <input type="hidden" name="order_id" id="order_id" value="{{ $order->id }}">
    <div class="ordersdetails-header d-flex justify-content-between align-items-center">
        <div class="ordersdetails-title me-auto">{{ trans('user.my_orders.order_details') }}</div>
        <div class="btn-grp d-flex flex-wrap">
            @if ($order->order_type == '1')
                <button onclick="location.href='{{ route('user.order-location', ['order_id' => $order->id]) }}'">
                    <img src="{{ asset('images/trackorder-icon.svg') }}" class="img-fluid svg" alt=""
                        width="35" height="32">
                    {{ trans('user.my_orders.track_order') }}
                </button>
            @endif
            <button onclick="location.href='{{ route('user.chat') }}'">
                <img src="{{ asset('images/needhelp-icon.svg') }}" class="img-fluid svg" alt=""
                    width="27" height="25">{{ trans('user.my_orders.need_help') }}
            </button>
        </div>
    </div>

    <div class="orderdetails-main px-0 px-md-3">
        <div class="orderdetails-maintop d-flex justify-content-between gap-2 gap-sm-3 flex-wrap align-items-center">
            <div class="textgrp d-flex flex-column gap-1 gap-sm-3">
                <div class="title">{{ trans('user.my_orders.order') }} #{{ $order->id }}</div>
                <div class="text">{{ $order->created_at }}</div>
            </div>
            <button class="border-none outline-none">
                @if ($order->order_status == OrderStatus::Accepted)
                    <img src="{{ asset('images/order-accepted.svg') }}" class="img-fluid svg" alt=""
                        width="20" height="20">
                    {{ trans('user.order_status.accepted') }}
                @elseif($order->order_status == OrderStatus::InKitchen)
                    <img src="{{ asset('images/orderinkitchen-icon.svg') }}" class="img-fluid svg" alt=""
                        width="26" height="20">
                    {{ trans('user.order_status.in_kitchen') }}
                @elseif($order->order_status == OrderStatus::Ready)
                    <img src="{{ asset('images/readytopickup-icon.svg') }}" class="img-fluid svg" alt=""
                        width="16" height="20">
                    {{ trans('user.order_status.ready') }}
                @elseif($order->order_status == OrderStatus::ReadyForPickup)
                    <img src="{{ asset('images/readytopickup-icon.svg') }}" class="img-fluid svg" alt=""
                        width="16" height="20">
                    {{ trans('user.order_status.ready_for_pickup') }}
                @elseif($order->order_status == OrderStatus::OutForDelivery)
                    <img src="{{ asset('images/outfordelivery-icon.svg') }}" class="img-fluid svg" alt=""
                        width="31" height="20">
                    {{ trans('user.order_status.out_for_delivery') }}
                @else
                    <img src="{{ asset('images/delivered-icon.svg') }}" class="img-fluid svg" alt=""
                        width="21" height="20">
                    {{ trans('user.order_status.delivered') }}
                @endif
            </button>
        </div>
        <div class="orderdetails-address d-flex justify-content-between flex-wrap gap-3">
            <div class="textgrp">
                <div class="title">{{ trans('user.my_orders.order_for') }}</div>
                <div class="text">
                    {{ $order->order_type == OrderType::Delivery ? trans('user.my_orders.delivery') : trans('user.my_orders.pickup') }}
                </div>
            </div>

            @if ($order->order_type == OrderType::Delivery)
                <div class="textgrp">
                    <div class="title">{{ trans('user.my_orders.delivery_address') }}</div>
                    <div class="text">
                        <img src="{{ asset('images/location-yellowicon.svg') }}" class="img-fluid svg"
                            alt="" width="12" height="16">
                        <?php
                        $address = $order->orderUserDetails;
                        
                        echo $address->house_no . ', ' . $address->street_name . ', ' . $address->city . ', ' . $address->zipcode;
                        ?>
                    </div>
                </div>
            @else
                <div class="textgrp">
                    <div class="title">{{ trans('user.my_orders.restaurant_address') }}</div>
                    <div class="text">
                        <img src="{{ asset('images/house-icon.svg') }}" class="img-fluid svg me-2" alt=""
                            width="18" height="18">{{ getRestaurantDetail()->rest_address }}
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
                        <div class="orderdetails-desc-card orderdetails-flex-400">
                            <div class="text-grp ps-3">
                                <div class="title">{{ $dish->dish->name }}</div>
                                <div class="text line-clamp-2" id="order-ingredient-{{ $dish->id }}">
                                    <b class="mb-0 item-options"> {{ $dish->dishOption->name ?? '' }} </b>
                                    {{ getOrderDishIngredients($dish) }}
                                </div>
                                @if (count($dish->orderDishPaidIngredients) > 3)
                                    <div class="text {{ getOrderDishIngredients($dish) == '' ? 'd-none' : '' }}">
                                        <a href="javascript:void(0)" id="read-more-{{ $dish->id }}"
                                            onclick="readMore({{ $dish->id }})">{{ trans('user.my_orders.read_more') }}</a>
                                        <a href="javascript:void(0)" style="display:none;"
                                            id="close-{{ $dish->id }}"
                                            onclick="hideReadMore({{ $dish->id }})">{{ trans('user.my_orders.close') }}</a>
                                    </div>
                                @endif
                                @if (!empty($dish->notes))
                                    <div class="notes mt-2">
                                        <u>{{ $dish->notes }}</u>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    {{-- @if (!empty($dish->notes))
                    <div class="orderdetails-desc-note ms-auto">
                        <Label>{{ trans('user.my_orders.notes') }}</Label>
                        <input type="text" placeholder="{{ $dish->notes }}" readonly data-toggle="tooltip"
                               title="{{ $dish->notes }}">
                    </div>
                @endif --}}
                    <div class="orderdetails-desc-price">
                        <?php
                        
                        $itemPrice = $dish->price * $dish->qty + $dish->paid_ingredient_total;
                        $itemTotalPrice += $itemPrice;
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
                    <div class="number">€{{ number_format(getOrderGrossAmount($order), 2) }}</div>
                </div>
                <div class="list-item">
                    <div class="text">{{ trans('user.my_orders.service_charge') }}</div>
                    <div class="number">€{{ number_format($order->platform_charge, 2) }}</div>
                </div>
                <div class="list-item" {{ $order->order_type == '2' ? 'style=display:none' : '' }}>
                    <div class="text">{{ $order->delivery_charge ? 'Delivery Charge' : 'Free Delivery' }}</div>
                    <div class="number">€{{ number_format($order->delivery_charge, 2) }}</div>
                </div>
                <div class="list-item active" {{ isset($order->coupon) ? '' : 'style=display:none' }}>
                    <div class="text">{{ trans('user.my_orders.item_discount') }}</div>
                    <div class="number">-€{{ number_format($order->coupon_discount, 2) }}</div>
                </div>
            </div>
        </div>
        <div class="orderdetails-total">
            <div class="list">
                <div class="list-item">
                    <div class="text">{{ trans('user.my_orders.total') }}</div>
                    <div class="number">€{{ number_format((float) $order->total_amount, 2) }}</div>
                </div>
            </div>
        </div>
    </div>
    <div class="orderdetails-footer">
        <div class="btn-grp d-flex flex-wrap">
            <a href="{{ route('user.orders.printLabel', ['order_id' => $order->id]) }}" target="_blank"
                class="customize-foodlink button active">
                <img src="{{ asset('images/download-icon.svg') }}" class="img-fluid svg" alt=""
                    width="14" height="14">
                <div class="text-truncate">
                    {{ trans('user.my_orders.download_invoice') }}
                </div>
            </a>
            @if ($order->payment_status == PaymentStatus::Success && $order->order_status == OrderStatus::Delivered)
                @if ($order->refund_status == null)
                    <a href="javascript:void(0);" class="customize-foodlink button active" data-bs-toggle="modal"
                        data-bs-target="#refundModal" id="refund-req-btn">
                        <img src="{{ asset('images/refund-icon.svg') }}" class="img-fluid svg" alt=""
                            width="18" height="18">
                        <div class="text-truncate" id="refund-status-lable">
                            {{ trans('user.refund_req.request') }}
                        </div>
                    </a>
                @else
                    <a href="javascript:void(0);" class="customize-foodlink button" style="pointer-events: none">
                        <img src="{{ asset('images/refund-icon.svg') }}" class="img-fluid svg" alt=""
                            width="18" height="18">
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
