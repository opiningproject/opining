@extends('layouts.app')
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
                <main class="bd-main order-1 w-100 position-relative">
                    <div class="main-content d-flex flex-column h-100">
                        <div
                            class="section-page-title mb-0 d-flex align-items-center justify-content-between gap-2 foodorder-page-title">
                            <h1 class="page-title">{{ trans('rest.food_order.title') }}</h1>
                            <div class="btn-grp d-flex align-items-center flex-wrap">
                                <div class="search-has">
                                    <span class="fa fa-search form-control-feedback"></span>
                                    <input type="text" class="form-control" id="search-order" placeholder="Search">
                                </div>
                                {{-- <button class="btn d-flex align-items-center bg-white" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                    <img src="{{ asset('images/filter-icon.svg') }}" alt="img" class="img-fluid svg"
                                         width="22" height="20">
                                    <div class="text">{{ trans('rest.food_order.filter') }}</div>
                                </button>

                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item"
                                           href="{{ route('orders',['date_filter'=>1]) }}">{{ trans('rest.food_order.today') }}</a>
                                    </li>
                                    <li><a class="dropdown-item"
                                           href="{{ route('orders',['date_filter'=>2]) }}">{{ trans('rest.food_order.week') }}</a>
                                    </li>
                                    <li><a class="dropdown-item"
                                           href="{{ route('orders',['date_filter'=>3]) }}">{{ trans('rest.food_order.month') }}</a>
                                    </li>
                                </ul> --}}
                                <form class="form" action="{{ 'invoice' }}" method="#">
                                    <div class="input-group col-sm-3 col-xs-12 pull-left">
                                        <input type="text" placeholder="Select Date For Filter" class="form-control" id="expiry_date" aria-label="dateofbirth" aria-describedby="basic-addon1" name="expiry_date" required>
                                    </div>
                                </form>
                                {{-- <div> --}}
                                    <button type="button" name="clear" value="Clear" id="clear" class="btn btn-success clear-button">Clear</button>
                                {{-- </div> --}}

                                <div class="dropdown userlogin-dropdown custom-default-dropdown">
                                    <button class="btn btn-light dropdown-toggle" type="button"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                        <img src="{{ getRestaurantDetail()->restaurant_logo }}"
                                             alt="user image" class="img-fluid">
                                        <div class="d-inline-block text-start userdp-text">
                                            <a href="javascript:void(0);"
                                               class="text-yellow-2 d-block">{{ Auth::user()->name }}</a>
                                            <span>{{ Auth::user()->email }}</span>
                                        </div>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="#"
                                               onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                                {{ trans('rest.settings.profile.logout') }}
                                            </a>
                                            <form id="logout-form" action="{{ route('logout') }}"
                                                  method="POST" class="d-none"> @csrf </form>
                                        </li>
                                    </ul>
                                </div>
                                
                            </div>
                        </div>
                        <div class="foodorder-box d-flex">
                            <div class="foodorder-box-list-wrp bg-white">

                                <div class="foodorder-box-list d-flex flex-column" id="order-list-data-div">
                                    @if(count($orders))
                                        @foreach($orders as $key => $ord)
                                            <div
                                                class="{{ $order->id == $ord->id ? 'active':'' }} foodorder-box-list-item d-flex" data-id="{{ $ord->id }}"
                                                onclick="orderDetail({{ $ord->id }})" id="order-{{ $ord->id }}">
                                                <div class="details w-100 d-flex flex-column gap-3">
                                                    <div class="title">{{ trans('rest.food_order.order') }}
                                                        #{{$ord->id}} | {{ $ord->created_at }}</div>
                                                    <div
                                                        class="icontext-grp d-flex align-items-center justify-content-between">
                                                        <div class="icontext-item d-flex align-items-center gap-1">
                                                            <img src="{{ asset('images/fork-knife-icon.svg') }}"
                                                                 class="img-fluid svg" alt="" height="22" width="22">
                                                            <div
                                                                class="text">{{ $ord->order_type == OrderType::Delivery ? trans('rest.food_order.delivery') : trans('rest.food_order.pickup') }} </div>
                                                        </div>
                                                        <div class="icontext-item d-flex align-items-center gap-1">
                                                            <img src="{{ asset('images/hand-money-icon.svg') }}" alt=""
                                                                 class="img-fluid svg" width="30" height="29">
                                                            <div class="text">€{{ number_format($ord->total_amount, 2) }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div
                                                    class="time d-flex flex-column align-items-center justify-content-center text-center gap-1">
                                                    <img src="{{ $ord->order_status >= OrderStatus::Delivered ? asset('images/clock-gray.svg') : asset('images/clock-yellow.svg') }}" alt="time"
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

                            @if(!empty($order))
                                    <?php $userDetails = $order->orderUserDetails; ?>
                                <div class="foodorder-box-details bg-white w-100 d-flex flex-column">
                                    <div
                                        class="footer-box-details-header d-flex align-items-center justify-content-between gap-lg-3 flex-wrap">
                                        <ul class="list-inline text-grp mb-0 p-0 d-flex align-items-center flex-fill">
                                            <li class="list-inline-item d-flex align-items-center">{{ trans('rest.food_order.order') }}
                                                #{{$order->id }}</li>
                                            <li class="list-inline-item d-flex align-items-center">{{ $order->created_at }}</li>
                                        </ul>
                                        <ul class="d-inline-flex flex-wrap gap-3 contact-list mb-0 p-0 justify-content-end">
                                            <li class="list-inline-item">
                                                <a href="#" class="d-flex align-items-center gap-2">
                                                    <img src="{{ asset('images/user-yellow.svg') }}" alt="user"
                                                         class="img-fluid svg" width="17" height="18">
                                                    {{ $userDetails->order_name }}
                                                </a>
                                            </li>
                                            <li class="list-inline-item">
                                                <a href="#" class="d-flex align-items-center gap-2">
                                                    <img src="{{ asset('images/call-yellow.svg') }}" alt="call"
                                                         class="img-fluid svg" width="19" height="19">
                                                    +31 {{ $userDetails->order_contact_number }}
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="footer-box-main">
                                        <div class="footer-box-main-orderdetails d-flex justify-content-between   ">
                                            <div
                                                class="footer-box-main-orderdetails-item d-flex align-items-start gap-2">
                                                <img src="{{ asset('images/location-icon.svg') }}" alt=""
                                                     class="img-fluid svg" width="13" height="18"
                                                     style="margin-top: 1px;">
                                                <div class="text-grp ms-0">
                                                    @if($order->order_type == OrderType::Delivery)
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
                                                        <span>{{ trans('rest.food_order.instruction') }}:</span> {{ $order->delivery_note }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div
                                                class="footer-box-main-orderdetails-item d-flex align-items-start gap-2">
                                                <div class="text-grp">
                                                    <div class="text">
                                                        <span>{{ trans('rest.food_order.delivery_mode') }}: </span>{{ $order->delivery_time }}
                                                    </div>
                                                    <div class="text">
                                                        <span>{{ trans('rest.food_order.payment_method') }}: </span>{{ $order->payment_type == PaymentType::Card ? trans('rest.food_order.card'): ($order->payment_type == PaymentType::Cash ? trans('rest.food_order.cod'):'Ideal') }}
                                                    </div>
                                                    <div class="text">
                                                        <span>{{ trans('rest.food_order.type') }}: </span>{{ $ord->order_type == OrderType::Delivery ? trans('rest.food_order.delivery'):trans('rest.food_order.pickup') }}
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
                                            @if($order->order_status >= OrderStatus::InKitchen)
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

                                            @if($order->order_type == OrderType::Delivery)
                                                    <?php $order_status = trans('rest.order_status.ready'); ?>
                                                @if($order->order_status >= OrderStatus::Ready)
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
                                                @if($order->order_status >= OrderStatus::OutForDelivery)
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
                                                @if($order->order_status >= OrderStatus::Delivered)
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
                                                @if($order->order_status >= OrderStatus::ReadyForPickup)
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
                                                @if($order->order_status >= OrderStatus::Delivered)
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
                                            </div>
                                            <div class="footer-box-main-orderlist-main d-flex flex-column">
                                                    <?php $itemTotalPrice = 0; ?>
                                                @foreach($order->dishDetails as $key => $dish)
                                                    <div class="footer-box-main-orderlist-main-item d-flex">
                                                        <div class="text-grp orderRead-more">
                                                            <div class="title">{{ $dish->dish->name }}</div>
                                                            <div class="text line-clamp-2"
                                                                 id="order-ingredient-{{ $dish->id}}">
                                                                <b class="mb-0 item-options"> {{ $dish->dishOption->name ?? ''}} </b>
                                                                {{ getOrderDishIngredients($dish) }}
                                                            </div>
                                                            <div class="text">
                                                                <a href="javascript:void(0)"
                                                                   id="read-more-{{ $dish->id}}"
                                                                   onclick="readMore({{ $dish->id}})">{{ trans('rest.food_order.read_more') }} </a>
                                                                <a href="javascript:void(0)" style="display:none;"
                                                                   id="close-{{ $dish->id}}"
                                                                   onclick="hideReadMore({{ $dish->id}})">{{ trans('rest.food_order.close') }}</a>
                                                            </div>
                                                        </div>
                                                        @if(!empty($dish->notes))
                                                            <div class="notes">
                                                                <div
                                                                    class="text d-flex align-items-center justify-content-center">{{ trans('rest.food_order.notes') }}</div>
                                                                <input type="text" placeholder="{{ $dish->notes }}"
                                                                       class="input" data-toggle="tooltip"
                                                                       title="{{ $dish->notes }}" readonly>
                                                            </div>
                                                        @endif
                                                        <div class="price d-flex flex-column">
                                                                <?php $itemPrice = ($dish->price * $dish->qty) + $dish->paid_ingredient_total; ?>
                                                            <div class="title">€{{ number_format($itemPrice, 2) }}</div>
                                                            <div class="text">x{{ $dish->qty }}</div>
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
                                                    <div class="number">€{{ number_format(getOrderGrossAmount($order),2) }}</div>
                                                </div>
                                                <button
                                                    class="bg-transparent border-0 d-flex align-items-center justify-content-center">
                                                    <img src="{{ asset('images/upward-arrow.svg') }}" alt="call"
                                                         class="img-fluid svg" width="17" height="10">
                                                </button>
                                            </div>
                                            <div class="footer-main-total-main">
                                                <div class="title">{{ trans('rest.food_order.bill_details') }}</div>
                                                <div class="text-grp d-flex flex-column gap-3">
                                                    <div
                                                        class="text d-flex align-items-center justify-content-between gap-2">
                                                        <div class="key">{{ trans('rest.food_order.item_total') }}</div>
                                                        <div class="value">€{{ number_format(getOrderGrossAmount($order),2) }}</div>
                                                    </div>
                                                    <div
                                                        class="text d-flex align-items-center justify-content-between gap-2">
                                                        <div
                                                            class="key">{{ trans('rest.food_order.service_charge') }}</div>
                                                        <div class="value">€{{ number_format($order->platform_charge,2) }}</div>
                                                    </div>
                                                    <div
                                                        class="text d-flex align-items-center justify-content-between gap-2">
                                                        <div
                                                            class="key">{{ $order->delivery_charge ? trans('rest.food_order.delivery_charge'):trans('rest.food_order.free_delivery') }}</div>
                                                        <div class="value">€{{ number_format($order->delivery_charge,2) }}</div>
                                                    </div>
                                                    <div
                                                        class="active text d-flex align-items-center justify-content-between gap-2">
                                                        <div class="key">{{ trans('rest.food_order.discount') }}</div>
                                                        <div class="value">-€{{ number_format($order->coupon_discount,2) }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="footer-main-total-footer">
                                                <div
                                                    class="text-grp d-flex align-items-center gap-2 justify-content-between">
                                                    <div class="key">{{ trans('rest.food_order.total') }}</div>
                                                    <div class="value">€{{ number_format($order->total_amount, 2) }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="foodorder-box-details-footer d-flex align-items-center justify-content-between gap-2 footer-btn-sticky">
                                        <a class="btn btn-auto"
                                           target="_blank"
                                           href="{{ route('orders.printLabel', ['order_id' => $order->id]) }}">{{ trans('rest.food_order.print') }}</a>

                                            <?php
                                            $order_status_cur_val = $order->order_status;

                                            $order = getOrderStatus($order);
                                            $order_status_key = OrderStatus::getKey($order->order_status);
                                            $order_status = preg_replace('/(?<=\\w)(?=[A-Z])/', " $1", $order_status_key);
                                            ?>

                                        @if($order_status_cur_val != OrderStatus::Delivered)
                                            <button class="btn active btn-auto" class="customize-foodlink button"
                                                    onclick="changeOrderStatus({{ $order->id }},'{{ $order_status }}')">
                                                {{ trans('rest.food_order.move_to') }} '{{ $order_status }}'
                                            </button>
                                        @endif
                                        <input type="hidden" id="id" value="">
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


