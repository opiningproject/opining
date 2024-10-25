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
    $params = json_decode(getRestaurantDetail()->params, true);
    $displayOrderSetting = $params['display_order_settings'];
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
                                    class="btn btn-site-theme d-flex align-items-center gap-3 justify-content-center"
                                    style="min-width: auto"><img src="{{ asset('images/admin-menu-icons/order-list.svg') }}"
                                        class="svg" height="20" width="20" /> Order List</button>

                                <a href="{{ route('ordersMap') }}"
                                    class="btn bg-white text-black d-flex align-items-center gap-3 justify-content-center"
                                    style="min-width: auto">
                                    <img src="{{ asset('images/admin-menu-icons/map.svg') }}" class="svg" height="20"
                                        width="20" /> Map</a>

                                <a href="{{ route('create-order') }}"
                                    class="btn bg-white text-black d-flex align-items-center gap-3 justify-content-center"
                                    style="min-width: auto">
                                    <img src="{{ asset('images/create-order.svg') }}" width="16" class="svg"  />
                                    <img src="{{ asset('images/create-order-white.svg') }}" width="16" class="svg d-none" />
                                    {{ trans('rest.food_order.create_order') }}</a>

                            </div>
                            <div class="btn-grp btn-grp-gap-10 d-flex align-items-center flex-wrap" id="order-dilters">
                                <div class="header-filter-order d-flex align-items-center flex-wrap">

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
                                        <button class="form-control dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
                                                aria-expanded="true">
                                            {{ trans('rest.food_order.filter_orders') }}
                                        </button>

                                        <div class="dropdown-menu order-filter dropdown-menu-end dropdownMenuButton" aria-labelledby="dropdownMenuButton">


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

                                                    <div class="clearfix">
                                                        <input type="checkbox" id="delivered"
                                                            class="order-type-input order-type-takeaway-input"
                                                            name="delivered" />
                                                        <label for="order-type-takeaway"
                                                            class="order-type-label order-type-takeaway-label">Delivered</label>
                                                    </div>
                                                    <div class="clearfix">
                                                        <input type="checkbox" id="canceled"
                                                            class="order-type-input order-type-takeaway-input"
                                                            name="canceled" />
                                                        <label for="order-type-takeaway"
                                                            class="order-type-label order-type-takeaway-label">Cancelled</label>
                                                    </div>

                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <button type="button"
                                    class="btn bg-white text-black d-flex align-items-center gap-3 justify-content-center order-setting"
                                    style="min-width: auto">
                                    <img src="{{ asset('images/admin-menu-icons/header-settings.svg') }}" class="svg"
                                        height="20" width="20" /> {{ trans('rest.food_order.settings') }}</button>

                            </div>
                        </div>

                        <div class="orderList">
                            <div class="order-listing-container">
                                <div class="order-row">
                                    @foreach ($allOrders as $key => $ord)
                                        <?php $userDetails = $ord->orderUserDetails;
                                        $style = "";
                                            if($displayOrderSetting['display_red_color'] == "1") {
                                                $style = $ord->expected_delivery_time < date('Y-m-d H:i:s') && !in_array($ord->order_status, [6, 7])
                                                    ? 'color: #DA3030 !important;'
                                                    : 'color: #292929;';
                                            }
                                        ?>
                                        <div class="order-col cursor-pointer" id="order-{{ $ord->id }}"
                                            data-id="{{ $ord->id }}" onclick="orderDetailNew({{ $ord->id }})">
                                            <div class="order-box">
                                                <div class="timing">
                                                    @if ($ord->delivery_time == 'ASAP')
                                                        <h3 class="expectedDeliveryTime-{{ $ord->id }}" style="{{ $style }}" >
                                                            {{ $ord->expected_delivery_time ? date('H:i', strtotime($ord->expected_delivery_time)) : date('H:i', strtotime(\Carbon\Carbon::parse($ord->created_at)->addMinutes($orderDeliveryTime))) }}
                                                        </h3>
                                                    @else
                                                        <h3 class="expectedDeliveryTime-{{ $ord->id }}">
                                                            {{ date('H:i', strtotime($ord->delivery_time)) }}
                                                        </h3>
                                                    @endif
                                                    @if ($ord->delivery_time == 'ASAP')
                                                        <label
                                                            class="cursor-pointer success asap-time-{{ $ord->id }}" style="{{ $style }}">{{ $ord->delivery_time }}</label>
                                                    @endif
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
                                                                    echo $userDetails->street_name . ' ' . $userDetails->house_no;
                                                                    ?>
                                                                </p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="actions">
                                                    <h5 class="mb-0 price_status">
                                                        <b style="{{ $ord->payment_type == PaymentType::Cash && $ord->order_status != OrderStatus::Delivered ? 'color: #DA3030; !important;' : 'color: #292929' }}">
                                                            €{{ number_format($ord->total_amount, 2) }}
                                                        </b>
{{--                                                        @if ($ord->payment_type == \App\Enums\PaymentType::Cash)--}}
{{--                                                            <img src="{{ asset('images/cod_icon.png') }}" class="svg"--}}
{{--                                                                height="16" width="16" />--}}
{{--                                                        @endif--}}
{{--                                                        @if ($ord->payment_type == \App\Enums\PaymentType::Card)--}}
{{--                                                            <img src="{{ asset('images/purse.svg') }}" class="svg"--}}
{{--                                                                height="20" width="20" />--}}
{{--                                                        @endif--}}
{{--                                                        @if ($ord->payment_type == \App\Enums\PaymentType::Ideal)--}}
{{--                                                            <img src="{{ asset('images/paid-deal.svg') }}" class="svg"--}}
{{--                                                                height="20" width="20" />--}}
{{--                                                        @endif--}}
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
                            <input type="hidden" class="numberOfPerPage" id="numberOfPerPage" value="{{ $perPage }}">
                            <div class="d-flex justify-content-end align-items-center pt-1 order-pagination">
                                <!-- Rows per page -->
                                <div class="ms-auto d-flex align-items-center custom-pagination orders-new-pagination justify-content-start w-100">
                                    <label class="text-nowrap">{{ trans('rest.button.rows_per_page') }}</label>
                                    <select id="per_page_dropdown" class="form-control bg-white ms-2">
                                        @for ($i = 18; $i <= 27; $i += 3)
                                            <option {{ $perPage == $i ? 'selected' : '' }}
                                                    value="{{ Request::url() . '?per_page=' }}{{ $i }}">
                                                {{ $i }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>

                                <!-- Pagination -->
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination justify-content-center">
                                        <!-- Previous Page Link -->
                                        @if ($allOrders->onFirstPage())
                                            <li class="page-item disabled" aria-disabled="true">
                                                <span class="page-link"><span>&lsaquo;</span> Back</span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $allOrders->previousPageUrl() }}" rel="prev"><span>&lsaquo;</span> Back</a>
                                            </li>
                                        @endif

                                    <!-- Pagination Elements -->
                                        @php
                                            $totalPages = $allOrders->lastPage();
                                            $currentPage = $allOrders->currentPage();
                                            $startPage = max(1, $currentPage - 2); // Start 2 pages before the current page
                                            $endPage = min($totalPages, $currentPage + 2); // End 2 pages after the current page
                                        @endphp

                                    <!-- Always show first page and ... if needed -->
                                        @if ($startPage > 1)
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $allOrders->url(1) }}">1</a>
                                            </li>
                                            @if ($startPage > 1)
                                                <li class="page-item disabled"><span class="page-link">...</span></li>
                                            @endif
                                        @endif

                                    <!-- Display range of pages -->
                                        @for ($i = $startPage; $i <= $endPage; $i++)
                                            @if ($i == $currentPage)
                                                <li class="page-item active"><span class="page-link">{{ $i }}</span></li>
                                            @else
                                                <li class="page-item">
                                                    <a class="page-link" href="{{ $allOrders->url($i) }}">{{ $i }}</a>
                                                </li>
                                            @endif
                                        @endfor

                                    <!-- Always show last page and ... if needed -->
                                        @if ($endPage < $totalPages)
                                            @if ($endPage < $totalPages - 1)
                                                <li class="page-item disabled"><span class="page-link">...</span></li>
                                            @endif
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $allOrders->url($totalPages) }}">{{ $totalPages }}</a>
                                            </li>
                                        @endif

                                    <!-- Next Page Link -->
                                        @if ($allOrders->hasMorePages())
                                            <li class="page-item">
                                                <a class="page-link" href="{{ $allOrders->nextPageUrl() }}" rel="next">Next <span>&rsaquo;</span></a>
                                            </li>
                                        @else
                                            <li class="page-item disabled" aria-disabled="true">
                                                <span class="page-link">Next <span>&rsaquo;</span></span>
                                            </li>
                                        @endif
                                    </ul>
                                </nav>
                            </div>

                        </div>
                    </div>
                </main>
            </div>
        </div>
        <!-- start footer -->
        {{--    @include('admin.orders.order-detail-popup') --}}
        {{-- check on monday --}}
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
    <script type="text/javascript" src="{{ asset('js/new-orders.js') }}"></script>
    <script>
        $(document).ready(function() {
            let numberOfColumn = 8
            if ($('.numberOfPerPage').val() == 18) {
                numberOfColumn = 6
            }
            if ($('.numberOfPerPage').val() == 21) {
                numberOfColumn = 7
            }
            if ($('.numberOfPerPage').val() == 27) {
                numberOfColumn = 9
            }

            function arrangeOrderCols() {
                var screenHeight = $(window).height();
                var availableHeight = screenHeight - 230; // Space for margins, headers, etc.
                var columnGap = 10; // Space between columns and between items

                // Determine the maximum number of items per column dynamically based on screen height
                var maxItemsPerColumn = screenHeight > 5000 ?
                    Math.floor(availableHeight / (76 + columnGap)) :
                    numberOfColumn; // Above 1080px, the number of items per column is dynamic

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
    </script>
@endsection
