<?php

use App\Enums\OrderStatus;
use App\Enums\OrderType;
use App\Enums\PaymentType;

?>
@foreach($orders as $order)
    <?php $userDetails = $order->orderUserDetails; ?>

    <div class="modal fade custom-modal order-notification-popup" id="newOrderModal" tabindex="-1"
         aria-labelledby="newOrderModal"
         aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog-centered">
            <div class="modal-content border-radius">
                <div class="modal-header border-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pt-1">
                    <div class="text-center mb-4">
                        <h1 class="mb-4 font-18 text-center">{{ $order->order_type == OrderType::Delivery ? trans('rest.food_order.delivery') : trans('rest.food_order.pickup') }}</h1>
                        <h3 class="mb-2 font-16 text-center">{{ $order->delivery_time }} </h3>
                        @if(str_contains(url()->current(), '/orders/') == true)
                            <button class="btn btn-custom-yellow fw-400 text-uppercase font-sebibold px-5 mt-2 font-18 order_details_button" data-id="{{ $order->id }}" onclick="orderDetail({{ $order->id }})" >{{ trans('rest.food_order.order_details') }}</button>
                        @else
                            <a href="{{ route('orders', ['date_filter' => $order->id]) }}" target="_blank"
                               class="btn btn-custom-yellow fw-400 text-uppercase font-sebibold px-5 mt-2 font-18 order_details_button">{{ trans('rest.food_order.order_details') }}</a>
                        @endif

                    </div>
                    <div class="orderTop d-flex align-items-center justify-content-between mb-3 border-bottom pb-2">
                        <div class="left d-flex align-items-center">
                            <h3 class="font-14">{{ trans('rest.food_order.order') }} #{{ $order->id }}</h3>
                            <h3 class="font-14">&nbsp;{{$order->created_at}}</h3>
                        </div>
                        <div class="right d-flex align-items-center ml-auto font-14">
                            <h3 class="font-14"><i class="fa fa-phone font-12 text-yellow-2"></i> +31 {{ $userDetails->order_contact_number ?? "-"}} </h3>
                        </div>
                    </div>
                    <div class="row justify-content-between">
                        <div class="col-md-6 mb-3">
                            <div class="font-14">
                                <h3 class="font-14"><i class="fa fa-location-dot font-12 text-yellow-2"></i>
                                    @if($order->order_type == OrderType::Delivery)
                                        <?php
                                            echo $userDetails->house_no . ', ' . $userDetails->street_name . ', ' . $userDetails->city . ', ' . $userDetails->zipcode;
                                        ?>
                                    @else
                                         {{ getRestaurantDetail()->rest_address }}
                                    @endif
                                </h3>
                                @if($order->delivery_note)
                                <p><span class="text-black">{{ trans('rest.food_order.instruction') }}:</span>
                                    {{ $order->delivery_note ?? '-' }}
                                </p>
                                    @endif
                            </div>
                        </div>


                        <div class="col-md-5 text-md-left mb-3">
                            <div class="font-14">
                                <h4 class="text-black-50 font-14"><span class="text-black">{{ trans('rest.food_order.delivery_mode') }}:</span>
                                    {{ $order->delivery_time }}</h4>
                                <h4 class="text-black-50 font-14"><span class="text-black">{{ trans('rest.food_order.payment_method') }}:</span>
                                    {{ $order->payment_type == PaymentType::Card ? trans('rest.food_order.card'): ($order->payment_type == PaymentType::Cash ? trans('rest.food_order.cod'):'Ideal') }}
                                </h4>
                                <h4 class="text-black-50 font-14"><span class="text-black">{{ trans('rest.food_order.order_type') }}:</span>
                                    {{ $order->order_type == OrderType::Delivery ? trans('rest.food_order.delivery') : trans('rest.food_order.pickup') }}
                                </h4>
                            </div>
                        </div>
                    </div>

                    <div class="items-list-order">
                        <h3 class="cart-title mb-4">{{ trans('rest.food_order.item_list') }}
                            ({{ count($order->dishDetails) }}
                            x {{ trans('rest.food_order.items') }})</h3>

                        <div class="orders_item justify-content-between">
                            @foreach($order->dishDetails as $item)
                                <div class="ord_item">
                                    <h2><span class="me-2 d-inline-block">{{ $item->qty }} x</span> {{ $item->dish->name }}</h2>
                                    <h4>+€{{ (($item->price * $item->qty) + $item->paid_ingredient_total) }}</h4>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach
