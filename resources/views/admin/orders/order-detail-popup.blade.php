<?php

use App\Enums\OrderStatus;
use App\Enums\OrderType;
use App\Enums\PaymentStatus;
use App\Enums\PaymentType;
use App\Enums\RefundStatus;

$userDetails = $order->orderUserDetails;
$restaurantDetail = getRestaurantDetail();
?>

<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-header border-0">
            <div class="head-flex">
                <h3 class="mb-0">
                    {{ $order->order_type == OrderType::Delivery ? trans('rest.food_order.delivery') : trans('rest.food_order.take_away') }}
                    ORDER #{{ $order->id }}</h3>
                <h3 class="mb-0">{{ trans('modal.order_detail.website_order') }}</h3>
                <h3 class="mb-0">{{ date('d-m-Y H:i', strtotime($order->created_at)) }}</h3>
            </div>
        </div>
        <input type="hidden" class="order_id" value="{{ $order->id }}">
        {{--                $userDetails->latitude $userDetails->longitude --}}
        <input type="hidden" class="latitude" name="status" value="{{ $userDetails->latitude }}">
        <input type="hidden" class="longitude" name="status" value="{{ $userDetails->longitude }}">
        <div class="modal-body pt-1 pb-0">
            <div
                class="border-0 d-flex align-items-center justify-content-between mb-0 {{ $order->order_status == OrderStatus::Cancelled ? 'd-none' : '' }}">

                <div class="order-status">

                    <div class="order-col">
                        <label
                            class="status-option order-status-option {{ $order->order_status == OrderStatus::Accepted ? 'active' : '' }}">
                            <input id="accepted-order" type="radio" class="order-status-radio" name="orderStatus"
                                {{ $order->order_status == OrderStatus::Accepted ? 'checked' : '' }} />
                            <span for="accepted-order"></span>
                            <label>{{ trans('modal.order_detail.new_order') }}</label>
                        </label>
                    </div>

                    <div class="order-col">
                        <label
                            class="order-status-option status-option {{ $order->order_status == OrderStatus::InKitchen ? 'active' : '' }}">
                            <input id="inKitchen-order" type="radio" class="order-status-radio" name="order-status-option"
                                {{ $order->order_status == OrderStatus::InKitchen ? 'checked' : '' }}
                                onclick="changeOrderStatusNew({{ $order->id }},'{{ OrderStatus::InKitchen }}')" />
                            <span for="inKitchen-order"></span>
                            <label>{{ trans('modal.order_detail.in_kitchen') }}</label>
                        </label>
                    </div>
                    @if ($order->order_type == OrderType::Delivery)
                        <div class="order-col">
                            <label
                                class="order-status-option status-option {{ $order->order_status == OrderStatus::OutForDelivery ? 'active' : '' }}">
                                <input id="outForDelivery-order" type="radio" class="order-status-radio" name="order-status-option"
                                    {{ $order->order_status == OrderStatus::OutForDelivery ? 'checked' : '' }}
                                    onclick="changeOrderStatusNew({{ $order->id }},'{{ OrderStatus::OutForDelivery }}')" />
                                <span for="outForDelivery-order"></span>
                                <label>{{ trans('modal.order_detail.out_for_delivery') }}</label>
                            </label>
                        </div>
                    @else
                        <div class="order-col">
                            <label
                                class="order-status-option status-option {{ $order->order_status == OrderStatus::ReadyForPickup ? 'active' : '' }}">
                                <input id="outForDelivery-order" type="radio" class="order-status-radio" name="order-status-option"
                                    {{ $order->order_status == OrderStatus::ReadyForPickup ? 'checked' : '' }}
                                    onclick="changeOrderStatusNew({{ $order->id }},'{{ OrderStatus::ReadyForPickup }}')" />
                                <span for="outForDelivery-order"></span>
                                <label>{{ trans('modal.order_detail.ready_for_pickup') }}</label>
                            </label>
                        </div>
                    @endif

                    <div class="order-col">
                        <label
                            class="order-status-option status-option {{ $order->order_status == OrderStatus::Delivered ? 'active' : '' }}">
                            <input id="delivered-order" type="radio" class="order-status-radio" name="order-status-option"
                                {{ $order->order_status == OrderStatus::Delivered ? 'checked' : '' }}
                                onclick="changeOrderStatusNew({{ $order->id }},'{{ OrderStatus::Delivered }}')" />
                            <span for="delivered-order"></span>
                            <label>{{ trans('modal.order_detail.delivered') }}</label>
                        </label>
                    </div>
                </div>

            </div>
            <div class="clearfix">
                <ul class="nav nav-tabs justify-content-between" id="myTab" role="tablist">
                    <!-- First Tab -->
                    <li class="nav-item" role="presentation" style="width: {{$order->order_type == OrderType::Delivery ? '25%' :'33.33%'}};">
                        <button class="nav-link active w-100" id="tab-1" data-bs-toggle="tab"
                            data-bs-target="#content-1" type="button" role="tab" aria-controls="content-1"
                            aria-selected="true">{{ trans('modal.order_detail.customer_data') }}</button>
                    </li>
                    <!-- Second Tab -->
                    <li class="nav-item" role="presentation" style="width: {{$order->order_type == OrderType::Delivery ? '25%' :'33.33%'}};">
                        <button class="nav-link w-100" id="tab-2" data-bs-toggle="tab" data-bs-target="#content-2"
                            type="button" role="tab" aria-controls="content-2" aria-selected="false">
                            {{ trans('modal.order_detail.order_item', ['number_of_dish' => count($order->dishDetails)]) }}
                        </button>
                    </li>
                    @if ($order->order_type == OrderType::Delivery)
                    <!-- Third Tab -->
                    <li class="nav-item" role="presentation" style="width: {{$order->order_type == OrderType::Delivery ? '25%' :'33.33%'}};">
                        <button class="nav-link w-100" id="tab-3" data-bs-toggle="tab" data-bs-target="#content-3"
                            type="button" role="tab" aria-controls="content-3"
                            aria-selected="false">Route Planner</button>
                    </li>
                    @endif
                    <!-- Fourth Tab -->
                    <li class="nav-item" role="presentation" style="width: {{$order->order_type == OrderType::Delivery ? '25%' :'33.33%'}};">
                        <button class="nav-link w-100" id="tab-4" data-bs-toggle="tab"
                            data-bs-target="#content-4" type="button" role="tab" aria-controls="content-4"
                            aria-selected="false">{{ trans('modal.order_detail.deliverer') }}</button>
                    </li>
                </ul>

                <!-- Tab Content -->
                <div class="tab-content px-0 pb-0">
                    <!-- Content for Tab 1 -->
                    <div class="tab-pane fade show active" id="content-1" role="tabpanel" aria-labelledby="tab-1">
                        <div class="row">
                            <div class="col-lg-5 mb-3">
                                <div class="table-content">
                                    <table>
                                        <tr>
                                            <th>{{ trans('modal.order_detail.name') }}</th>
                                            <td>{{ $userDetails->order_name }}</td>
                                        </tr>

                                        <tr>
                                            <th>{{ trans('modal.order_detail.address') }}</th>
                                            <td>
                                                @if ($order->order_type == OrderType::Delivery)
                                                    {{ $userDetails->house_no . ', ' . $userDetails->street_name . ', ' . $userDetails->city . ', ' . $userDetails->zipcode }}
                                                @else
                                                    {{ getRestaurantDetail()->rest_address }}
                                                @endif
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>{{ trans('modal.order_detail.phone') }}</th>
                                            <td>{{ $userDetails->order_contact_number }}</td>
                                        </tr>

                                        <tr>
                                            <th>{{ trans('modal.order_detail.email') }}</th>
                                            <td>{{ $userDetails->order_email }}</td>
                                        </tr>

                                        <tr>
                                            <th>{{ trans('modal.order_detail.order') }}</th>
                                            <td>{{ trans('modal.order_detail.total') }}
                                                €{{ number_format($order->total_amount, 2) }} <br />
                                                {{ $order->payment_type == PaymentType::Card ? trans('rest.food_order.card') : ($order->payment_type == PaymentType::Cash ? trans('rest.food_order.cod') : 'Ideal') }}
                                            </td>
                                        </tr>
                                        @if ($order->coupon_code)
                                            <tr>
                                                <th>{{ trans('modal.order_detail.promo_code') }}</th>
                                                <td>
                                                    <p class="text-uppercase">
                                                        {{ $order->coupon_code ? $order->coupon_code : '-' }}</p>
                                                </td>
                                            </tr>
                                        @endif
                                        @if ($order->delivery_note)
                                            <tr>
                                                <th>{{ trans('modal.order_detail.note') }}</th>
                                                <td>
                                                    <p class="text-underline">
                                                        {{ $order->delivery_note ? $order->delivery_note : '-' }}</p>
                                                </td>
                                            </tr>
                                        @endif
                                    </table>
                                </div>
                            </div>
                            <div class="col-lg-7 mb-3">
                                <div class="timing-details mb-3">
                                    <div class="timing-row">
                                        <label>{{ trans('modal.order_detail.wished_time') }} </label>
                                        <div class="timing-col">
                                            <div class="t-box bg-transperent"></div>
                                            <div class="text-uppercase">{{ $order->delivery_time }}</div>
                                            <div class="t-box bg-transperent"></div>
                                        </div>
                                    </div>

                                    <div class="timing-row">
                                        <label>{{ trans('modal.order_detail.wished_time') }}</label>
                                        <div class="timing-col">
                                            <button class="t-box update-delivery-time">-5</button>
                                            <div class="text-uppercase">
                                                <span class="expected_time_order">
                                                    {{ $order->expected_delivery_time ? date('H:i', strtotime($order->expected_delivery_time)) : date('H:i', strtotime(\Carbon\Carbon::parse($order->created_at)->addMinutes($orderDeliveryTime))) }}
                                                </span>
                                            </div>
                                            <button class="t-box update-delivery-time">+5</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content for Tab 2 -->
                    <div class="tab-pane fade" id="content-2" role="tabpanel" aria-labelledby="tab-2">
                        <div class="row items-in-row">

                            <div class="col-12 mb-3">
                                <div class="dish-details-row">
                                    <?php $itemTotalPrice = 0;
                                    $dishIngredientsTotalAmount = 0; ?>
                                    @foreach ($order->dishDetails as $key => $dish)
                                        <div class="d-flex ord_listing mb-3">
                                            <div class="num-items d-flex gap-1">
                                                <h4>{{ $dish->qty }}X</h4>

                                                <div class="item-option">
                                                    <h5>{{ $dish->dish->name }}</h5>
                                                    @if (count($dish->orderDishOptionDetails) > 0)
                                                        <h6>Options</h6>
                                                        @php
                                                            /*old code comment on 13-08-2024*/
                                                            $htmlStringDishOptionCategory =
                                                                getDishOptionCategoryName(
                                                                    $dish->orderDishOptionDetails->pluck(
                                                                        'dish_option_id',
                                                                    ),
                                                                ) ?? '';
                                                            $cleanedDishOptionHtmlString = str_replace(
                                                                '"',
                                                                '',
                                                                $htmlStringDishOptionCategory,
                                                            );
                                                            $dishIngredientsTotalAmount = getDishOptionCategoryTotalAmount(
                                                                $dish->orderDishOptionDetails->pluck('dish_option_id'),
                                                            );
                                                        @endphp
                                                        <ul>
                                                            {!! $cleanedDishOptionHtmlString !!}
                                                        </ul>
                                                    @else
                                                        @php $dishIngredientsTotalAmount = 0 ;@endphp
                                                    @endif
                                                    <div class="dish-ing">
                                                        {{ getOrderDishIngredients($dish) }}
                                                    </div>
                                                </div>
                                            </div>
                                            <?php $itemPrice = $dish->price * $dish->qty + $dish->paid_ingredient_total + $dishIngredientsTotalAmount; ?>
                                            <div class="price ms-auto">€{{ number_format($itemPrice, 2) }}</div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Content for Tab 3 -->
                    <div class="tab-pane fade px-0" id="content-3" role="tabpanel" aria-labelledby="tab-3">
                            <div class="tab-map">
                                <div id="map" style="height: 290px; width: 100%;"></div>
                            </div>
                    </div>

                    <!-- Content for Tab 4 -->
                    <div class="tab-pane fade" id="content-4" role="tabpanel" aria-labelledby="tab-4">

                        <div class="order-status order-delivered">
                            @if (count($delivererUser) > 0)
                                @foreach ($delivererUser as $delivererUsers)
                                    <div class="order-col col-order-{{ $delivererUsers->id }}">
                                        <label class="status-option status-option-deliverers">
                                            <input id="test{{ $delivererUsers->id }}" type="radio"
                                                class="delivererUsers" name="status-option-deliverers"
                                                value="{{ $delivererUsers->id }}"
                                                {{ $order->deliverer_id == $delivererUsers->id ? 'checked' : '' }}
                                                onclick="assignDeliverer({{ $order->id }}, {{ $delivererUsers->id }})" />
                                            <span for="test{{ $delivererUsers->id }}"></span>
                                            <label>{{ $delivererUsers->full_name }}</label>
                                        </label>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-footer d-flex align-items-center justify-content-between">
            <div class="clearfix">
                @if($order->order_status != OrderStatus::Cancelled && $order->order_status != OrderStatus::Delivered)
                    <button type="button" class="btn btn-outline-danger text-danger" onclick="cancelOrder({{$order->id}})">{{ trans('modal.order_detail.cancel') }}</button>
                @endif
                <a class="btn btn-outline-secondary ms-2 text-secondary d-inline-flex align-items-center gap-3"
                    target="_blank"
                    href="{{ route('orders.printLabel', ['order_id' => $order->id]) }}">{{ trans('rest.food_order.print') }}</a>
            </div>

            <div class="clearfix d-flex align-items-center">
                @if ($order->delivery_note)
                    <h3 class="note d-flex align-items-center">{{ trans('modal.order_detail.see_note') }} <img
                            class="ms-1" src="{{ asset('images/note.png') }}" alt="" /></h3>
                @endif
                <h3 class="note d-flex align-items-center ms-3">
                    {{ $order->payment_type == PaymentType::Cash && $order->order_status != OrderStatus::Delivered ? trans('modal.order_detail.unpaid_order') : trans('modal.order_detail.paid_order') }}
                    <img class="ms-1" src="{{ asset('images/note.png') }}" alt="" />
                </h3>
                <button type="button" class="close-btn ms-3" data-bs-dismiss="modal"
                    aria-label="Close">Close</button>
            </div>
        </div>
    </div>
    {{-- cancel order model --}}

    <div class="modal fade custom-modal" id="cancelOrderModal" tabindex="-1" aria-labelledby="dleteAlertModal"
        aria-hidden="true">
        <div class="modal-dialog custom-w-441px modal-dialog-centered justify-content-center">
            <div>
                <input type="hidden" class="cancel_order" name="status" value="7">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <h4 class="alert-text-1 mb-40px">{{ trans('rest.modal.cancel_order.cancel_message') }}
                                </h4>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end cancel-btn">
                            <button type="button"
                                class="btn btn-outline-secondary fw-400 text-uppercase font-sebibold w-160px"
                                data-bs-dismiss="modal">{{ trans('rest.button.no') }}
                            </button>
                            <button type="button"
                                class="btn btn-site-theme fw-400 text-uppercase font-sebibold w-160px"
                                data-bs-dismiss="modal" id="cancel-order-btn">{{ trans('rest.button.yes') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_place_key') }}&callback=initOrderMap"
    async defer></script>
<script>
    let orderMap;
    let directionsService;
    let directionsRenderer;
    var latitudeValue = $('.latitude').val();
    var longitudeValue = $('.longitude').val();
    // Initialize the Google Map
    function initOrderMap() {
        // Create the map centered at the first location
        orderMap = new google.maps.Map(document.getElementById('map'), {
            // center: { lat: 23.0249769, lng: 72.5045738 }, // location 1
            zoom: 8,
            mapTypeControl: false
        });

        // Create Directions Service and Renderer instances
        directionsService = new google.maps.DirectionsService();
        directionsRenderer = new google.maps.DirectionsRenderer();

        // Set the map where the directions will be rendered
        directionsRenderer.setMap(orderMap);
        latitudeValue = '';
        longitudeValue ='';
        // Calculate and display the route
        calculateAndDisplayRoute();
    }
    function calculateAndDisplayRoute() {
        latitudeValue = $('.latitude').val();
        longitudeValue = $('.longitude').val();
        const origin = {
            lat: {!! $restaurantDetail->latitude; !!},
            lng: {!! $restaurantDetail->longitude; !!}  };
        const destination = { lat: parseFloat(latitudeValue), lng: parseFloat(longitudeValue) }; // location 2
        directionsService.route(
            {
                origin: origin,
                destination: destination,
                travelMode: 'DRIVING' // You can change this to WALKING, BICYCLING, or TRANSIT
            },
            (response, status) => {
                if (status === 'OK') {
                    // Display the route on the map
                    directionsRenderer.setDirections(response);
                } else {
                    // Handle the error if route calculation fails
                    // window.alert('Directions request failed due to ' + status);
                }
            }
        );
    }
</script>

