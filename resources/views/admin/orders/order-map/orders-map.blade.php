@extends('layouts.app')
@section('page_title', 'Orders')
@section('order_count', getOpenOrders()) <!-- Dynamically set the count -->
@section('content')
    <?php
    use App\Enums\OrderStatus;
    use App\Enums\OrderType;
    use App\Enums\PaymentStatus;
    use App\Enums\PaymentType;
    use App\Enums\RefundStatus;
    ?>
    <div class="main">
        <div class="main-view">
            <div class="container-fluid bd-gutter bd-layout">
                @include('layouts.admin.side_nav_bar')
                <main class="bd-main updated_order order-1 w-100 position-relative">
                    <div class="main-content food-order-main-content d-flex flex-column h-100 order-page">
                        <div
                            class="section-page-title mb-0 d-flex align-items-center justify-content-between gap-2 order-page-bar">

                            <div class="d-flex align-items-center btn-grp-gap-10 btn-grp-tab">
                                <button type="button" name="clear" value="all" id="clear"
                                    class="btn bg-white d-flex align-items-center gap-3 justify-content-center"
                                    style="min-width: auto"><img src="{{ asset('images/admin-menu-icons/order-list.svg') }}"
                                        class="svg" height="20" width="20" /> Order List
                                </button>

                                <button type="button"
                                    class="btn btn-site-theme text-black d-flex align-items-center gap-3 justify-content-center"
                                    style="min-width: auto">
                                    <img src="{{ asset('images/admin-menu-icons/map.svg') }}" class="svg" height="20"
                                        width="20" /> Map
                                </button>

                                <a href="{{ route('create-order') }}"
                                    class="btn bg-white text-black d-flex align-items-center gap-3 justify-content-center"
                                    style="min-width: auto">
                                    <img src="{{ asset('images/create-order.svg') }}" width="16" class="svg"  />
                                    <img src="{{ asset('images/create-order-white.svg') }}" width="16" class="svg d-none" />
                                    {{ trans('rest.food_order.create_order') }}</a>

                                </a>
                            </div>
                            <div class="btn-grp btn-grp-gap-10 d-flex align-items-center flex-wrap radio-btn-group"
                                id="order-dilters">


                                <div class="order-radio-group">
                                    <div class="radio-col">
                                        <div class="radio-container order-type-label">
                                            <input type="checkbox" class="checkbox-round" id="new" name="new" value="new" checked>
                                            <span class="radio-label">New</span>
                                        </div>
                                    </div>
                                    <div class="radio-col">
                                        <div class="radio-container order-type-label">
                                            <input type="checkbox" class="checkbox-round" id="in_kitchen" name="in_kitchen" value="in_kitchen">
                                            <span class="radio-label">In kitchen</span>
                                        </div>
                                    </div>
                                    <div class="radio-col">
                                        <div class="radio-container order-type-label">
                                            <input type="checkbox" class="checkbox-round" id="delivery" name="delivery" value="delivery">
                                            <span class="radio-label">Delivery</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="header-filter-order d-flex align-items-center flex-wrap  d-none">

                                    <div class="drop_with_search">
                                        <div class="select-options">
                                            <select class="form-control" id="order-tabs-dropdown">
                                                <option value="all" selected>{{ trans('rest.sidebar.all') }}
                                                </option>
                                                <option value="name">{{ trans('rest.food_order.name') }}</option>
                                                <option value="phone_number">{{ trans('rest.food_order.phone_number') }}
                                                </option>
                                                <option value="order_number">{{ trans('rest.food_order.order_number') }}
                                                </option>
                                                <option value="address">{{ trans('rest.food_order.address') }}</option>
                                                <option value="zip_code">{{ trans('rest.food_order.zip_code') }}</option>
                                                <option value="dish">{{ trans('rest.food_order.dish') }}</option>
                                            </select>
                                        </div>
                                        <div class="search-has col order-filters-search">
                                            <span class="fa fa-search form-control-feedback"></span>
                                            <input type="text" class="form-control" id="search-order-new"
                                                value="{{ request()->query('search', '') }}" placeholder="Search">
                                        </div>
                                    </div>
                                    <div class="dropdown custom-dropdown customer-dropdown">
                                        <span class="count count-filter d-none"> </span>
                                        <button class="form-control dropdown-toggle" type="button" id="dropdownMenuButton"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            {{ trans('rest.food_order.filter_orders') }}
                                        </button>
                                        <div class="dropdown-menu order-filter  dropdown-menu-end"
                                            aria-labelledby="dropdownMenuButton">

                                            <h3 class="title-hr">Order Type</h3>
                                            <div class="options">
                                                <div class="order-type-group">
                                                    <div class="clearfix">
                                                        <input type="checkbox" id="delivery"
                                                            class="order-type-input order-type-delivery-input"
                                                            name="delivery" />
                                                        <label for="order-type-delivery"
                                                            class="order-type-label order-type-delivery-label">Delivery</label>
                                                    </div>
                                                    <div class="clearfix">
                                                        <input type="checkbox" id="takeaway"
                                                            class="order-type-input order-type-delivery-input"
                                                            name="take_away" />
                                                        <label for="order-type-delivery"
                                                            class="order-type-label order-type-delivery-label">Take
                                                            Away</label>
                                                    </div>

                                                </div>
                                            </div>

                                            <h3 class="title-hr">Order received from</h3>
                                            <div class="options">
                                                <div class="order-type-group">
                                                    <div class="clearfix">
                                                        <input type="checkbox" id="online"
                                                            class="order-type-input order-type-delivery-input"
                                                            name="website" />
                                                        <label for="order-type-delivery"
                                                            class="order-type-label order-type-delivery-label">Website</label>
                                                    </div>

                                                    <div class="clearfix">
                                                        <input type="checkbox" id="manual"
                                                            class="order-type-input order-type-delivery-input"
                                                            name="manual" />
                                                        <label for="order-type-delivery"
                                                            class="order-type-label order-type-delivery-label">Manual</label>
                                                    </div>

                                                    <div class="clearfix">
                                                        <input type="checkbox" id="takeaway_com"
                                                            class="order-type-input order-type-takeaway-input"
                                                            name="takeaway_com" />
                                                        <label for="order-type-takeaway"
                                                            class="order-type-label order-type-takeaway-label">Takeaway.com</label>
                                                    </div>

                                                    <div class="clearfix">
                                                        <input type="checkbox" id="uber_eats"
                                                            class="order-type-input order-type-takeaway-input"
                                                            name="uber_eats" />
                                                        <label for="order-type-takeaway"
                                                            class="order-type-label order-type-takeaway-label">UberEats</label>
                                                    </div>

                                                </div>
                                            </div>

                                            <h3 class="title-hr">Payment</h3>
                                            <div class="options">
                                                <div class="order-type-group">
                                                    <div class="clearfix">
                                                        <input type="checkbox" id="paid"
                                                            class="order-type-input order-type-delivery-input"
                                                            name="paid" />
                                                        <label for="order-type-delivery"
                                                            class="order-type-label order-type-delivery-label">Paid</label>
                                                    </div>
                                                    <div class="clearfix">
                                                        <input type="checkbox" id="cash"
                                                            class="order-type-input order-type-takeaway-input"
                                                            name="cash" />
                                                        <label for="order-type-takeaway"
                                                            class="order-type-label order-type-takeaway-label">Cash</label>
                                                    </div>

                                                </div>
                                            </div>

                                            <h3 class="title-hr">Order Status</h3>
                                            <div class="options">
                                                <div class="order-type-group">
                                                    <div class="clearfix">
                                                        <input type="checkbox" id="open"
                                                            class="order-type-input order-type-delivery-input"
                                                            name="new_order" />
                                                        <label for="order-type-delivery"
                                                            class="order-type-label order-type-delivery-label">New
                                                            Order</label>
                                                    </div>

                                                    <div class="clearfix">
                                                        <input type="checkbox" id="in_kitchen"
                                                            class="order-type-input order-type-takeaway-input"
                                                            name="in_kitchen" />
                                                        <label for="order-type-takeaway"
                                                            class="order-type-label order-type-takeaway-label">In
                                                            Kitchen</label>
                                                    </div>

                                                    <div class="clearfix">
                                                        <input type="checkbox" id="ready_delivery"
                                                            class="order-type-input order-type-takeaway-input"
                                                            name="ready_delivery" />
                                                        <label for="order-type-takeaway"
                                                            class="order-type-label order-type-takeaway-label">Ready |
                                                            Delivery</label>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                {{-- <a href="{{ route('create-order') }}" class="btn btn-site-theme create-order-manual">
                                    <span>{{ trans('rest.food_order.create_order') }}</span>
                                </a> --}}

                                <button type="button"
                                    class="btn bg-white text-black d-flex align-items-center gap-3 justify-content-center order-setting  d-none"
                                    style="min-width: auto">
                                    <img src="{{ asset('images/admin-menu-icons/header-settings.svg') }}" class="svg"
                                        height="20" width="20" /> {{ trans('rest.food_order.settings') }}</button>

                            </div>
                        </div>
                        <div class="row map-order-listing-row">
                            <div class="col-md-8">
                                <div id="orders-map-marker"
                                    style="height: calc(100vh - 177px);border-radius: 16px;overflow: hidden;"></div>
                            </div>
                            <div class="orderList orderList-col col-md-4">
                                <div class="order-listing-container">
                                    <div class="order-row">
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
                                                        <label
                                                            class="success cursor-pointer">{{ $ord->delivery_time }}</label>
                                                    </div>

                                                    <div class="details">
                                                        <div class="left">
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
                                                                    class="svg" height="16" width="16" />
                                                            @endif
                                                            @if ($ord->payment_type == \App\Enums\PaymentType::Card)
                                                                <img src="{{ asset('images/purse.svg') }}" class="svg"
                                                                    height="20" width="20" />
                                                            @endif
                                                            @if ($ord->payment_type == \App\Enums\PaymentType::Ideal)
                                                                <img src="{{ asset('images/paid-deal.svg') }}"
                                                                    class="svg" height="20" width="20" />
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

                                <div class="d-flex justify-content-end align-items-center pt-1 order-pagination">
                                    <!-- Pagination -->
                                    <nav aria-label="Page navigation example">
                                        {{ $allOrders->links() }}
                                    </nav>

                                    <!-- Filter buttons -->
                                    <div class="filter-btn-group d-none">
                                        <button type="button" class="btn">
                                            <img src="{{ asset(path: 'images/map-white.svg') }}" alt="Bike" />
                                        </button>

                                        <button type="button" class="btn order-setting">
                                            <img src="{{ asset(path: 'images/setting-white.svg') }}" alt="Bike" />
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <!-- start footer -->
        {{--    @include('admin.orders.order-detail-popup') --}}
        {{--        <div class="modal fade custom-modal order-detail-popup" id="orderDetailModal" tabindex="-1" --}}
        {{--            aria-labelledby="orderDetailModal" aria-hidden="true"> --}}
        {{--        </div> --}}
        @include('admin.orders.order-setting-popup')
        @include('layouts.admin.footer_design')
        @include('admin.modals.change-order-status')
        <!-- end footer -->
    </div>
@endsection
@section('script')
    <script type="text/javascript" src="{{ asset('js/orders-map.js') }}"></script>
    <script
        src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_place_key') }}&callback=initOrderMapMarker"
        async defer></script>
    <script>
        let map;

        // Pass the PHP orders data to JavaScript
        var orders = @json($allOpenOrder);

        // Initialize the Google Map
        function initOrderMapMarker() {
            // Create the map centered at the first location
            map = new google.maps.Map(document.getElementById('orders-map-marker'), {
                center: {
                    lat: 51.8891026,
                    lng: 4.4767527
                },
                zoom: 10,
                mapTypeControl: false,
                styles: [{
                        featureType: "poi",
                        elementType: "labels",
                        stylers: [{
                            visibility: "off"
                        }] // Hide points of interest
                    },
                    {
                        featureType: "transit.station",
                        stylers: [{
                            visibility: "off"
                        }] // Hide transit stations
                    }
                ]
            });

            // Define custom marker icon (you can replace the URL with your custom icon image URL)
            const customIcon = {
                url: "{!! asset('images/mapIcon.svg') !!}", // Replace with your own icon URL
                scaledSize: new google.maps.Size(40, 40), // Scales the icon
                origin: new google.maps.Point(0, 0), // The origin point (top-left)
                anchor: new google.maps.Point(20, 40) // The anchor point (where the icon is anchored to the map)
            };

            orders.forEach(order => {
                if (order.order_user_details.latitude && order.order_user_details.longitude) {
                    const marker = new google.maps.Marker({
                        position: {
                            lat: parseFloat(order.order_user_details.latitude),
                            lng: parseFloat(order.order_user_details.longitude)
                        }, // Location from the order data
                        map: map,
                        icon: customIcon // Set the custom icon here
                    });
                    marker.addListener('click', function() {
                        // Call the orderDetailNew function with the order ID when clicked
                        orderDetailNew(order.id);
                    });
                }
            });
        }
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
                    var currentColumn = $('<div class="order-column mt-2"></div>'); // Create a new column
                    if (col === 0) {
                        currentColumn = $('<div class="order-column"></div>'); // Create a new column
                    }
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
    </script>
@endsection
