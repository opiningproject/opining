<?php

use App\Enums\OrderStatus;
use App\Enums\OrderType;

?>

@if(count($orders))
    <div class="order-listing-container">
        <div class="order-row">
            @foreach($orders as $key => $ord)
                <?php $userDetails = $ord->orderUserDetails; ?>

                <div class="order-col" id="order">
                    <div class="order-box">
                        <div class="timing">
                            <h3>{{ date('H:i',strtotime(\Carbon\Carbon::parse($ord->created_at)->addMinutes($orderDeliveryTime))) }}</h3>
                            <label class="success">{{ $ord->delivery_time }}</label>
                        </div>

                        <div class="details">
                            <div class="left">
                                <h4>{{ $userDetails ? $userDetails->order_name : "no name" }}</h4>
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
                                <p class="mb-0">Web #{{$ord->id}}</p>
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
{{--            {{ $orders->links() }}--}}
            {{ $orders->appends(['search' => request()->input('search')])->links() }}
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
@else
    <span class="no-data">{{ trans('rest.food_order.no_order') }}</span>
@endif
