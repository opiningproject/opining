@extends('layouts.user-app')

@section('content')
<?php 
use App\Enums\OrderStatus; 
use App\Enums\OrderType; 
use App\Enums\PaymentStatus; 
use App\Enums\PaymentType; 
?>
 <div class="main">
   <div class="main-view">
     <div class="container-fluid bd-gutter bd-layout">
       @include('layouts.user.side_nav_bar')
        <main class="bd-main order-1">
            <div class="main-content">
                <div class="section-page-title main-page-title row justify-content-between d-none d-sm-block">
                    <div class="col-xxl-6 col-xl-6 col-lg-5 col-md-6 col-sm-6 col-12">
                        <h1 class="page-title">My Orders</h1>
                    </div>
                </div>
                <div class="d-flex orders-main">
                    <div class="orders">
                        <div class="active orders-type">
                            <div class="orders-title">Active orders</div>
                            @if(count($active_orders))
                            <div class="orders-list py-3 px-1">
                                @foreach($active_orders as $key => $order)
                                <div class="orders-item d-flex align-items-center justify-content-between gap-2">
                                    <div class="text-grp">
                                        <div class="title">Order #{{ $order->id }}</div>
                                        <div class="text">{{ $order->created_at }}</div>
                                    </div>
                                    <div class="price"><span>€</span>{{ $order->total_amount}}</div>
                                    <button class="border-none outline-none">
                                        <img src="{{ asset('images/chevron-down.svg') }}" class="img-fluid svg" alt="" width="32" height="32">
                                    </button>
                                </div>
                                @endforeach
                            </div>
                            @else
                            <span class="no-data">No orders</span>
                            @endif
                        </div>

                        @if(count($orders))
                        <div class="orders-type">
                            <div class="orders-title">Orders overview</div>
                            <div class="orders-list py-3 px-1">
                                @foreach($orders as $key => $order)
                                <div class="orders-item d-flex align-items-center justify-content-between gap-2">
                                    <div class="text-grp">
                                        <div class="title">Order #{{ $order->id }}</div>
                                        <div class="text">{{ $order->created_at }}</div>
                                    </div>
                                    <div class="price"><span>€</span>{{ $order->total_amount}}</div>
                                    <button class="border-none outline-none">
                                        <img src="{{ asset('images/chevron-down.svg') }}" class="img-fluid svg" alt="" width="32" height="32">
                                    </button>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                    </div>
                    @if(!empty($order_detail))
                    <div class="ordersdetails">
                        <!-- with two button -->
                        <div class="ordersdetails-header d-flex justify-content-between align-items-center">
                            <div class="ordersdetails-title">Order Details</div>
                            <div class="btn-grp d-flex flex-wrap">
                                <button onclick="location.href='{{ route('user.order-location') }}'">
                                    <img src="{{ asset('images/trackorder-icon.svg') }}" class="img-fluid svg" alt="" width="35" height="32"> Track order
                                </button>
                                
                                <button onclick="location.href='{{ route('user.chat') }}'">
                                    <img src="{{ asset('images/needhelp-icon.svg') }}" class="img-fluid svg" alt="" width="27" height="25">Need help
                                </button>
                            </div>
                        </div>

                        <div class="orderdetails-main">
                            <div class="orderdetails-maintop d-flex justify-content-between gap-2 gap-sm-3 flex-wrap align-items-center">
                                <div class="textgrp d-flex flex-column gap-1 gap-sm-3" >
                                    <div class="title">Order #{{ $order_detail->id }}</div>
                                    <div class="text">{{ $order_detail->created_at }}</div>
                                </div>
                                <button class="border-none outline-none">
                                    @if($order_detail->order_status == OrderStatus::Accepted)
                                        <img src="{{ asset('images/order-accepted.svg') }}" class="img-fluid svg" alt="" width="20" height="20"> Order Accepted
                                    @elseif($order_detail->order_status == OrderStatus::InKitchen)
                                        <img src="{{ asset('images/orderinkitchen-icon.svg') }}" class="img-fluid svg" alt="" width="26" height="20">Order in a kitchen
                                    @elseif($order_detail->order_status == OrderStatus::Ready)
                                        <img src="{{ asset('images/readytopickup-icon.svg') }}" class="img-fluid svg" alt="" width="16" height="20">Ready for delivery
                                    @elseif($order_detail->order_status == OrderStatus::ReadyForPickup)
                                        <img src="{{ asset('images/readytopickup-icon.svg') }}" class="img-fluid svg" alt="" width="16" height="20">Ready for pickup
                                    @elseif($order_detail->order_status == OrderStatus::OutForDelivery)
                                        <img src="{{ asset('images/outfordelivery-icon.svg') }}" class="img-fluid svg" alt="" width="31" height="20"> Out For Delivery
                                    @else
                                        <img src="{{ asset('images/delivered-icon.svg') }}" class="img-fluid svg" alt="" width="21" height="20"> Order delivered
                                    @endif
                                </button>
                            </div>
                            <div class="orderdetails-address d-flex justify-content-between flex-wrap gap-3">
                                <div class="textgrp">
                                    <div class="title">Order for</div>
                                    <div class="text">
                                        {{ $order_detail->order_type == OrderType::Delivery ? 'Delivery':'Pickup' }}
                                    </div>
                                </div>

                                @if($order_detail->order_type == OrderType::Delivery)
                                <div class="textgrp">
                                    <div class="title">Delivery Address</div>
                                    <div class="text">
                                        <img src="{{ asset('images/location-yellowicon.svg') }}" class="img-fluid svg" alt="" width="12" height="16">
                                        <?php 
                                            $address = $order_detail->orderUserDetails; 

                                            echo $address->house_no.', '.$address->street_name.', '.$address->city.', '.$address->zipcode;
                                        ?>
                                    </div>
                                </div>
                                @else
                                <div class="textgrp">
                                    <div class="title">Restaurant Address</div>
                                    <div class="text">
                                        <img src="{{ asset('images/house-icon.svg') }}" class="img-fluid svg" alt="" width="18" height="18">{{ getRestaurantDetail()->rest_address }}
                                    </div>
                                </div> 
                                @endif

                                <div class="textgrp">
                                    <div class="title">Payment</div>
                                    <div class="text">
                                        {{ $order_detail->payment_type == PaymentType::Card ? 'Card': ($order_detail->payment_type == PaymentType::Cash ? 'Cash':'Ideal') }}
                                    </div>
                                </div>
                                <div class="textgrp">
                                    <div class="title">Payment Status</div>
                                    <div class="text">
                                        {{ $order_detail->payment_status == PaymentStatus::Pending ? 'Pending': ($order_detail->payment_status == PaymentStatus::Success ? 'Success':'Fail') }}
                                    </div>
                                </div>
                            </div>
                            <div class="orderdetails-desclist">
                                <div class="orderdetails-desc">
                                    <div class="orderdetails-desc-main">
                                        <div class="orderdetails-desc-count">
                                            x1
                                        </div>
                                        <div class="orderdetails-desc-card">
                                            <img src="images/burger-icon.png" class="img-fluid" alt=""
                                            width="85">
                                            <div class="text-grp">
                                                <div class="title">big mac with Cheese</div>
                                                <small>grilled </small>
                                                <div class="text">
                                                    - Ketchup, Crispy veg patty(2x), fresh onion, Cheese, Quarter Pound Bun
                                                    <a href="">Read More</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="orderdetails-desc-note">
                                        <Label>Notes</Label>
                                        <input type="text" placeholder="Lorem Ipsum is simply dummy text of the printing and typesetting industry.">
                                    </div>
                                    <div class="orderdetails-desc-price">
                                        +€20
                                    </div>
                                </div>
                            </div>
                            <div class="orderdetails-bill">
                                <div class="title">Bill Details</div>
                                <div class="list">
                                    <div class="list-item">
                                        <div class="text">Item Total</div>
                                        <div class="number">+€80</div>
                                    </div>
                                    <div class="list-item">
                                        <div class="text">Service</div>
                                        <div class="number">+€01</div>
                                    </div>
                                    <div class="list-item">
                                        <div class="text">Free Delivery (25 mins)</div>
                                        <div class="number">+€00</div>
                                    </div>
                                    <div class="list-item active">
                                        <div class="text">Item Discount</div>
                                        <div class="number">-€01</div>
                                    </div>
                                </div>
                            </div>
                            <div class="orderdetails-total">
                                <div class="list">
                                    <div class="list-item">
                                        <div class="text">Total</div>
                                        <div class="number">€12.59</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="orderdetails-footer">
                            <div class="btn-grp d-flex flex-wrap">
                                <a href="javascript:void(0);" class="customize-foodlink button active" data-bs-toggle="modal" data-bs-target="#refundModal">
                                    <img src="{{ asset('images/download-icon.svg') }}" class="img-fluid svg" alt="" width="14" height="14">
                                    <div class="text-truncate">
                                        Download invoice
                                    </div>
                                </a>
                                <a href="javascript:void(0);" class="customize-foodlink button" data-bs-toggle="modal" data-bs-target="#refundModal">
                                    <img src="{{ asset('images/refund-icon.svg') }}" class="img-fluid svg" alt="" width="18" height="18">
                                    <div class="text-truncate">
                                        Refund request submitted
                                    </div>
                                </a>
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
   @include('layouts.user.footer_design')
   <!-- end footer -->
 </div>

@include('user.modals.refund')

@endsection

