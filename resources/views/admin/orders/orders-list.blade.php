<?php

use App\Enums\OrderStatus;
use App\Enums\OrderType;

?>

@if(count($orders))
    @foreach($orders as $key => $order)
            <?php
            $active = ''
            ?>
        @if($activeId != 0 && $orderExist)
            @if($order->id == $activeId)
                    <?php
                    $active = 'active';
                    ?>
            @endif
        @else
            @if($key ==  0)
                    <?php
                    $active = 'active';
                    ?>
            @endif
        @endif
        <div class="foodorder-box-list-item d-flex order-{{ $order->id }}"
             onclick="orderDetail({{ $order->id }})" id="order-{{ $order->id }}" data-id="{{ $order->id }}">
            <div class="details w-100 d-flex flex-column gap-3">
                <div class="title">{{ trans('rest.food_order.order') }}
                    #{{$order->id}} | {{ $order->created_at }}</div>
                <div
                    class="icontext-grp d-flex align-items-center justify-content-between">
                    <div class="icontext-item d-flex align-items-center gap-1">
                        <img src="{{ asset('images/fork-knife-icon.svg') }}"
                             class="img-fluid svg" alt="" height="22" width="22">
                        <div
                            class="text">{{ $order->order_type == OrderType::Delivery ? trans('rest.food_order.delivery'):trans('rest.food_order.pickup') }} </div>
                    </div>
                    <div class="icontext-item d-flex align-items-center gap-1">
                        <img src="{{ asset('images/hand-money-icon.svg') }}" alt=""
                             class="img-fluid svg" width="30" height="29">
                        <div class="text">
                            €{{ number_format($order->total_amount, 2) }}</div>
                    </div>
                </div>
            </div>
            <div
                class="time d-flex flex-column align-items-center justify-content-center text-center gap-1">
                <img
                    src="{{ $order->order_status >= OrderStatus::Delivered ? asset('images/clock-gray.svg') : asset('images/clock-yellow.svg') }}"
                    alt="time"
                    class="img-fluid svg" width="29" height="29">
                <div class="text">{{ $order->delivery_time }}</div>
            </div>
        </div>
    @endforeach
@else
    <span class="no-data">{{ trans('rest.food_order.no_order') }}</span>
@endif
