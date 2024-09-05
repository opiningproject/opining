@extends('layouts.app')
@section('content')

    <?php

    use App\Enums\OrderStatus;
    use App\Enums\OrderType;
    use App\Enums\PaymentStatus;
    use App\Enums\PaymentType;
    use App\Enums\RefundStatus;

    ?>
    <span class="archive_last_page" style="display: none"> {{ $lastPage }}</span>
    <div class="main">
        <div class="main-view">
            <div class="container-fluid bd-gutter bd-layout">
                @include('layouts.admin.side_nav_bar')
                <main class="bd-main updated_order order-1 w-100 position-relative">
                    <div class="main-content food-order-main-content d-flex flex-column h-100">
                        <div
                            class="section-page-title mb-0 d-flex align-items-center justify-content-end gap-2 foodorder-page-title">
                            <h1 class="page-title me-auto">{{ trans('rest.archive_order.title') }}</h1>
                            <div class="btn-grp btn-grp-gap-10 d-flex align-items-center flex-wrap" id="order-dilters">
                                <div class="header-filter-order d-flex align-items-center flex-wrap">
                                    <div class="search-has col order-filters-search">
                                        <span class="fa fa-search form-control-feedback"></span>
                                        <input type="text" class="form-control" id="archive-search-order" placeholder="Search">
                                    </div>

                                    <form class="form col" action="" method="#">
                                        <div class="input-group order-filters-search">
                                            <input type="text" placeholder="Select Date For Filter" class="form-control"
                                                   id="expiry_date" aria-label="expiry_date" name="expiry_date"
                                                   required>
                                        </div>
                                    </form>
                                </div>
                                <button type="button" name="clear" value="all" id="archive-clear"
                                        style="background-color: var(--theme-yellow2);"
                                        class="btn clear-button order-filters-search">Clear
                                </button>
                            </div>
                        </div>
                        <div class="foodorder-box d-flex">
                            <div class="foodorder-box-list-wrp bg-white foodorder-box-list-top">
                                <div class="customize-tab coupons-tab">
                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade show active" id="all-orders" role="tabpanel"
                                             aria-labelledby="all-orders-tab">
                                            <div
                                                class="foodorder-box-list d-flex flex-column mt-2 order-list-data-div1 archive-all-orders"
                                                id="archive-order-list-data-div1">

                                                @if(count($allOrders))
                                                    @foreach($allOrders as $key => $ord)

                                                        <div
                                                            class="{{ $order->id == $ord->id ? 'active' : '' }} foodorder-box-list-item d-flex order-{{ $ord->id }}"
                                                            onclick="orderDetailArchive({{ $ord->id }})"
                                                            id="order-{{ $ord->id }}" data-id="{{ $ord->id }}">
                                                            <div class="details w-100 d-flex flex-column gap-3">
                                                                <div class="title">{{ trans('rest.food_order.order') }}
                                                                    #{{$ord->id}} | {{ $ord->created_at }}</div>
                                                                <div
                                                                    class="icontext-grp d-flex align-items-center justify-content-between">
                                                                    <div
                                                                        class="icontext-item d-flex align-items-center gap-1">
                                                                        <img
                                                                            src="{{ asset('images/fork-knife-icon.svg') }}"
                                                                            class="img-fluid svg" alt="" height="22"
                                                                            width="22">
                                                                        <div
                                                                            class="text">{{ $ord->order_type == OrderType::Delivery ? trans('rest.food_order.delivery'):trans('rest.food_order.pickup') }} </div>
                                                                    </div>
                                                                    <div
                                                                        class="icontext-item d-flex align-items-center gap-1">
                                                                        <img
                                                                            src="{{ asset('images/hand-money-icon.svg') }}"
                                                                            alt=""
                                                                            class="img-fluid svg" width="30"
                                                                            height="29">
                                                                        <div class="text total_amount">
                                                                            €{{ number_format($ord->total_amount, 2) }}</div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div
                                                                class="time d-flex flex-column align-items-center justify-content-center text-center gap-1 order-status-{{ $ord->id }}">
                                                                <img
                                                                    src="{{ asset('images/clock-gray.svg')}}"
                                                                    alt="time"
                                                                    class="img-fluid svg" width="29" height="29">
                                                                <div class="text">{{ $ord->delivery_time }}</div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <span class="no-data">{{ trans('rest.food_order.no_order') }}</span>
                                                @endif
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                            @if (!empty($order))
                                <?php $userDetails = $order->orderUserDetails; ?>
                                <div class="foodorder-box-details bg-white w-100 d-flex flex-column">
                                    <div
                                        class="footer-box-details-header d-flex align-items-center justify-content-between gap-lg-3 flex-wrap">
                                        <ul class="list-inline text-grp mb-0 p-0 d-flex align-items-center flex-fill">
                                            <li class="list-inline-item d-flex align-items-center">
                                                {{ trans('rest.food_order.order') }}
                                                #{{ $order->id }}</li>
                                            <li class="list-inline-item d-flex align-items-center">{{ $order->created_at }}
                                            </li>
                                        </ul>
                                        <ul class="d-inline-flex flex-wrap gap-3 contact-list mb-0 p-0 justify-content-end">
                                            <li class="list-inline-item">
                                                <a href="#" class="d-flex align-items-center gap-2">
                                                    <img src="{{ asset('images/user-icon-up.svg') }}" alt="user"
                                                         class="img-fluid svg" width="17" height="18">
                                                    {{ $userDetails->order_name }}
                                                </a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="#" class="d-flex align-items-center gap-2">
                                                    <img src="{{ asset('images/call-icon-up.svg') }}" alt="call"
                                                         class="img-fluid svg" width="19" height="19">
                                                    +31 {{ $userDetails->order_contact_number }}
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="footer-box-main archive-footer-box-main">
                                        <div class="footer-box-main-orderdetails d-flex justify-content-between   ">
                                            <div
                                                class="footer-box-main-orderdetails-item d-flex align-items-start gap-2">
                                                <img src="{{ asset('images/location-yellowicon-up.svg') }}" alt=""
                                                     class="img-fluid svg" width="13" height="18"
                                                     style="margin-top: 1px;">
                                                <div class="text-grp ms-0">
                                                    @if ($order->order_type == OrderType::Delivery)
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
                                                        <span>{{ trans('rest.food_order.instruction') }}:</span>
                                                        {{ $order->delivery_note }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div
                                                class="footer-box-main-orderdetails-item d-flex align-items-start gap-2">
                                                <div class="text-grp">
                                                    <div class="text">
                                                        <span>{{ trans('rest.food_order.delivery_mode') }}:
                                                        </span>{{ $order->delivery_time }}
                                                    </div>
                                                    <div class="text">
                                                        <span>{{ trans('rest.food_order.payment_method') }}:
                                                        </span>{{ $order->payment_type == PaymentType::Card ? trans('rest.food_order.card') : ($order->payment_type == PaymentType::Cash ? trans('rest.food_order.cod') : 'Ideal') }}
                                                    </div>
                                                    <div class="text">
                                                        <span>{{ trans('rest.food_order.type') }}:
                                                        </span>{{ $order->order_type == OrderType::Delivery ?    trans('rest.food_order.delivery') : trans('rest.food_order.pickup') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div
                                            class="footer-box-main-progressbar position-relative d-flex align-items-center justify-content-between gap-1">
                                            <div
                                                class="active footer-box-main-progressbar-item d-flex flex-column align-items-center justify-content-center text-center gap-2">
                                                <div
                                                    class="img d-flex align-items-center justify-content-center cursor-pointer">
                                                    <img src="{{ asset('images/order-accept.svg') }}"
                                                         class="img-fluid svg" width="18" height="18">
                                                </div>
                                                <div class="text">{{ trans('rest.order_status.accepted') }}</div>
                                            </div>

                                            <?php $order_status = trans('rest.order_status.in_kitchen'); ?>
                                            @if ($order->order_status >= OrderStatus::InKitchen)
                                                <div
                                                    class="active footer-box-main-progressbar-item d-flex flex-column align-items-center justify-content-center text-center gap-2">
                                                    <div
                                                        class="img d-flex align-items-center justify-content-center cursor-pointer">
                                                        <img src="{{ asset('images/orderinkitchen-black.svg') }}"
                                                             class="img-fluid svg" width="25" height="19">
                                                    </div>
                                                    <div class="text">{{ $order_status }}</div>
                                                </div>
                                            @else
                                                <div
                                                    class="footer-box-main-progressbar-item d-flex flex-column align-items-center justify-content-center text-center gap-2">
                                                    <div
                                                        class="img d-flex align-items-center justify-content-center cursor-pointer">
                                                        <img src="{{ asset('images/orderinkitchen-white.svg') }}"
                                                             class="img-fluid svg" width="25" height="19">
                                                    </div>
                                                    <div class="text">{{ $order_status }}</div>
                                                </div>
                                            @endif

                                            @if ($order->order_type == OrderType::Delivery)
                                                <?php $order_status = trans('rest.order_status.ready'); ?>
                                                @if ($order->order_status >= OrderStatus::Ready)
                                                    <div
                                                        class="active footer-box-main-progressbar-item d-flex flex-column align-items-center justify-content-center text-center gap-2">
                                                        <div
                                                            class="img d-flex align-items-center justify-content-center cursor-pointer">
                                                            <img src="{{ asset('images/pickup-black.svg') }}"
                                                                 class="img-fluid svg" width="19" height="19">
                                                        </div>
                                                        <div class="text">{{ $order_status }}</div>
                                                    </div>
                                                @else
                                                    <div
                                                        class="footer-box-main-progressbar-item d-flex flex-column align-items-center justify-content-center text-center gap-2">
                                                        <div
                                                            class="img d-flex align-items-center justify-content-center cursor-pointer">
                                                            <img src="{{ asset('images/pickup-white.svg') }}"
                                                                 class="img-fluid svg" width="19" height="19">
                                                        </div>
                                                        <div class="text">{{ $order_status }}</div>
                                                    </div>
                                                @endif

                                                <?php $order_status = trans('rest.order_status.out_for_delivery'); ?>
                                                @if ($order->order_status >= OrderStatus::OutForDelivery)
                                                    <div
                                                        class="active footer-box-main-progressbar-item d-flex flex-column align-items-center justify-content-center text-center gap-2">
                                                        <div
                                                            class="img d-flex align-items-center justify-content-center cursor-pointer">
                                                            <img src="{{ asset('images/out-for-delivery-black.svg') }}"
                                                                 class="img-fluid svg" width="27" height="20">
                                                        </div>
                                                        <div class="text">{{ $order_status }}</div>
                                                    </div>
                                                @else
                                                    <div
                                                        class="footer-box-main-progressbar-item d-flex flex-column align-items-center justify-content-center text-center gap-2">
                                                        <div
                                                            class="img d-flex align-items-center justify-content-center cursor-pointer">
                                                            <img src="{{ asset('images/out-for-delivery.svg') }}"
                                                                 class="img-fluid svg" width="27" height="20">
                                                        </div>
                                                        <div class="text">{{ $order_status }}</div>
                                                    </div>
                                                @endif

                                                <?php $order_status = trans('rest.order_status.delivered'); ?>
                                                @if ($order->order_status >= OrderStatus::Delivered)
                                                    <div
                                                        class="active footer-box-main-progressbar-item d-flex flex-column align-items-center justify-content-center text-center gap-2">
                                                        <div
                                                            class="img d-flex align-items-center justify-content-center cursor-pointer">
                                                            <img src="{{ asset('images/order-accept.svg') }}"
                                                                 class="img-fluid svg" width="19" height="19">
                                                        </div>
                                                        <div class="text">{{ $order_status }}</div>
                                                    </div>
                                                @else
                                                    <div
                                                        class="footer-box-main-progressbar-item d-flex flex-column align-items-center justify-content-center text-center gap-2">
                                                        <div
                                                            class="img d-flex align-items-center justify-content-center cursor-pointer">
                                                            <img src="{{ asset('images/delivered.svg') }}"
                                                                 class="img-fluid svg" width="19" height="19">
                                                        </div>
                                                        <div class="text">{{ $order_status }}</div>
                                                    </div>
                                                @endif
                                            @else
                                                <?php $order_status = trans('rest.order_status.ready_for_pickup'); ?>
                                                @if ($order->order_status >= OrderStatus::ReadyForPickup)
                                                    <div
                                                        class="active footer-box-main-progressbar-item d-flex flex-column align-items-center justify-content-center text-center gap-2">
                                                        <div
                                                            class="img d-flex align-items-center justify-content-center cursor-pointer">
                                                            <img src="{{ asset('images/pickup-black.svg') }}"
                                                                 class="img-fluid svg" width="19" height="19">
                                                        </div>
                                                        <div class="text">{{ $order_status }}</div>
                                                    </div>
                                                @else
                                                    <div
                                                        class="footer-box-main-progressbar-item d-flex flex-column align-items-center justify-content-center text-center gap-2">
                                                        <div
                                                            class="img d-flex align-items-center justify-content-center cursor-pointer">
                                                            <img src="{{ asset('images/pickup-white.svg') }}"
                                                                 class="img-fluid svg" width="19" height="19">
                                                        </div>
                                                        <div class="text">{{ $order_status }}</div>
                                                    </div>
                                                @endif

                                                <?php $order_status = trans('rest.order_status.delivered'); ?>
                                                @if ($order->order_status >= OrderStatus::Delivered)
                                                    <div
                                                        class="active footer-box-main-progressbar-item d-flex flex-column align-items-center justify-content-center text-center gap-2">
                                                        <div
                                                            class="img d-flex align-items-center justify-content-center cursor-pointer">
                                                            <img src="{{ asset('images/order-accept.svg') }}"
                                                                 class="img-fluid svg" width="19" height="19">
                                                        </div>
                                                        <div class="text">{{ $order_status }}</div>
                                                    </div>
                                                @else
                                                    <div
                                                        class="footer-box-main-progressbar-item d-flex flex-column align-items-center justify-content-center text-center gap-2">
                                                        <div
                                                            class="img d-flex align-items-center justify-content-center cursor-pointer">
                                                            <img src="{{ asset('images/delivered.svg') }}"
                                                                 class="img-fluid svg" width="19" height="19">
                                                        </div>
                                                        <div class="text">{{ $order_status }}</div>
                                                    </div>
                                                @endif
                                            @endif
                                        </div>
                                        <div class="footer-box-main-orderlist">
                                            <div
                                                class="footer-box-main-orderlist-header d-flex align-items-center justify-content-between">
                                                <div class="text-grp d-flex align-items-center gap-1">
                                                    <div class="title">{{ trans('rest.food_order.order_list') }} :</div>
                                                    <div class="number">({{ count($order->dishDetails) }}
                                                        x {{ trans('rest.food_order.items') }})
                                                    </div>
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
                                            <div class="footer-box-main-orderlist-main d-flex flex-column"
                                                 id="orderList">
                                                <?php $itemTotalPrice = 0; $dishIngredientsTotalAmount = 0;?>
                                                @foreach ($order->dishDetails as $key => $dish)
                                                    <div class="footer-box-main-orderlist-main-item d-flex">
                                                        <div class="text-grp orderRead-more">
                                                            <span>{{ $dish->qty }}x</span>
                                                            <div class="content-for-orders">
                                                                <div class="title">{{ $dish->dish->name }}</div>
                                                                <div class="text clearfix"
                                                                     id="order-ingredient-{{ $dish->id }}">
                                                                    @if(count($dish->orderDishOptionDetails) > 0)
                                                                        <b><span
                                                                                style="font-size: 12px"> Options </span></b>
                                                                        @php
                                                                            /*old code comment on 13-08-2024*/
                                                                            $htmlStringDishOptionCategory = getDishOptionCategoryName($dish->orderDishOptionDetails->pluck('dish_option_id')) ?? '' ;
                                                                            $cleanedDishOptionHtmlString = str_replace(
                                                                                '"',
                                                                                '',
                                                                                $htmlStringDishOptionCategory,
                                                                            );
                                                                            $dishIngredientsTotalAmount = getDishOptionCategoryTotalAmount($dish->orderDishOptionDetails->pluck('dish_option_id'));
                                                                        @endphp
                                                                        <ul class="items-additional mb-2"
                                                                            id="item-ing-desc">
                                                                            {!! $cleanedDishOptionHtmlString !!}
                                                                        </ul>
                                                                    @else
                                                                        @php $dishIngredientsTotalAmount = 0 ;@endphp
                                                                    @endif
                                                                    {{ getOrderDishIngredients($dish) }}
                                                                </div>
                                                            </div>
                                                            @if (!empty($dish->notes))
                                                                <div class="notes">
                                                                    <u>{{ $dish->notes }}</u>
                                                                </div>
                                                            @endif
                                                        </div>

                                                        <div class="price d-flex flex-column">
                                                            <?php $itemPrice = $dish->price * $dish->qty + $dish->paid_ingredient_total + $dishIngredientsTotalAmount; ?>
                                                            <div class="title">€{{ number_format($itemPrice, 2) }}</div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <div class="footer-main-total">
                                            <div
                                                class="footer-main-total-header d-flex align-items-center justify-content-between">
                                                <div class="text-grp d-flex align-items-center gap-2">
                                                    <div class="title">{{ trans('rest.food_order.total') }} :</div>
                                                    <div class="number">
                                                        €{{ number_format(getOrderGrossAmount($order), 2) }}</div>
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
                                                    <div
                                                        class="text d-flex align-items-center justify-content-between gap-2">
                                                        <div class="key">{{ trans('rest.food_order.item_total') }}
                                                        </div>
                                                        <div class="value">
                                                            €{{ number_format(getOrderGrossAmount($order), 2) }}</div>
                                                    </div>
                                                    <div {{ $order->platform_charge > 0 ? '' : 'style=display:none' }}
                                                         class="text d-flex align-items-center justify-content-between gap-2">
                                                        <div class="key">{{ trans('rest.food_order.service_charge') }}
                                                        </div>
                                                        <div class="value">
                                                            €{{ number_format($order->platform_charge, 2) }}</div>
                                                    </div>

                                                    <div
                                                        class="text d-flex align-items-center justify-content-between gap-2"
                                                        style="{{ $order->order_type == '2' ? 'display:none !important;' : '' }}">
                                                        <div
                                                            class="key">{{ $order->delivery_charge ?   trans('user.my_orders.delivery_charges') :  trans('user.my_orders.delivery') }}</div>
                                                        <div
                                                            class="value {{ $order->delivery_charge > 0 ? '' : 'text-green' }}">
                                                            {{ $order->delivery_charge > 0 ? '€'.number_format($order->delivery_charge, 2) : 'FREE' }}
                                                        </div>
                                                    </div>

                                                    <div
                                                        class="active text d-flex align-items-center justify-content-between gap-2">
                                                        <div class="key">{{ trans('rest.food_order.discount') }}</div>
                                                        <div class="value">
                                                            -€{{ number_format($order->coupon_discount, 2) }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="footer-main-total-footer">
                                                <div
                                                    class="text-grp d-flex align-items-center gap-2 justify-content-between">
                                                    <div class="key">{{ trans('rest.food_order.total') }}</div>
                                                    <div class="value">€{{ number_format($order->total_amount, 2) }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <!-- start footer -->
    @include('layouts.admin.footer_design')
    @include('admin.modals.change-order-status')
    <!-- end footer -->
    </div>
