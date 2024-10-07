<?php

use App\Enums\OrderStatus;
use App\Enums\OrderType;
use App\Enums\PaymentType;

?>

@if (count($allOrders))
    <div class="row map-order-listing-row">
        <div class="col-md-7">
            <div id="orders-map-marker" style="height: calc(100vh - 230px);"></div>
        </div>
        <div class="col-md-5">
            <div class="orderList">
                <div class="order-listing-container">
                    <div class="order-row">
                        <div class="col-12">
                            @foreach ($allOrders as $key => $ord)
                                <?php $userDetails = $ord->orderUserDetails; ?>
                                <div class="order-col cursor-pointer" id="order-{{ $ord->id }}"
                                     data-id="{{ $ord->id }}"
                                     onclick="orderDetailNew({{ $ord->id }})">
                                    <div class="order-box">
                                        <div class="timing">
                                            <h3 class="expectedDeliveryTime-{{ $ord->id }}">
                                                {{ $ord->expected_delivery_time ? date('H:i', strtotime($ord->expected_delivery_time)) : date('H:i', strtotime(\Carbon\Carbon::parse($ord->created_at)->addMinutes($orderDeliveryTime))) }}
                                            </h3>
                                            {{--                                                    @if ($ord->delivery_time != 'ASAP') --}}
                                            <label class="success">{{ $ord->delivery_time }}</label>
                                            {{--                                                    @endif --}}
                                        </div>

                                        <div class="details">
                                            <div class="left">
                                                <div class="label-icon">
                                                    <img src="{{ asset('images/opening-label.svg') }}"
                                                         class="svg" />
                                                </div>

                                                <div class="text-label">
                                                    <h4>{{ $userDetails->order_name }}</h4>
                                                    @if ($ord->order_type == OrderType::Delivery)
                                                        <p class="mb-0">
                                                            <?php
                                                            echo $userDetails->house_no . ', ' . $userDetails->street_name;
                                                            ?>
                                                        </p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="actions">
                                            <h5 class="mb-0 price_status">
                                                <b>€{{ number_format($ord->total_amount, 2) }}</b>
                                                @if ($ord->payment_type == \App\Enums\PaymentType::Cash)
                                                    <img src="{{ asset('images/cod_icon.png') }}"
                                                         class="svg" height="20"
                                                         width="20" />
                                                @endif
                                                @if ($ord->payment_type == \App\Enums\PaymentType::Card)
                                                    <img src="{{ asset('images/purse.svg') }}"
                                                         class="svg" height="20"
                                                         width="20" />
                                                @endif
                                                @if ($ord->payment_type == \App\Enums\PaymentType::Ideal)
                                                    <img src="{{ asset('images/paid-deal.svg') }}"
                                                         class="svg" height="20"
                                                         width="20" />
                                                @endif
                                            </h5>
                                            <button
                                                class="orderDetails order-status-{{ $ord->id }} btn {{ orderStatusBox($ord)->color }}">
                                                {{ orderStatusBox($ord)->text }}</button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@else
    <span class="no-data">{{ trans('rest.food_order.no_order') }}</span>
@endif
{{--<script type="text/javascript" src="{{ asset('js/orders-map.js') }}"></script>--}}
<script
    src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_place_key') }}&callback=initOrderMapMarkerSearch"
    async defer></script>
<script>
    let mapOrders;

    // Pass the PHP orders data to JavaScript
    var order = @json($allOrders);
    const ordersSearch = order.data;
    console.log("orders", ordersSearch)
    // Initialize the Google Map
    function initOrderMapMarkerSearch() {
        // Create the map centered at the first location
        mapOrders = new google.maps.Map(document.getElementById('orders-map-marker'), {
            center: {
                lat: 51.8891026,
                lng: 4.4767527
            }, // location 1
            zoom: 9
        });

        // Define custom marker icon (you can replace the URL with your custom icon image URL)
        const customIcon = {
            url: "{!! asset('images/opening-label.svg') !!}", // Replace with your own icon URL
            scaledSize: new google.maps.Size(40, 40), // Scales the icon
            origin: new google.maps.Point(0, 0), // The origin point (top-left)
            anchor: new google.maps.Point(20, 40) // The anchor point (where the icon is anchored to the map)
        };

        ordersSearch.forEach(order => {
            if (order.order_user_details.latitude && order.order_user_details.longitude) {
                const marker = new google.maps.Marker({
                    position: {
                        lat: parseFloat(order.order_user_details.latitude),
                        lng: parseFloat(order.order_user_details.longitude)
                    }, // Location from the order data
                    map: mapOrders,
                    icon: customIcon // Set the custom icon here
                });
                marker.addListener('click', function() {
                    // Call the orderDetailNew function with the order ID when clicked
                    orderDetailNew(order.id);
                });
            }
        });

        $(document).ready(function() {
            function arrangeOrderCols() {
                var screenHeight = $(window).height();
                var availableHeight = screenHeight - 230; // Space for margins, headers, etc.
                var columnGap = 10; // Space between columns and between items

                // Determine the maximum number of items per column dynamically based on screen height
                var maxItemsPerColumn = screenHeight > 1079 ?
                    Math.floor(availableHeight / (76 + columnGap)) :
                    8; // Above 1080px, the number of items per column is dynamic

                // Determine itemMinHeight based on screen height
                var itemMinHeight = screenHeight < 800 ? 58 : 76;

                // Calculate the height of each item dynamically based on available space
                var dynamicItemHeight = (availableHeight - (maxItemsPerColumn - 1) * columnGap) / maxItemsPerColumn;

                var $orderCols = $('.order-col');
                var $container = $('.order-listing-container');

                // Clear any existing columns
                $container.empty();

                // Create three columns
                for (var col = 0; col < 3; col++) {
                    var currentColumn = $('<div class="order-column"></div>'); // Create a new column
                    $container.append(currentColumn); // Append the new column to the container

                    // Add items to each column, based on the dynamic number of items per column
                    for (var i = col * maxItemsPerColumn; i < (col + 1) * maxItemsPerColumn && i < $orderCols
                        .length; i++) {
                        var $item = $orderCols.eq(i);
                        currentColumn.append($item); // Append the item to the current column
                        $item.css('height', dynamicItemHeight + 'px'); // Set dynamic height for each item
                    }
                }
            }

            // Initial arrangement
            arrangeOrderCols();

            // Update on window resize
            $(window).resize(arrangeOrderCols);
        });
    }
</script>
