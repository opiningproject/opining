@extends('layouts.app')

@section('content')
    <div class="main">
        <div class="main-view">
            <div class="container-fluid bd-gutter bd-layout">
                @include('layouts.admin.side_nav_bar')

                <main class="bd-main order-1 w-100 position-relative">
                    <div class="main-content d-flex flex-column h-100">
                        <div class="section-page-title mb-0 d-flex align-items-center justify-content-between gap-2 foodorder-page-title">
                            <h1 class="page-title">Food Order</h1>
                            <div class="btn-grp d-flex align-items-center flex-wrap">
                                <button class="btn d-flex align-items-center bg-white">
                                    <img src="images/filter-icon.svg" alt="img" class="img-fluid" width="22">
                                    <div class="text">Filter Orders</div>
                                </button>
                            </div>
                        </div>
                        <div class="foodorder-box d-flex">
                            <div class="foodorder-box-list-wrp bg-white">
                                <div class="foodorder-box-list d-flex flex-column">
                                    <div class="foodorder-box-list-item d-flex">
                                        <div class="details w-100 d-flex flex-column gap-3">
                                            <div class="title">Order #1022  |  June 1, 2020, 08:22 AM</div>
                                            <div class="icontext-grp d-flex align-items-center justify-content-between">
                                                <div class="icontext-item d-flex align-items-center gap-1">
                                                    <img class="svg" src="{{ asset('images/fork-knife-icon.png') }}" alt="" height="22" width="22">
                                                    <div class="text">Take-Away</div>
                                                </div>
                                                <div class="icontext-item d-flex align-items-center gap-1">
                                                    <img src="{{ asset('images/hand-money-icon.svg') }}" alt="" class="img-fluid" width="22">
                                                    <div class="text">EUR 12.30</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="time d-flex flex-column align-items-center justify-content-center text-center gap-1">
                                            <img src="{{ asset('images/clock-yellow.svg') }}" alt="time" class="img-fluid" width="29">
                                            <div class="text">ASAP</div>
                                        </div>
                                    </div>
                                    <div class="active foodorder-box-list-item d-flex">
                                        <div class="details w-100 d-flex flex-column gap-3">
                                            <div class="title">Order #1022  |  June 1, 2020, 08:22 AM</div>
                                            <div class="icontext-grp d-flex align-items-center justify-content-between">
                                                <div class="icontext-item d-flex align-items-center gap-1">

                                                    <img src="{{ asset('images/scoter.svg') }}" alt="" class="img-fluid" width="22">
                                                    <div class="text">Take-Away</div>
                                                </div>
                                                <div class="icontext-item d-flex align-items-center gap-1">
                                                    <img src="{{ asset('images/purse.svg') }}" alt="" class="img-fluid" width="22">
                                                    <div class="text">EUR 12.30</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="time d-flex flex-column align-items-center justify-content-center text-center gap-1">
                                            <img src="{{ asset('images/clock-black.svg') }}" alt="time" class="img-fluid" width="29">
                                            <div class="text">ASAP</div>
                                        </div>
                                    </div>
                                    <div class="foodorder-box-list-item d-flex">
                                        <div class="details w-100 d-flex flex-column gap-3">
                                            <div class="title">Order #1022  |  June 1, 2020, 08:22 AM</div>
                                            <div class="icontext-grp d-flex align-items-center justify-content-between">
                                                <div class="icontext-item d-flex align-items-center gap-1">
                                                    <img src="{{ asset('images/fork-knife-icon.png') }}" alt="" class="img-fluid" width="22">
                                                    <div class="text">Take-Away</div>
                                                </div>
                                                <div class="icontext-item d-flex align-items-center gap-1">
                                                    <img src="{{ asset('images/hand-money-icon.svg') }}" alt="" class="img-fluid" width="22">
                                                    <div class="text">EUR 12.30</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="time d-flex flex-column align-items-center justify-content-center text-center gap-1">
                                            <img src="{{ asset('images/clock-yellow.svg') }}" alt="time" class="img-fluid" width="29">
                                            <div class="text">ASAP</div>
                                        </div>
                                    </div>
                                    <div class="foodorder-box-list-item d-flex">
                                        <div class="details w-100 d-flex flex-column gap-3">
                                            <div class="title">Order #1022  |  June 1, 2020, 08:22 AM</div>
                                            <div class="icontext-grp d-flex align-items-center justify-content-between">
                                                <div class="icontext-item d-flex align-items-center gap-1">
                                                    <img src="{{ asset('images/fork-knife-icon.png') }}" alt="" class="img-fluid" width="22">
                                                    <div class="text">Take-Away</div>
                                                </div>
                                                <div class="icontext-item d-flex align-items-center gap-1">
                                                    <img src="{{ asset('images/hand-money-icon.svg') }}" alt="" class="img-fluid" width="22">
                                                    <div class="text">EUR 12.30</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="time d-flex flex-column align-items-center justify-content-center text-center gap-1">
                                            <img src="{{ asset('images/clock-yellow.svg') }}" alt="time" class="img-fluid" width="29">
                                            <div class="text">ASAP</div>
                                        </div>
                                    </div>
                                    <div class="foodorder-box-list-item d-flex">
                                        <div class="details w-100 d-flex flex-column gap-3">
                                            <div class="title">Order #1022  |  June 1, 2020, 08:22 AM</div>
                                            <div class="icontext-grp d-flex align-items-center justify-content-between">
                                                <div class="icontext-item d-flex align-items-center gap-1">
                                                    <img src="{{ asset('images/scoter.svg') }}" alt="" class="img-fluid" width="22">
                                                    <div class="text">Take-Away</div>
                                                </div>
                                                <div class="icontext-item d-flex align-items-center gap-1">
                                                    <img src="{{ asset('images/purse.svg') }}" alt="" class="img-fluid" width="22">
                                                    <div class="text">EUR 12.30</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="time d-flex flex-column align-items-center justify-content-center text-center gap-1">
                                            <img src="{{ asset('images/clock-gray.svg') }}" alt="time" class="img-fluid" width="29">
                                            <div class="text">Delivered</div>
                                        </div>
                                    </div>
                                    <div class="foodorder-box-list-item d-flex">
                                        <div class="details w-100 d-flex flex-column gap-3">
                                            <div class="title">Order #1022  |  June 1, 2020, 08:22 AM</div>
                                            <div class="icontext-grp d-flex align-items-center justify-content-between">
                                                <div class="icontext-item d-flex align-items-center gap-1">
                                                    <img src="{{ asset('images/scoter.svg') }}" alt="" class="img-fluid" width="22">
                                                    <div class="text">Take-Away</div>
                                                </div>
                                                <div class="icontext-item d-flex align-items-center gap-1">
                                                    <img src="images/purse.svg" alt="" class="img-fluid" width="22">
                                                    <div class="text">EUR 12.30</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="time d-flex flex-column align-items-center justify-content-center text-center gap-1">
                                            <img src="{{ asset('images/clock-gray.svg') }}" alt="time" class="img-fluid" width="29">
                                            <div class="text">Delivered</div>
                                        </div>
                                    </div>
                                    <div class="foodorder-box-list-item d-flex">
                                        <div class="details w-100 d-flex flex-column gap-3">
                                            <div class="title">Order #1022  |  June 1, 2020, 08:22 AM</div>
                                            <div class="icontext-grp d-flex align-items-center justify-content-between">
                                                <div class="icontext-item d-flex align-items-center gap-1">
                                                    <img src="{{ asset('images/scoter.svg') }}" alt="" class="img-fluid" width="22">
                                                    <div class="text">Take-Away</div>
                                                </div>
                                                <div class="icontext-item d-flex align-items-center gap-1">
                                                    <img src="{{ asset('images/purse.svg') }}" alt="" class="img-fluid" width="22">
                                                    <div class="text">EUR 12.30</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="time d-flex flex-column align-items-center justify-content-center text-center gap-1">
                                            <img src="{{ asset('images/clock-gray.svg') }}" alt="time" class="img-fluid" width="29">
                                            <div class="text">Delivered</div>
                                        </div>
                                    </div>
                                    <div class="foodorder-box-list-item d-flex">
                                        <div class="details w-100 d-flex flex-column gap-3">
                                            <div class="title">Order #1022  |  June 1, 2020, 08:22 AM</div>
                                            <div class="icontext-grp d-flex align-items-center justify-content-between">
                                                <div class="icontext-item d-flex align-items-center gap-1">
                                                    <img src="{{ asset('images/scoter.svg') }}" alt="" class="img-fluid" width="22">
                                                    <div class="text">Take-Away</div>
                                                </div>
                                                <div class="icontext-item d-flex align-items-center gap-1">
                                                    <img src="{{ asset('images/purse.svg') }}" alt="" class="img-fluid" width="22">
                                                    <div class="text">EUR 12.30</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="time d-flex flex-column align-items-center justify-content-center text-center gap-1">
                                            <img src="{{ asset('images/clock-gray.svg') }}" alt="time" class="img-fluid" width="29">
                                            <div class="text">Delivered</div>
                                        </div>
                                    </div>
                                    <div class="foodorder-box-list-item d-flex">
                                        <div class="details w-100 d-flex flex-column gap-3">
                                            <div class="title">Order #1022  |  June 1, 2020, 08:22 AM</div>
                                            <div class="icontext-grp d-flex align-items-center justify-content-between">
                                                <div class="icontext-item d-flex align-items-center gap-1">
                                                    <img src="{{ asset('images/scoter.svg') }}" alt="" class="img-fluid" width="22">
                                                    <div class="text">Take-Away</div>
                                                </div>
                                                <div class="icontext-item d-flex align-items-center gap-1">
                                                    <img src="{{ asset('images/purse.svg') }}" alt="" class="img-fluid" width="22">
                                                    <div class="text">EUR 12.30</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="time d-flex flex-column align-items-center justify-content-center text-center gap-1">
                                            <img src="{{ asset('images/clock-gray.svg') }}" alt="time" class="img-fluid" width="29">
                                            <div class="text">Delivered</div>
                                        </div>
                                    </div>
                                    <div class="foodorder-box-list-item d-flex">
                                        <div class="details w-100 d-flex flex-column gap-3">
                                            <div class="title">Order #1022  |  June 1, 2020, 08:22 AM</div>
                                            <div class="icontext-grp d-flex align-items-center justify-content-between">
                                                <div class="icontext-item d-flex align-items-center gap-1">
                                                    <img src="{{ asset('images/scoter.svg') }}" alt="" class="img-fluid" width="22">
                                                    <div class="text">Take-Away</div>
                                                </div>
                                                <div class="icontext-item d-flex align-items-center gap-1">
                                                    <img src="{{ asset('images/purse.svg') }}" alt="" class="img-fluid" width="22">
                                                    <div class="text">EUR 12.30</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="time d-flex flex-column align-items-center justify-content-center text-center gap-1">
                                            <img src="{{ asset('images/clock-gray.svg') }}" alt="time" class="img-fluid" width="29">
                                            <div class="text">Delivered</div>
                                        </div>
                                    </div>
                                    <div class="foodorder-box-list-item d-flex">
                                        <div class="details w-100 d-flex flex-column gap-3">
                                            <div class="title">Order #1022  |  June 1, 2020, 08:22 AM</div>
                                            <div class="icontext-grp d-flex align-items-center justify-content-between">
                                                <div class="icontext-item d-flex align-items-center gap-1">
                                                    <img src="{{ asset('images/scoter.svg') }}" alt="" class="img-fluid" width="22">
                                                    <div class="text">Take-Away</div>
                                                </div>
                                                <div class="icontext-item d-flex align-items-center gap-1">
                                                    <img src="{{ asset('images/purse.svg') }}" alt="" class="img-fluid" width="22">
                                                    <div class="text">EUR 12.30</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="time d-flex flex-column align-items-center justify-content-center text-center gap-1">
                                            <img src="{{ asset('images/clock-gray.svg') }}" alt="time" class="img-fluid" width="29">
                                            <div class="text">Delivered</div>
                                        </div>
                                    </div>
                                    <div class="foodorder-box-list-item d-flex">
                                        <div class="details w-100 d-flex flex-column gap-3">
                                            <div class="title">Order #1022  |  June 1, 2020, 08:22 AM</div>
                                            <div class="icontext-grp d-flex align-items-center justify-content-between">
                                                <div class="icontext-item d-flex align-items-center gap-1">
                                                    <img src="{{ asset('images/scoter.svg') }}" alt="" class="img-fluid" width="22">
                                                    <div class="text">Take-Away</div>
                                                </div>
                                                <div class="icontext-item d-flex align-items-center gap-1">
                                                    <img src="{{ asset('images/purse.svg') }}" alt="" class="img-fluid" width="22">
                                                    <div class="text">EUR 12.30</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="time d-flex flex-column align-items-center justify-content-center text-center gap-1">
                                            <img src="{{ asset('images/clock-gray.svg') }}" alt="time" class="img-fluid" width="29">
                                            <div class="text">Delivered</div>
                                        </div>
                                    </div>
                                    <div class="foodorder-box-list-item d-flex">
                                        <div class="details w-100 d-flex flex-column gap-3">
                                            <div class="title">Order #1022  |  June 1, 2020, 08:22 AM</div>
                                            <div class="icontext-grp d-flex align-items-center justify-content-between">
                                                <div class="icontext-item d-flex align-items-center gap-1">
                                                    <img src="{{ asset('images/scoter.svg') }}" alt="" class="img-fluid" width="22">
                                                    <div class="text">Take-Away</div>
                                                </div>
                                                <div class="icontext-item d-flex align-items-center gap-1">
                                                    <img src="{{ asset('images/purse.svg') }}" alt="" class="img-fluid" width="22">
                                                    <div class="text">EUR 12.30</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="time d-flex flex-column align-items-center justify-content-center text-center gap-1">
                                            <img src="{{ asset('images/clock-gray.svg') }}" alt="time" class="img-fluid" width="29">
                                            <div class="text">Delivered</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="foodorder-box-details bg-white w-100 d-flex flex-column">
                                <div class="footer-box-details-header d-flex align-items-center justify-content-between gap-lg-3 flex-wrap">
                                    <ul class="list-inline text-grp mb-0 p-0 d-flex align-items-center flex-fill">
                                        <li class="list-inline-item d-flex align-items-center">Order #1022</li>
                                        <li class="list-inline-item d-flex align-items-center">June 1, 2020, 08:22 AM</li>
                                    </ul>
                                    <ul class="d-inline-flex flex-wrap gap-3 contact-list mb-0 p-0 justify-content-end">
                                        <li class="list-inline-item">
                                            <a href="#" class="d-flex align-items-center gap-2">
                                                <img src="{{ asset('images/user-yellow.svg') }}" alt="user" class="img-fluid" width="18">
                                                Serdar Orman
                                            </a>
                                        </li>
                                        <li class="list-inline-item">
                                            <a href="#" class="d-flex align-items-center gap-2">
                                                <img src="{{ asset('images/call-yellow.svg') }}" alt="call" class="img-fluid" width="18">
                                                +31614522453
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="footer-box-main">
                                    <div class="footer-box-main-orderdetails d-flex justify-content-between   ">
                                        <div class="footer-box-main-orderdetails-item d-flex align-items-start gap-2">
                                            <img src="images/location-icon.svg" alt="" class="img-fluid" width="16" style="margin-top: 1px;">
                                            <div class="text-grp">
                                                <div class="title mb-2">Naaldwijkstraat 29, 3061PG Rotterdam</div>
                                                <div class="text">
                                                    <span>Delivery Instruction:</span> Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt. 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="footer-box-main-orderdetails-item d-flex align-items-start gap-2">
                                            <div class="text-grp">
                                                <div class="text">
                                                    <span>Delivery Mode:</span>
                                                    As Soon As Posible
                                                </div>
                                                <div class="text">
                                                    <span>Payment Method:</span>
                                                    Cash On Delivery
                                                </div>
                                                <div class="text">
                                                    <span>Order Type:</span>
                                                    Take-Away
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="footer-box-main-progressbar position-relative d-flex align-items-center justify-content-between gap-1">
                                        <div class="active footer-box-main-progressbar-item d-flex flex-column align-items-center justify-content-center text-center gap-2">
                                            <div class="img d-flex align-items-center justify-content-center cursor-pointer">
                                                <img src="{{ asset('images/order-accept.svg') }}" alt="call" class="img-fluid" width="18" height="18">
                                            </div>
                                            <div class="text">Order Accepted</div>
                                        </div>
                                        <div class="active footer-box-main-progressbar-item d-flex flex-column align-items-center justify-content-center text-center gap-2">
                                            <div class="img d-flex align-items-center justify-content-center cursor-pointer">
                                                <img src="{{ asset('images/order-accept.svg') }}" alt="call" class="img-fluid" width="25" height="19">
                                                
                                            </div>
                                            <div class="text">In kitchen</div>
                                        </div>
                                        <div class="footer-box-main-progressbar-item d-flex flex-column align-items-center justify-content-center text-center gap-2">
                                            <div class="img d-flex align-items-center justify-content-center cursor-pointer">
                                                <img src="{{ asset('images/out-for-delivery.svg') }}" alt="call" class="img-fluid" width="27" height="20">
                                                
                                            </div>
                                            <div class="text">Out For Delivery</div>
                                        </div>
                                        <div class="footer-box-main-progressbar-item d-flex flex-column align-items-center justify-content-center text-center gap-2">
                                            <div class="img d-flex align-items-center justify-content-center cursor-pointer">

                                                <img src="{{ asset('images/delivered.svg') }}" alt="call" class="img-fluid" width="19" height="19">
                                            </div>
                                            <div class="text">Delivered</div>
                                        </div>
                                    </div>
                                    <div class="footer-box-main-orderlist">
                                        <div class="footer-box-main-orderlist-header d-flex align-items-center justify-content-between">
                                            <div class="text-grp d-flex align-items-center gap-1">
                                                <div class="title">Order List :</div>
                                                <div class="number">(2 x items)</div>
                                            </div>
                                        </div>
                                        <div class="footer-box-main-orderlist-main d-flex flex-column">
                                            <div class="footer-box-main-orderlist-main-item d-flex align-items-center">
                                                <div class="details">
                                                    <div class="title">Cheese Burger</div>
                                                    <div class="text">grilled</div>
                                                    <ul class="mb-0 list">
                                                        <li>Ketchup, Crispy veg patty(2x), fresh onion, Cheese, <a href="">Read More</a></li>
                                                    </ul>
                                                </div>
                                                <div class="notes">
                                                    <div class="text d-flex align-items-center justify-content-center">notes</div>
                                                    <input type="text" placeholder="Lorem Ipsum is simply dummy text of the printing and typesetting industry." class="input">
                                                </div>
                                                <div class="price d-flex flex-column">
                                                    <div class="title">+€5.59</div>
                                                    <div class="text">x1</div>
                                                </div>
                                            </div>
                                            <div class="footer-box-main-orderlist-main-item d-flex align-items-center">
                                                <div class="details">
                                                    <div class="title">Cheese Burger</div>
                                                    <div class="text">grilled</div>
                                                    <ul class="mb-0 list">
                                                        <li>Ketchup, Crispy veg patty(2x), fresh onion, Cheese, <a href="">Read More</a></li>
                                                    </ul>
                                                </div>
                                                <div class="notes">
                                                    <div class="text d-flex align-items-center justify-content-center">notes</div>
                                                    <input type="text" placeholder="Lorem Ipsum is simply dummy text of the printing and typesetting industry." class="input">
                                                </div>
                                                <div class="price d-flex flex-column">
                                                    <div class="title">+€5.59</div>
                                                    <div class="text">x1</div>
                                                </div>
                                            </div>
                                            <div class="footer-box-main-orderlist-main-item d-flex align-items-center">
                                                <div class="details">
                                                    <div class="title">Cheese Burger</div>
                                                    <div class="text">grilled</div>
                                                    <ul class="mb-0 list">
                                                        <li>Ketchup, Crispy veg patty(2x), fresh onion, Cheese, <a href="">Read More</a></li>
                                                    </ul>
                                                </div>
                                                <div class="notes">
                                                    <div class="text d-flex align-items-center justify-content-center">notes</div>
                                                    <input type="text" placeholder="Lorem Ipsum is simply dummy text of the printing and typesetting industry." class="input">
                                                </div>
                                                <div class="price d-flex flex-column">
                                                    <div class="title">+€5.59</div>
                                                    <div class="text">x1</div>
                                                </div>
                                            </div>
                                            <div class="footer-box-main-orderlist-main-item d-flex align-items-center">
                                                <div class="details">
                                                    <div class="title">Cheese Burger</div>
                                                    <div class="text">grilled</div>
                                                    <ul class="mb-0 list">
                                                        <li>Ketchup, Crispy veg patty(2x), fresh onion, Cheese, <a href="">Read More</a></li>
                                                    </ul>
                                                </div>
                                                <div class="notes">
                                                    <div class="text d-flex align-items-center justify-content-center">notes</div>
                                                    <input type="text" placeholder="Lorem Ipsum is simply dummy text of the printing and typesetting industry." class="input">
                                                </div>
                                                <div class="price d-flex flex-column">
                                                    <div class="title">+€5.59</div>
                                                    <div class="text">x1</div>
                                                </div>
                                            </div>
                                            <div class="footer-box-main-orderlist-main-item d-flex align-items-center">
                                                <div class="details">
                                                    <div class="title">Cheese Burger</div>
                                                    <div class="text">grilled</div>
                                                    <ul class="mb-0 list">
                                                        <li>Ketchup, Crispy veg patty(2x), fresh onion, Cheese, <a href="">Read More</a></li>
                                                    </ul>
                                                </div>
                                                <div class="notes">
                                                    <div class="text d-flex align-items-center justify-content-center">notes</div>
                                                    <input type="text" placeholder="Lorem Ipsum is simply dummy text of the printing and typesetting industry." class="input">
                                                </div>
                                                <div class="price d-flex flex-column">
                                                    <div class="title">+€5.59</div>
                                                    <div class="text">x1</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="footer-main-total">
                                        <div class="footer-main-total-header d-flex align-items-center justify-content-between">
                                            <div class="text-grp d-flex align-items-center gap-2">
                                                <div class="title">Total :</div>
                                                <div class="number">€10.20</div>
                                            </div>
                                            <button class="bg-transparent border-0 d-flex align-items-center justify-content-center">
                                                <img src="{{ asset('images/upward-arrow.svg') }}" alt="call" class="img-fluid" width="17" height="10">
                                            </button>
                                        </div>
                                        <div class="footer-main-total-main">
                                            <div class="title">Bill Details</div>
                                            <div class="text-grp d-flex flex-column gap-3">
                                                <div class="text d-flex align-items-center justify-content-between gap-2">
                                                    <div class="key">Item Total</div>
                                                    <div class="value">+€10.20</div>
                                                </div>
                                                <div class="text d-flex align-items-center justify-content-between gap-2">
                                                    <div class="key">Service</div>
                                                    <div class="value">+€01</div>
                                                </div>
                                                <div class="text d-flex align-items-center justify-content-between gap-2">
                                                    <div class="key">Free Delivery (25 mins)</div>
                                                    <div class="value">-€00</div>
                                                </div>
                                                <div class="active text d-flex align-items-center justify-content-between gap-2">
                                                    <div class="key">Item Discount</div>
                                                    <div class="value">-€01</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="footer-main-total-footer">
                                            <div class="text-grp d-flex align-items-center gap-2 justify-content-between">
                                                <div class="key">Total</div>
                                                <div class="value">€10.20</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="foodorder-box-details-footer d-flex align-items-center justify-content-between gap-2">
                                    <button class="btn">Print Label</button>
                                    <button class="btn active" class="customize-foodlink button" data-bs-toggle="modal" data-bs-target="#deleteAlertModal">Move to Kitchen</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <!-- start footer -->
    @include('layouts.admin.footer_design')
    <!-- end footer -->
    </div>
