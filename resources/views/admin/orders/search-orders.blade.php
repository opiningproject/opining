<?php

use App\Enums\OrderStatus;
use App\Enums\OrderType;
use App\Enums\PaymentType;

?>

@if (count($orders))
    <div class="order-listing-container">
        <div class="order-row">
            @foreach ($orders as $key => $ord)
                <?php $userDetails = $ord->orderUserDetails; ?>

                <div class="order-col cursor-pointer" id="order-{{ $ord->id }}" data-id="{{ $ord->id }}" onclick="orderDetailNew({{ $ord->id }})">
                    <div class="order-box">
                        <div class="timing">
                            <h3 class="expectedDeliveryTime-{{ $ord->id }}">
                                {{ $ord->expected_delivery_time ? date('H:i', strtotime($ord->expected_delivery_time)) : date('H:i', strtotime(\Carbon\Carbon::parse($ord->created_at)->addMinutes($orderDeliveryTime))) }}
                            </h3>
{{--                            @if ($ord->delivery_time != 'ASAP')--}}
                                <label class="success cursor-pointer">{{ $ord->delivery_time }}</label>
{{--                            @endif--}}
                            </div>

                        <div class="details">
                            <div class="left">
                                <div class="label-icon">
                                    <img src="{{ asset('images/opening-label.svg') }}"
                                         class="svg" />
                                </div>
                                <div class="text-label">
                                    <h4>{{ $userDetails ? $userDetails->order_name : 'no name' }}</h4>
                                    @if ($ord->order_type == OrderType::Delivery)
                                        <p class="mb-0">
                                            <?php
                                            echo $userDetails->house_no . ', ' . $userDetails->street_name;
                                            ?>
                                        </p>
                                        {{--                                @else--}}
                                        {{--                                    <p class="mb-0">--}}
                                        {{--                                        {{ getRestaurantDetail()->rest_address }}--}}
                                        {{--                                    </p>--}}
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="actions">
                            <h5 class="mb-0 price_status">
                                <b>€{{ number_format($ord->total_amount, 2) }}</b>
                                @if ($ord->payment_type == \App\Enums\PaymentType::Cash)
                                    <img src="{{ asset('images/cod_icon.png') }}" class="svg" height="20"
                                        width="20" />
                                @endif
                                @if ($ord->payment_type == \App\Enums\PaymentType::Card)
                                    <img src="{{ asset('images/purse.svg') }}" class="svg" height="20"
                                        width="20" />
                                @endif
                                @if ($ord->payment_type == \App\Enums\PaymentType::Ideal)
                                    <img src="{{ asset('images/paid-deal.svg') }}" class="svg" height="20"
                                        width="20" />
                                @endif
                            </h5>
                            <button
                                class="orderDetails order-status-{{ $ord->id }} btn {{ orderStatusBox($ord)->color }}"
                                onclick="orderDetailNew({{ $ord->id }})">{{ orderStatusBox($ord)->text }}</button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <input type="hidden" class="numberOfPerPage" value="{{ $perPage }}">
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
                @if ($orders->onFirstPage())
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link">&lsaquo; Back</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $orders->previousPageUrl() }}" rel="prev">&lsaquo; Back</a>
                    </li>
                @endif

            <!-- Pagination Elements -->
                @php
                    $totalPages = $orders->lastPage();
                    $currentPage = $orders->currentPage();
                    $startPage = max(1, $currentPage - 1); // Start 2 pages before the current page
                    $endPage = min($totalPages, $currentPage + 1); // End 2 pages after the current page
                @endphp

            <!-- Always show first page and ... if needed -->
                @if ($startPage > 1)
                    <li class="page-item">
                        <a class="page-link" href="{{ $orders->url(1) }}">1</a>
                    </li>
{{--                    @if ($startPage > 1)--}}
{{--                        <li class="page-item disabled"><span class="page-link">...</span></li>--}}
{{--                    @endif--}}
                @endif

            <!-- Display range of pages -->
                @for ($i = $startPage; $i <= $endPage; $i++)
                    @if ($i == $currentPage)
                        <li class="page-item active"><span class="page-link">{{ $i }}</span></li>
                    @else
                        <li class="page-item">
                            <a class="page-link" href="{{ $orders->url($i) }}">{{ $i }}</a>
                        </li>
                    @endif
                @endfor

            <!-- Always show last page and ... if needed -->
                @if ($endPage < $totalPages)
                    @if ($endPage < $totalPages - 1)
                        <li class="page-item disabled"><span class="page-link">...</span></li>
                    @endif
                    <li class="page-item">
                        <a class="page-link" href="{{ $orders->url($totalPages) }}">{{ $totalPages }}</a>
                    </li>
                @endif

            <!-- Next Page Link -->
                @if ($orders->hasMorePages())
                    <li class="page-item">
                        <a class="page-link" href="{{ $orders->nextPageUrl() }}" rel="next">Next &rsaquo;</a>
                    </li>
                @else
                    <li class="page-item disabled" aria-disabled="true">
                        <span class="page-link">Next &rsaquo;</span>
                    </li>
                @endif
            </ul>
        </nav>

    </div>

@else
    <span class="no-data">{{ trans('rest.food_order.no_order') }}</span>
@endif

<script>
    $(document).ready(function() {
        let numberOfColumn = 8
        if ($('.numberOfPerPage').val() == 18) {
            numberOfColumn = 6
        }
        function arrangeOrderCols() {
            var screenHeight = $(window).height();
            var availableHeight = screenHeight - 230; // Space for margins, headers, etc.
            var columnGap = 10; // Space between columns and between items

            // Determine the maximum number of items per column dynamically based on screen height
            var maxItemsPerColumn = screenHeight > 1079 ?
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
