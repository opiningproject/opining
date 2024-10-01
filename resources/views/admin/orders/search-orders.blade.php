<?php

use App\Enums\OrderStatus;
use App\Enums\OrderType;
use App\Enums\PaymentType;

?>

@if(count($orders))
    <div class="order-listing-container">
        <div class="order-row">
            @foreach($orders as $key => $ord)
                <?php $userDetails = $ord->orderUserDetails; ?>

                  <div class="order-col" id="order-{{ $ord->id }}" data-id="{{ $ord->id }}">
                    <div class="order-box">
                        <div class="timing">
                            <h3 class="expectedDeliveryTime-{{$ord->id}}">{{ $ord->expected_delivery_time ? date('H:i', strtotime($ord->expected_delivery_time)) : date('H:i', strtotime(\Carbon\Carbon::parse($ord->created_at)->addMinutes($orderDeliveryTime))) }}</h3>
                            <label class="success">{{ $ord->delivery_time }}</label>
                            {{-- <h4 class="mt-2">{{ $ord->order_type == OrderType::Delivery ? trans('rest.food_order.delivery'):trans('rest.food_order.take_away') }}</h4> --}}
                        </div>

                        <div class="details">
                            <div class="left">
                                <h4>{{ $userDetails ? $userDetails->order_name : "no name" }}</h4>
                                @if ($ord->order_type == OrderType::Delivery)
                                    <p class="mb-0">
                                        <?php
                                        echo $userDetails->house_no . ', ' . $userDetails->street_name;
                                        ?>
                                    </p>
                                @else
                                    <p class="mb-0">
                                        {{ getRestaurantDetail()->rest_address }}
                                    </p>
                                @endif
                            </div>

                            {{-- <div class="right text-end ps-2">
                                <p class="mb-0">{{ date('d-m-Y H:i',strtotime($ord->created_at)) }}</p>
                                <p class="mb-0">Web #{{$ord->id}}</p>
                            </div> --}}
                        </div>
                        <div class="actions">
                            <h5 class="mb-0 price_status"><b>€{{ number_format($ord->total_amount, 2) }}</b>&nbsp;&nbsp;|&nbsp;&nbsp;{{ $ord->payment_type == PaymentType::Cash && $ord->order_status != OrderStatus::Delivered ? 'Unpaid' : 'Paid' }}</h5>
                            <button class="orderDetails order-status-{{ $ord->id }} btn {{orderStatusBox($ord)->color }}" onclick="orderDetailNew({{ $ord->id }})" >{{ orderStatusBox($ord)->text }}</button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="d-flex justify-content-end align-items-center pt-3">
        <!-- Pagination -->
        <nav aria-label="Page navigation example">
            {{ $orders->appends(['search' => request()->input('search')])->links() }}
        </nav>

        <!-- Filter buttons -->
        <div class="filter-btn-group">

            <button type="button" class="btn">
                <img src="{{ asset(path: 'images/map-white.svg') }}"
                     alt="Bike"  />
            </button>

            <button type="button" class="btn order-setting">
                <img src="{{ asset(path: 'images/setting-white.svg') }}"
                     alt="Bike"  />
            </button>
        </div>
    </div>
@else
    <span class="no-data">{{ trans('rest.food_order.no_order') }}</span>
@endif
