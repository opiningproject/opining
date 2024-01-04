@extends('layouts.user-app')

@section('content')

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
                            <div class="orders-list py-3 px-1">
                                <div class="orders-item d-flex align-items-center justify-content-between gap-2">
                                    <div class="text-grp">
                                        <div class="title">Order #1</div>
                                        <div class="text">June 1, 2020, 08:22 AM</div>
                                    </div>
                                    <div class="price"><span>€</span>202.00</div>
                                    <button class="border-none outline-none">
                                        <img src="images/chevron-down.svg" class="img-fluid" alt=""
                                        width="32" height="32">
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="orders-type">
                            <div class="orders-title">Orders overview</div>
                            <div class="orders-list py-3 px-1">
                                <div class="orders-item d-flex align-items-center justify-content-between gap-2">
                                    <div class="text-grp">
                                        <div class="title">Order #1</div>
                                        <div class="text">June 1, 2020, 08:22 AM</div>
                                    </div>
                                    <div class="price"><span>€</span>202.00</div>
                                    <button class="border-none outline-none">
                                        <img src="images/chevron-down.svg" class="img-fluid" alt=""
                                        width="32" height="32">
                                    </button>
                                </div>
                                <div class="orders-item d-flex align-items-center justify-content-between gap-2">
                                    <div class="text-grp">
                                        <div class="title">Order #2</div>
                                        <div class="text">June 1, 2020, 08:22 AM</div>
                                    </div>
                                    <div class="price"><span>€</span>202.00</div>
                                    <button class="border-none outline-none">
                                        <img src="images/chevron-down.svg" class="img-fluid" alt=""
                                        width="32" height="32">
                                    </button>
                                </div>
                                <div class="orders-item d-flex align-items-center justify-content-between gap-2">
                                    <div class="text-grp">
                                        <div class="title">Order #3</div>
                                        <div class="text">June 1, 2020, 08:22 AM</div>
                                    </div>
                                    <div class="price"><span>€</span>202.00</div>
                                    <button class="border-none outline-none">
                                        <img src="images/chevron-down.svg" class="img-fluid" alt=""
                                        width="32" height="32">
                                    </button>
                                </div>
                                <div class="orders-item d-flex align-items-center justify-content-between gap-2">
                                    <div class="text-grp">
                                        <div class="title">Order #4</div>
                                        <div class="text">June 1, 2020, 08:22 AM</div>
                                    </div>
                                    <div class="price"><span>€</span>202.00</div>
                                    <button class="border-none outline-none">
                                        <img src="images/chevron-down.svg" class="img-fluid" alt=""
                                        width="32" height="32">
                                    </button>
                                </div>
                                <div class="orders-item d-flex align-items-center justify-content-between gap-2">
                                    <div class="text-grp">
                                        <div class="title">Order #5</div>
                                        <div class="text">June 1, 2020, 08:22 AM</div>
                                    </div>
                                    <div class="price"><span>€</span>202.00</div>
                                    <button class="border-none outline-none">
                                        <img src="images/chevron-down.svg" class="img-fluid" alt=""
                                        width="32" height="32">
                                    </button>
                                </div>
                                <div class="orders-item d-flex align-items-center justify-content-between gap-2">
                                    <div class="text-grp">
                                        <div class="title">Order #6</div>
                                        <div class="text">June 1, 2020, 08:22 AM</div>
                                    </div>
                                    <div class="price"><span>€</span>202.00</div>
                                    <button class="border-none outline-none">
                                        <img src="images/chevron-down.svg" class="img-fluid" alt=""
                                        width="32" height="32">
                                    </button>
                                </div>
                                <div class="orders-item d-flex align-items-center justify-content-between gap-2">
                                    <div class="text-grp">
                                        <div class="title">Order #7</div>
                                        <div class="text">June 1, 2020, 08:22 AM</div>
                                    </div>
                                    <div class="price"><span>€</span>202.00</div>
                                    <button class="border-none outline-none">
                                        <img src="images/chevron-down.svg" class="img-fluid" alt=""
                                        width="32" height="32">
                                    </button>
                                </div>
                                <div class="orders-item d-flex align-items-center justify-content-between gap-2">
                                    <div class="text-grp">
                                        <div class="title">Order #8</div>
                                        <div class="text">June 1, 2020, 08:22 AM</div>
                                    </div>
                                    <div class="price"><span>€</span>202.00</div>
                                    <button class="border-none outline-none">
                                        <img src="images/chevron-down.svg" class="img-fluid" alt=""
                                        width="32" height="32">
                                    </button>
                                </div>
                                <div class="orders-item d-flex align-items-center justify-content-between gap-2">
                                    <div class="text-grp">
                                        <div class="title">Order #9</div>
                                        <div class="text">June 1, 2020, 08:22 AM</div>
                                    </div>
                                    <div class="price"><span>€</span>202.00</div>
                                    <button class="border-none outline-none">
                                        <img src="images/chevron-down.svg" class="img-fluid" alt=""
                                        width="32" height="32">
                                    </button>
                                </div>
                                <div class="orders-item d-flex align-items-center justify-content-between gap-2">
                                    <div class="text-grp">
                                        <div class="title">Order #10</div>
                                        <div class="text">June 1, 2020, 08:22 AM</div>
                                    </div>
                                    <div class="price"><span>€</span>202.00</div>
                                    <button class="border-none outline-none">
                                        <img src="images/chevron-down.svg" class="img-fluid" alt=""
                                        width="32" height="32">
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="ordersdetails">
                        <!-- with two button -->
                        <div class="ordersdetails-header d-flex justify-content-between align-items-center">
                            <div class="ordersdetails-title">Order Details</div>
                            <div class="btn-grp d-flex flex-wrap">
                                <button>
                                    <img src="images/trackorder-icon.svg" class="img-fluid" alt=""
                                        width="34">
                                    Track order
                                </button>
                                <button>
                                    <img src="images/needhelp-icon.svg" class="img-fluid" alt=""
                                        width="27">
                                    Need help
                                </button>
                            </div>
                        </div>
                        <!-- with one button -->
                        <!-- <div class="ordersdetails-header d-flex justify-content-between align-items-center">
                            <div class="ordersdetails-title">Order Details</div>
                            <div class="btn-grp d-flex flex-wrap">
                                <button>
                                    <img src="images/needhelp-icon.svg" class="img-fluid" alt=""
                                        width="27">
                                    Need help
                                </button>
                            </div>
                        </div> -->
                        <div class="orderdetails-main">
                            <div class="orderdetails-maintop d-flex justify-content-between gap-2 gap-sm-3 flex-wrap align-items-center">
                                <div class="textgrp d-flex flex-column gap-1 gap-sm-3" >
                                    <div class="title">Order #1</div>
                                    <div class="text">June 1, 2020, 08:22 AM</div>
                                </div>
                                <!-- order accepted btn -->
                                <button class="border-none outline-none">
                                    <img src="images/order-accepted.svg" class="img-fluid" alt=""
                                        width="20">
                                        Order Accepted
                                </button>

                                <!-- order in kitchen btn -->
                                <!-- <button class="border-none outline-none">
                                    <img src="images/orderinkitchen-icon.svg" class="img-fluid" alt=""
                                        width="20">
                                        Order in a kitchen
                                </button> -->

                                <!-- ready to pickup -->
                                <!-- <button class="border-none outline-none">
                                    <img src="images/readytopickup-icon.svg" class="img-fluid" alt=""
                                        width="20">
                                        ready for pickup
                                </button>  -->

                                <!-- Out For Delivery  -->
                                <!-- <button class="border-none outline-none">
                                    <img src="images/outfordelivery-icon.svg" class="img-fluid" alt=""
                                        width="20">
                                        Out For Delivery
                                </button> -->

                                <!-- delivered  -->
                                <!-- <button class="border-none outline-none">
                                    <img src="images/delivered-icon.svg" class="img-fluid" alt=""
                                        width="20">
                                        Delivered
                                </button> -->

                                 <!-- order delivered  -->
                                <!-- <button class="border-none outline-none">
                                    <img src="images/delivered-icon.svg" class="img-fluid" alt=""
                                        width="20">
                                        order delivered
                                </button> -->
                            </div>
                            <div class="orderdetails-address d-flex justify-content-between flex-wrap gap-3">
                                <div class="textgrp">
                                    <div class="title">Order for</div>
                                    <div class="text">
                                        Delivery
                                    </div>
                                </div>

                                <!-- Delivery Address -->
                                <div class="textgrp">
                                    <div class="title">Delivery Address</div>
                                    <div class="text">
                                        <img src="images/location-yellowicon.svg" class="img-fluid" alt=""
                                        width="12">
                                        Tochtstraat 40,
                                    </div>
                                </div>

                                <!-- Restaurant Address -->
                                <!-- <div class="textgrp">
                                    <div class="title">Restaurant Address</div>
                                    <div class="text">
                                        <img src="images/house-icon.svg" class="img-fluid" alt=""
                                        width="12">
                                        ABC 5562, New York
                                    </div>
                                </div> -->
                                <div class="textgrp">
                                    <div class="title">Payment</div>
                                    <div class="text">
                                        Ideal
                                    </div>
                                </div>
                                <div class="textgrp">
                                    <div class="title">Payment Status</div>
                                    <div class="text">
                                        Completed
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
                                    <img src="images/download-icon.svg" class="img-fluid" alt=""
                                        width="14">
                                    <div class="text-truncate">
                                    Download invoice
                                    </div>
                                </a>
                                <a href="javascript:void(0);" class="customize-foodlink button" data-bs-toggle="modal" data-bs-target="#refundModal">
                                    <img src="images/refund-icon.svg" class="img-fluid" alt=""
                                        width="16">
                                    <div class="text-truncate">
                                        Refund request submitted
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
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

