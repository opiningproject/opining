<?php

use App\Enums\OrderStatus;
use App\Enums\OrderType;
use App\Enums\PaymentStatus;
use App\Enums\PaymentType;

$userDetails = $order->orderUserDetails;

?>
<style>
    .text-green {
        color: var(--theme-success3) !important;
    }
</style>
<div class="footer-box-details-header d-flex align-items-center justify-content-between gap-lg-3 flex-wrap">
    <ul class="list-inline text-grp mb-0 p-0 d-flex align-items-center flex-fill">
        <li class="list-inline-item d-flex align-items-center">{{ trans('rest.food_order.order') }}
            #{{$order->id }}</li>
        <li class="list-inline-item d-flex align-items-center">{{ $order->created_at }}</li>
    </ul>
    <ul class="d-inline-flex flex-wrap gap-3 contact-list mb-0 p-0 justify-content-end">
        <li class="list-inline-item">
            <a href="#" class="d-flex align-items-center gap-2">
                <img src="{{ asset('images/user-yellow.svg') }}" alt="user" class="img-fluid svg" width="17"
                     height="18">
                {{ $userDetails->order_name }}
            </a>
        </li>
        <li class="list-inline-item">
            <a href="#" class="d-flex align-items-center gap-2">
                <img src="{{ asset('images/call-yellow.svg') }}" alt="call" class="img-fluid svg" width="19"
                     height="19">
                +31 {{ $userDetails->order_contact_number }}
            </a>
        </li>
    </ul>
</div>
<div class="footer-box-main">
    <div class="footer-box-main-orderdetails d-flex justify-content-between   ">
        <div class="footer-box-main-orderdetails-item d-flex align-items-start gap-2">
            <img src="{{ asset('images/location-icon.svg') }}" alt="" class="img-fluid svg" width="13" height="18"
                 style="margin-top: 1px;">
            <div class="text-grp ms-0">
                @if($order->order_type == OrderType::Delivery)
                    <div class="title mb-2">
                            <?php
                            echo $userDetails->house_no . ', ' . $userDetails->street_name . ', ' . $userDetails->city . ', ' . $userDetails->zipcode;
                            ?>
                    </div>
                @else
                    <div class="title mb-2">
                        {{ getRestaurantDetail()->rest_address }}
                    </div>
                @endif
                <div class="text">
                    <span>{{ trans('rest.food_order.instruction') }}:</span> {{ $order->delivery_note ?? '-' }}
                </div>
            </div>
        </div>
        <div class="footer-box-main-orderdetails-item d-flex align-items-start gap-2">
            <div class="text-grp">
                <div class="text">
                    <span>{{ trans('rest.food_order.delivery_mode') }}: </span>{{ $order->delivery_time }}
                </div>
                <div class="text">
                    <span>{{ trans('rest.food_order.payment_method') }}: </span>{{ $order->payment_type == PaymentType::Card ? trans('rest.food_order.card'): ($order->payment_type == PaymentType::Cash ? trans('rest.food_order.cod'):'Ideal') }}
                </div>
                <div class="text">
                    <span>{{ trans('rest.food_order.type') }}: </span>{{ $order->order_type == OrderType::Delivery ? trans('rest.food_order.delivery'):trans('rest.food_order.pickup') }}
                </div>
            </div>
        </div>
    </div>
    <div class="footer-box-main-progressbar position-relative d-flex align-items-center justify-content-between gap-1">
        <div
            class="active footer-box-main-progressbar-item d-flex flex-column align-items-center justify-content-center text-center gap-2">
            <div class="img d-flex align-items-center justify-content-center cursor-pointer">
                <img src="{{ asset('images/order-accept.svg') }}" class="img-fluid svg" width="18" height="18">
            </div>
            <div class="text">{{ trans('rest.order_status.accepted') }}</div>
        </div>

        <?php $order_status = trans('rest.order_status.in_kitchen'); ?>
        @if($order->order_status >= OrderStatus::InKitchen)
            <div
                class="active footer-box-main-progressbar-item d-flex flex-column align-items-center justify-content-center text-center gap-2">
                <div class="img d-flex align-items-center justify-content-center cursor-pointer">
                    <img src="{{ asset('images/orderinkitchen-black.svg') }}" class="img-fluid svg" width="25"
                         height="19">
                </div>
                <div class="text">{{ $order_status }}</div>
            </div>
        @else
            <div
                class="footer-box-main-progressbar-item d-flex flex-column align-items-center justify-content-center text-center gap-2">
                <div class="img d-flex align-items-center justify-content-center cursor-pointer">
                    <img src="{{ asset('images/orderinkitchen-white.svg') }}" class="img-fluid svg" width="25"
                         height="19">
                </div>
                <div class="text">{{ $order_status }}</div>
            </div>
        @endif

        @if($order->order_type == OrderType::Delivery)
                <?php $order_status = trans('rest.order_status.ready'); ?>
            @if($order->order_status >= OrderStatus::Ready)
                <div
                    class="active footer-box-main-progressbar-item d-flex flex-column align-items-center justify-content-center text-center gap-2">
                    <div class="img d-flex align-items-center justify-content-center cursor-pointer">
                        <img src="{{ asset('images/pickup-black.svg') }}" class="img-fluid svg" width="19" height="19">
                    </div>
                    <div class="text">{{ $order_status }}</div>
                </div>
            @else
                <div
                    class="footer-box-main-progressbar-item d-flex flex-column align-items-center justify-content-center text-center gap-2">
                    <div class="img d-flex align-items-center justify-content-center cursor-pointer">
                        <img src="{{ asset('images/pickup-white.svg') }}" class="img-fluid svg" width="19" height="19">
                    </div>
                    <div class="text">{{ $order_status }}</div>
                </div>
            @endif

                <?php $order_status = trans('rest.order_status.out_for_delivery'); ?>
            @if($order->order_status >= OrderStatus::OutForDelivery)
                <div
                    class="active footer-box-main-progressbar-item d-flex flex-column align-items-center justify-content-center text-center gap-2">
                    <div class="img d-flex align-items-center justify-content-center cursor-pointer">
                        <img src="{{ asset('images/out-for-delivery-black.svg') }}" class="img-fluid svg" width="27"
                             height="20">
                    </div>
                    <div class="text">{{ $order_status }}</div>
                </div>
            @else
                <div
                    class="footer-box-main-progressbar-item d-flex flex-column align-items-center justify-content-center text-center gap-2">
                    <div class="img d-flex align-items-center justify-content-center cursor-pointer">
                        <img src="{{ asset('images/out-for-delivery.svg') }}" class="img-fluid svg" width="27"
                             height="20">
                    </div>
                    <div class="text">{{ $order_status }}</div>
                </div>
            @endif

                <?php $order_status = trans('rest.order_status.delivered'); ?>
            @if($order->order_status >= OrderStatus::Delivered)
                <div
                    class="active footer-box-main-progressbar-item d-flex flex-column align-items-center justify-content-center text-center gap-2">
                    <div class="img d-flex align-items-center justify-content-center cursor-pointer">
                        <img src="{{ asset('images/order-accept.svg') }}" class="img-fluid svg" width="19" height="19">
                    </div>
                    <div class="text">{{ $order_status }}</div>
                </div>
            @else
                <div
                    class="footer-box-main-progressbar-item d-flex flex-column align-items-center justify-content-center text-center gap-2">
                    <div class="img d-flex align-items-center justify-content-center cursor-pointer">
                        <img src="{{ asset('images/delivered.svg') }}" class="img-fluid svg" width="19" height="19">
                    </div>
                    <div class="text">{{ $order_status }}</div>
                </div>
            @endif
        @else
                <?php $order_status = trans('rest.order_status.ready_for_pickup'); ?>
            @if($order->order_status >= OrderStatus::ReadyForPickup)
                <div
                    class="active footer-box-main-progressbar-item d-flex flex-column align-items-center justify-content-center text-center gap-2">
                    <div class="img d-flex align-items-center justify-content-center cursor-pointer">
                        <img src="{{ asset('images/pickup-black.svg') }}" class="img-fluid svg" width="19" height="19">
                    </div>
                    <div class="text">{{ $order_status }}</div>
                </div>
            @else
                <div
                    class="footer-box-main-progressbar-item d-flex flex-column align-items-center justify-content-center text-center gap-2">
                    <div class="img d-flex align-items-center justify-content-center cursor-pointer">
                        <img src="{{ asset('images/pickup-white.svg') }}" class="img-fluid svg" width="19" height="19">
                    </div>
                    <div class="text">{{ $order_status }}</div>
                </div>
            @endif

                <?php $order_status = trans('rest.order_status.delivered'); ?>
            @if($order->order_status >= OrderStatus::Delivered)
                <div
                    class="active footer-box-main-progressbar-item d-flex flex-column align-items-center justify-content-center text-center gap-2">
                    <div class="img d-flex align-items-center justify-content-center cursor-pointer">
                        <img src="{{ asset('images/order-accept.svg') }}" class="img-fluid svg" width="19" height="19">
                    </div>
                    <div class="text">{{ $order_status }}</div>
                </div>
            @else
                <div
                    class="footer-box-main-progressbar-item d-flex flex-column align-items-center justify-content-center text-center gap-2">
                    <div class="img d-flex align-items-center justify-content-center cursor-pointer">
                        <img src="{{ asset('images/delivered.svg') }}" class="img-fluid svg" width="19" height="19">
                    </div>
                    <div class="text">{{ $order_status }}</div>
                </div>
            @endif
        @endif
    </div>
    <div class="footer-box-main-orderlist">
        <div class="footer-box-main-orderlist-header d-flex align-items-center justify-content-between">
            <div class="text-grp d-flex align-items-center gap-1">
                <div class="title">{{ trans('rest.food_order.order_list') }} :</div>
                <div class="number">({{ count($order->dishDetails) }} x {{ trans('rest.food_order.items') }})</div>
            </div>
            <button id="toggleOrderList"
                class="bg-transparent border-0 d-flex align-items-center justify-content-center">
                <img src="{{ asset('images/upward-arrow.svg') }}" alt="call"
                    class="uparrowOrderList" class="img-fluid svg" width="17"
                    height="10">

                <img src="{{ asset('images/downward-arrow.svg') }}"
                    class="downarrowOrderList" style="display: none !important;"
                    alt="call" class="img-fluid svg" width="17"
                    height="10">
            </button>
        </div>
        <div class="footer-box-main-orderlist-main d-flex flex-column" id="orderList">
            <?php $itemTotalPrice = 0; ?>
            @foreach($order->dishDetails as $key => $dish)
                <div class="footer-box-main-orderlist-main-item d-flex">
                    <div class="text-grp orderRead-more">
                        <div class="title"><span>{{ $dish->qty }}x</span> {{ $dish->dish->name }}</div>
                        <div class="text line-clamp-2" id="order-ingredient-{{ $dish->id}}">

                            @if(count($dish->orderDishOptionDetails) > 0)
                                <b class="mb-0 item-options"> {{ getDishOptionCategoryName($dish->orderDishOptionDetails->pluck('dish_option_id')) ?? '' }} </b>
                                <br>
                            @endif
                            {{-- old code comment 13-08-2024 --}}
                            {{ getOrderDishIngredients($dish) }}
                        </div>
                        @if(count($dish->orderDishPaidIngredients) > 3)
                            <div class="text">
                                <a href="javascript:void(0)" id="read-more-{{ $dish->id}}"
                                   onclick="readMore({{ $dish->id}})">{{ trans('rest.food_order.read_more') }}</a>
                                <a href="javascript:void(0)" style="display:none;" id="close-{{ $dish->id}}"
                                   onclick="hideReadMore({{ $dish->id}})">{{ trans('rest.food_order.close') }}</a>
                            </div>
                        @endif
                        @if(!empty($dish->notes))
                            <div class="notes">
                                <u>{{ $dish->notes }}</u>
                                {{-- <div
                                    class="text d-flex align-items-center justify-content-center">{{ trans('rest.food_order.notes') }}</div>
                                <input type="text" placeholder="{{ $dish->notes }}" class="input" data-toggle="tooltip"
                                       title="{{ $dish->notes }}" readonly> --}}
                            </div>
                        @endif
                    </div>
                    {{--@if(!empty($dish->notes))
                        <div class="notes">
                            {{ $dish->notes }}
                            --}}{{-- <div
                                class="text d-flex align-items-center justify-content-center">{{ trans('rest.food_order.notes') }}</div>
                            <input type="text" placeholder="{{ $dish->notes }}" class="input" data-toggle="tooltip"
                                   title="{{ $dish->notes }}" readonly> --}}{{--
                        </div>
                    @endif--}}
                    <div class="price d-flex flex-column">
                            <?php $itemPrice = ($dish->price * $dish->qty) + $dish->paid_ingredient_total; ?>
                        <div class="title">€{{ number_format($itemPrice, 2) }}</div>
                        {{-- <div class="text">x{{ $dish->qty }}</div> --}}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div class="footer-main-total">
        <div class="footer-main-total-header d-flex align-items-center justify-content-between">
            <div class="text-grp d-flex align-items-center gap-2">
                <div class="title">{{ trans('rest.food_order.total') }} :</div>
                <div class="number">€{{ number_format(getOrderGrossAmount($order), 2) }}</div>
            </div>
            <button id="toggleTotal"
            class="bg-transparent border-0 d-flex align-items-center justify-content-center">
            <img src="{{ asset('images/upward-arrow.svg') }}" alt="call"
                class="uparrowTotal" class="img-fluid svg" width="17"
                height="10">

            <img src="{{ asset('images/downward-arrow.svg') }}"
                class="downarrowTotal" style="display: none !important;"
                alt="call" class="img-fluid svg" width="17"
                height="10">
        </button>
        </div>
        <div class="footer-main-total-main" id="totalList">
            <div class="title">{{ trans('rest.food_order.bill_details') }}</div>
            <div class="text-grp d-flex flex-column gap-3">
                <div class="text d-flex align-items-center justify-content-between gap-2">
                    <div class="key">{{ trans('rest.food_order.item_total') }}</div>
                    <div class="value">€{{ number_format(getOrderGrossAmount($order), 2) }}</div>
                </div>
                <div class="text d-flex align-items-center justify-content-between gap-2" {{ $order->platform_charge > 0 ? '' : 'style=display:none' }}>
                    <div class="key">{{ trans('rest.food_order.service_charge') }}</div>
                    <div class="value">€{{ number_format($order->platform_charge, 2) }}</div>
                </div>

                <div class="text d-flex align-items-center justify-content-between gap-2" style="{{ $order->order_type == '2' ? 'display:none !important;' : '' }}">
                    <div
                        class="key">{{ $order->delivery_charge ?   trans('user.my_orders.delivery_charges') :  trans('user.my_orders.delivery') }}</div>
                    <div class="value {{ $order->delivery_charge > 0 ? '' : 'text-green' }}">
                        {{ $order->delivery_charge > 0 ? '€'.number_format($order->delivery_charge, 2) : 'FREE' }}
                    </div>
                </div>


                <div class="active text d-flex align-items-center justify-content-between gap-2">
                    <div class="key">{{ trans('rest.food_order.discount') }}</div>
                    <div class="value">-€{{ number_format($order->coupon_discount, 2) }}</div>
                </div>
            </div>
        </div>
        <div class="footer-main-total-footer">
            <div class="text-grp d-flex align-items-center gap-2 justify-content-between">
                <div class="key">{{ trans('rest.food_order.total') }}</div>
                <div class="value">€{{ number_format($order->total_amount,2) }}</div>
            </div>
        </div>
    </div>
</div>
<div class="foodorder-box-details-footer d-flex align-items-center justify-content-between gap-2 footer-btn-sticky">
    <a class="btn btn-auto"
       target="_blank"
       href="{{ route('orders.printLabel', ['order_id' => $order->id]) }}">{{ trans('rest.food_order.print') }}</a>

    <?php
    $order_status_cur_val = $order->order_status;

    $order = getOrderStatus($order);
    $order_status_key = OrderStatus::getKey($order->order_status);
    $order_status = preg_replace('/(?<=\\w)(?=[A-Z])/', " $1", $order_status_key);
    ?>

    @if($order_status_cur_val != OrderStatus::Delivered)
        <button class="btn active btn-auto move-order-button" class="customize-foodlink button"
                onclick="changeOrderStatus({{ $order->id }},'{{ $order_status }}')">
            {{ trans('rest.food_order.move_to') }} '{{ $order_status }}'
        </button>
    @endif
    <input type="hidden" id="id" value="">
</div>

