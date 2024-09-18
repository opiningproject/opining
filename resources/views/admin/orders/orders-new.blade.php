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
            <main class="bd-main updated_order order-1 w-100 position-relative">
                <div class="main-content food-order-main-content d-flex flex-column h-100 order-page">
                    <div
                        class="section-page-title mb-0 d-flex align-items-center justify-content-end gap-2 order-page-bar">
                        <h1 class="page-title me-auto">Orders <span class="count">14</span></h1>
                        <div class="btn-grp btn-grp-gap-10 d-flex align-items-center flex-wrap" id="order-dilters">
                            <div class="header-filter-order d-flex align-items-center flex-wrap">

                                <div class="drop_with_search">
                                    <div class="select-options">
                                        <select class="form-control" id="order-tabs-dropdown">
                                            <option value="#all-orders" selected>{{ trans('rest.sidebar.all') }}
                                            </option>
                                            <option value="#open-orders">{{ trans('rest.sidebar.open') }}</option>
                                        </select>
                                    </div>
                                    <div class="search-has col order-filters-search">
                                        <span class="fa fa-search form-control-feedback"></span>
                                        <input type="text" class="form-control" id="search-order" placeholder="Search">
                                    </div>
                                </div>

                                <!-- <form class="form col" action="" method="#">
                                    <div class="input-group order-filters-search">
                                        <input type="text" placeholder="Select Date For Filter" class="form-control"
                                            id="expiry_date" aria-label="expiry_date" name="expiry_date" required>
                                    </div>
                                </form> -->

                                <div class="select-options filter-options">
                                    <select class="form-control" id="filter-order-dropdown">
                                        <option value="" selected>Filter Orders</option>
                                        <option value="">Filter Orders 1</option>
                                    </select>
                                </div>
                            </div>
                            <button type="button" name="clear" value="all" id="clear"
                                class="btn btn-site-theme clear-button order-filters-search">Create Order</button>

                        </div>
                    </div>

                    <div class="order-listing-container">
                        <div class="order-row">
                            <div class="order-col">
                                <div class="order-box">
                                    <div class="timing">
                                        <h3>23:10</h3>
                                        <label class="success">ASAP</label>
                                    </div>

                                    <div class="details">
                                        <div class="left">
                                            <h4>Serdar Orman</h4>
                                            <p class="mb-0">Tochtstraat 40, 3036sk</p>
                                        </div>

                                        <div class="right text-end ps-2">
                                            <p class="mb-0">12-09-2024, 22:38</p>
                                            <p class="mb-0">web #1022</p>
                                        </div>
                                    </div>

                                    <div class="actions">
                                        <h5 class="mb-0 price_status"><b>€15.59</b>&nbsp;&nbsp;|&nbsp;&nbsp;Paid</h5>
                                        <a href="#" class="btn btn-danger-outline">New Order</a>
                                    </div>
                                </div>
                            </div>

                            <div class="order-col">
                                <div class="order-box">
                                    <div class="timing">
                                        <h3>23:10</h3>
                                        <label class="success">ASAP</label>
                                    </div>

                                    <div class="details">
                                        <div class="left">
                                            <h4>Serdar Orman</h4>
                                            <p class="mb-0">Tochtstraat 40, 3036sk</p>
                                        </div>

                                        <div class="right text-end ps-2">
                                            <p class="mb-0">12-09-2024, 22:38</p>
                                            <p class="mb-0">web #1022</p>
                                        </div>
                                    </div>

                                    <div class="actions">
                                        <h5 class="mb-0 price_status"><b>€15.59</b>&nbsp;&nbsp;|&nbsp;&nbsp;Paid</h5>
                                        <a href="#" class="btn outline-danger">New Order</a>
                                    </div>
                                </div>
                            </div>

                            <div class="order-col">
                                <div class="order-box">
                                    <div class="timing">
                                        <h3>23:10</h3>
                                        <label class="danger">TIME</label>
                                    </div>

                                    <div class="details">
                                        <div class="left">
                                            <h4>Serdar Orman</h4>
                                            <p class="mb-0">Tochtstraat 40, 3036sk</p>
                                        </div>

                                        <div class="right text-end ps-2">
                                            <p class="mb-0">12-09-2024, 22:38</p>
                                            <p class="mb-0">web #1022</p>
                                        </div>
                                    </div>

                                    <div class="actions">
                                        <h5 class="mb-0 price_status"><b>€15.59</b>&nbsp;&nbsp;|&nbsp;&nbsp;Paid</h5>
                                        <a href="#" class="btn outline-warning">In Kitchen</a>
                                    </div>
                                </div>
                            </div>

                            <div class="order-col">
                                <div class="order-box">
                                    <div class="timing">
                                        <h3>23:10</h3>
                                        <label class="success">ASAP</label>
                                    </div>

                                    <div class="details">
                                        <div class="left">
                                            <h4>Serdar Orman</h4>
                                            <p class="mb-0">Tochtstraat 40, 3036sk</p>
                                        </div>

                                        <div class="right text-end ps-2">
                                            <p class="mb-0">12-09-2024, 22:38</p>
                                            <p class="mb-0">web #1022</p>
                                        </div>
                                    </div>

                                    <div class="actions">
                                        <h5 class="mb-0 price_status"><b>€15.59</b>&nbsp;&nbsp;|&nbsp;&nbsp;Paid</h5>
                                        <a href="#" class="btn outline-success">Out for Delivery</a>
                                    </div>
                                </div>
                            </div>

                            <div class="order-col">
                                <div class="order-box">
                                    <div class="timing">
                                        <h3>23:10</h3>
                                        <label class="success">ASAP</label>
                                    </div>

                                    <div class="details">
                                        <div class="left">
                                            <h4>Serdar Orman</h4>
                                            <p class="mb-0">Tochtstraat 40, 3036sk</p>
                                        </div>

                                        <div class="right text-end ps-2">
                                            <p class="mb-0">12-09-2024, 22:38</p>
                                            <p class="mb-0">web #1022</p>
                                        </div>
                                    </div>

                                    <div class="actions">
                                        <h5 class="mb-0 price_status"><b>€15.59</b>&nbsp;&nbsp;|&nbsp;&nbsp;Paid</h5>
                                        <a href="#" class="btn btn-danger-outline">New Order</a>
                                    </div>
                                </div>
                            </div>

                            <div class="order-col">
                                <div class="order-box">
                                    <div class="timing">
                                        <h3>23:10</h3>
                                        <label class="success">ASAP</label>
                                    </div>

                                    <div class="details">
                                        <div class="left">
                                            <h4>Serdar Orman</h4>
                                            <p class="mb-0">Tochtstraat 40, 3036sk</p>
                                        </div>

                                        <div class="right text-end ps-2">
                                            <p class="mb-0">12-09-2024, 22:38</p>
                                            <p class="mb-0">web #1022</p>
                                        </div>
                                    </div>

                                    <div class="actions">
                                        <h5 class="mb-0 price_status"><b>€15.59</b>&nbsp;&nbsp;|&nbsp;&nbsp;Paid</h5>
                                        <a href="#" class="btn outline-danger">New Order</a>
                                    </div>
                                </div>
                            </div>

                            <div class="order-col">
                                <div class="order-box">
                                    <div class="timing">
                                        <h3>23:10</h3>
                                        <label class="success">ASAP</label>
                                    </div>

                                    <div class="details">
                                        <div class="left">
                                            <h4>Serdar Orman</h4>
                                            <p class="mb-0">Tochtstraat 40, 3036sk</p>
                                        </div>

                                        <div class="right text-end ps-2">
                                            <p class="mb-0">12-09-2024, 22:38</p>
                                            <p class="mb-0">web #1022</p>
                                        </div>
                                    </div>

                                    <div class="actions">
                                        <h5 class="mb-0 price_status"><b>€15.59</b>&nbsp;&nbsp;|&nbsp;&nbsp;Paid</h5>
                                        <a href="#" class="btn btn-danger-outline">New Order</a>
                                    </div>
                                </div>
                            </div>

                            <div class="order-col">
                                <div class="order-box">
                                    <div class="timing">
                                        <h3>23:10</h3>
                                        <label class="success">ASAP</label>
                                    </div>

                                    <div class="details">
                                        <div class="left">
                                            <h4>Serdar Orman</h4>
                                            <p class="mb-0">Tochtstraat 40, 3036sk</p>
                                        </div>

                                        <div class="right text-end ps-2">
                                            <p class="mb-0">12-09-2024, 22:38</p>
                                            <p class="mb-0">web #1022</p>
                                        </div>
                                    </div>

                                    <div class="actions">
                                        <h5 class="mb-0 price_status"><b>€15.59</b>&nbsp;&nbsp;|&nbsp;&nbsp;Paid</h5>
                                        <a href="#" class="btn outline-danger">New Order</a>
                                    </div>
                                </div>
                            </div>

                            <div class="order-col">
                                <div class="order-box">
                                    <div class="timing">
                                        <h3>23:10</h3>
                                        <label class="danger">TIME</label>
                                    </div>

                                    <div class="details">
                                        <div class="left">
                                            <h4>Serdar Orman</h4>
                                            <p class="mb-0">Tochtstraat 40, 3036sk</p>
                                        </div>

                                        <div class="right text-end ps-2">
                                            <p class="mb-0">12-09-2024, 22:38</p>
                                            <p class="mb-0">web #1022</p>
                                        </div>
                                    </div>

                                    <div class="actions">
                                        <h5 class="mb-0 price_status"><b>€15.59</b>&nbsp;&nbsp;|&nbsp;&nbsp;Paid</h5>
                                        <a href="#" class="btn outline-warning">In Kitchen</a>
                                    </div>
                                </div>
                            </div>

                            <div class="order-col">
                                <div class="order-box">
                                    <div class="timing">
                                        <h3>23:10</h3>
                                        <label class="success">ASAP</label>
                                    </div>

                                    <div class="details">
                                        <div class="left">
                                            <h4>Serdar Orman</h4>
                                            <p class="mb-0">Tochtstraat 40, 3036sk</p>
                                        </div>

                                        <div class="right text-end ps-2">
                                            <p class="mb-0">12-09-2024, 22:38</p>
                                            <p class="mb-0">web #1022</p>
                                        </div>
                                    </div>

                                    <div class="actions">
                                        <h5 class="mb-0 price_status"><b>€15.59</b>&nbsp;&nbsp;|&nbsp;&nbsp;Paid</h5>
                                        <a href="#" class="btn outline-success">Out for Delivery</a>
                                    </div>
                                </div>
                            </div>

                            <div class="order-col">
                                <div class="order-box">
                                    <div class="timing">
                                        <h3>23:10</h3>
                                        <label class="success">ASAP</label>
                                    </div>

                                    <div class="details">
                                        <div class="left">
                                            <h4>Serdar Orman</h4>
                                            <p class="mb-0">Tochtstraat 40, 3036sk</p>
                                        </div>

                                        <div class="right text-end ps-2">
                                            <p class="mb-0">12-09-2024, 22:38</p>
                                            <p class="mb-0">web #1022</p>
                                        </div>
                                    </div>

                                    <div class="actions">
                                        <h5 class="mb-0 price_status"><b>€15.59</b>&nbsp;&nbsp;|&nbsp;&nbsp;Paid</h5>
                                        <a href="#" class="btn btn-danger-outline">New Order</a>
                                    </div>
                                </div>
                            </div>

                            <div class="order-col">
                                <div class="order-box">
                                    <div class="timing">
                                        <h3>23:10</h3>
                                        <label class="success">ASAP</label>
                                    </div>

                                    <div class="details">
                                        <div class="left">
                                            <h4>Serdar Orman</h4>
                                            <p class="mb-0">Tochtstraat 40, 3036sk</p>
                                        </div>

                                        <div class="right text-end ps-2">
                                            <p class="mb-0">12-09-2024, 22:38</p>
                                            <p class="mb-0">web #1022</p>
                                        </div>
                                    </div>

                                    <div class="actions">
                                        <h5 class="mb-0 price_status"><b>€15.59</b>&nbsp;&nbsp;|&nbsp;&nbsp;Paid</h5>
                                        <a href="#" class="btn outline-danger">New Order</a>
                                    </div>
                                </div>
                            </div>

                            <div class="order-col">
                                <div class="order-box">
                                    <div class="timing">
                                        <h3>23:10</h3>
                                        <label class="success">ASAP</label>
                                    </div>

                                    <div class="details">
                                        <div class="left">
                                            <h4>Serdar Orman</h4>
                                            <p class="mb-0">Tochtstraat 40, 3036sk</p>
                                        </div>

                                        <div class="right text-end ps-2">
                                            <p class="mb-0">12-09-2024, 22:38</p>
                                            <p class="mb-0">web #1022</p>
                                        </div>
                                    </div>

                                    <div class="actions">
                                        <h5 class="mb-0 price_status"><b>€15.59</b>&nbsp;&nbsp;|&nbsp;&nbsp;Paid</h5>
                                        <a href="#" class="btn btn-danger-outline">New Order</a>
                                    </div>
                                </div>
                            </div>

                            <div class="order-col">
                                <div class="order-box">
                                    <div class="timing">
                                        <h3>23:10</h3>
                                        <label class="success">ASAP</label>
                                    </div>

                                    <div class="details">
                                        <div class="left">
                                            <h4>Serdar Orman</h4>
                                            <p class="mb-0">Tochtstraat 40, 3036sk</p>
                                        </div>

                                        <div class="right text-end ps-2">
                                            <p class="mb-0">12-09-2024, 22:38</p>
                                            <p class="mb-0">web #1022</p>
                                        </div>
                                    </div>

                                    <div class="actions">
                                        <h5 class="mb-0 price_status"><b>€15.59</b>&nbsp;&nbsp;|&nbsp;&nbsp;Paid</h5>
                                        <a href="#" class="btn outline-danger">New Order</a>
                                    </div>
                                </div>
                            </div>

                            <div class="order-col">
                                <div class="order-box">
                                    <div class="timing">
                                        <h3>23:10</h3>
                                        <label class="danger">TIME</label>
                                    </div>

                                    <div class="details">
                                        <div class="left">
                                            <h4>Serdar Orman</h4>
                                            <p class="mb-0">Tochtstraat 40, 3036sk</p>
                                        </div>

                                        <div class="right text-end ps-2">
                                            <p class="mb-0">12-09-2024, 22:38</p>
                                            <p class="mb-0">web #1022</p>
                                        </div>
                                    </div>

                                    <div class="actions">
                                        <h5 class="mb-0 price_status"><b>€15.59</b>&nbsp;&nbsp;|&nbsp;&nbsp;Paid</h5>
                                        <a href="#" class="btn outline-warning">In Kitchen</a>
                                    </div>
                                </div>
                            </div>

                            <div class="order-col">
                                <div class="order-box">
                                    <div class="timing">
                                        <h3>23:10</h3>
                                        <label class="success">ASAP</label>
                                    </div>

                                    <div class="details">
                                        <div class="left">
                                            <h4>Serdar Orman</h4>
                                            <p class="mb-0">Tochtstraat 40, 3036sk</p>
                                        </div>

                                        <div class="right text-end ps-2">
                                            <p class="mb-0">12-09-2024, 22:38</p>
                                            <p class="mb-0">web #1022</p>
                                        </div>
                                    </div>

                                    <div class="actions">
                                        <h5 class="mb-0 price_status"><b>€15.59</b>&nbsp;&nbsp;|&nbsp;&nbsp;Paid</h5>
                                        <a href="#" class="btn outline-success">Out for Delivery</a>
                                    </div>
                                </div>
                            </div>

                            <div class="order-col">
                                <div class="order-box">
                                    <div class="timing">
                                        <h3>23:10</h3>
                                        <label class="success">ASAP</label>
                                    </div>

                                    <div class="details">
                                        <div class="left">
                                            <h4>Serdar Orman</h4>
                                            <p class="mb-0">Tochtstraat 40, 3036sk</p>
                                        </div>

                                        <div class="right text-end ps-2">
                                            <p class="mb-0">12-09-2024, 22:38</p>
                                            <p class="mb-0">web #1022</p>
                                        </div>
                                    </div>

                                    <div class="actions">
                                        <h5 class="mb-0 price_status"><b>€15.59</b>&nbsp;&nbsp;|&nbsp;&nbsp;Paid</h5>
                                        <a href="#" class="btn btn-danger-outline">New Order</a>
                                    </div>
                                </div>
                            </div>

                            <div class="order-col">
                                <div class="order-box">
                                    <div class="timing">
                                        <h3>23:10</h3>
                                        <label class="success">ASAP</label>
                                    </div>

                                    <div class="details">
                                        <div class="left">
                                            <h4>Serdar Orman</h4>
                                            <p class="mb-0">Tochtstraat 40, 3036sk</p>
                                        </div>

                                        <div class="right text-end ps-2">
                                            <p class="mb-0">12-09-2024, 22:38</p>
                                            <p class="mb-0">web #1022</p>
                                        </div>
                                    </div>

                                    <div class="actions">
                                        <h5 class="mb-0 price_status"><b>€15.59</b>&nbsp;&nbsp;|&nbsp;&nbsp;Paid</h5>
                                        <a href="#" class="btn outline-danger">New Order</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end align-items-center pt-3">
                        <!-- Pagination -->
                        <nav aria-label="Page navigation example">
                            <ul class="pagination pagination-custom">
                                <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Previous">
                                        <span aria-hidden="true">&lt;</span>
                                    </a>
                                </li>
                                <li class="page-item active">
                                    <a class="page-link" href="#">1</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">2</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#">3</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="#" aria-label="Next">
                                        <span aria-hidden="true">&gt;</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>

                        <!-- Filter buttons -->
                        <div class="filter-btn-group">
                            <button type="button" class="btn">
                                <img src="{{ asset(path: 'images/bike-white.svg') }}" 
                                    alt="Bike"  />
                            </button>

                            <button type="button" class="btn">
                            <img src="{{ asset(path: 'images/map-white.svg') }}" 
                            alt="Bike"  />
                            </button>

                            <button type="button" class="btn">
                            <img src="{{ asset(path: 'images/setting-white.svg') }}" 
                            alt="Bike"  />
                            </button>
                        </div>
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