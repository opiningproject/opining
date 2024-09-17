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
                    <div class="main-content food-order-main-content d-flex flex-column h-100">
                        <div
                            class="section-page-title mb-0 d-flex align-items-center justify-content-end gap-2 foodorder-page-title">
                            <h1 class="page-title me-auto">{{ trans('rest.food_order.title') }} New</h1>
                            <div class="btn-grp btn-grp-gap-10 d-flex align-items-center flex-wrap" id="order-dilters">
                                <div class="header-filter-order d-flex align-items-center flex-wrap">

                                <div class="select-options">
                                    <select class="form-control" id="order-tabs-dropdown">
                                        <option value="#all-orders"  selected>{{ trans('rest.sidebar.all') }}</option>
                                        <option value="#open-orders" >{{ trans('rest.sidebar.open') }}</option>
                                    </select>
                                </div>
                                <div class="search-has col order-filters-search">
                                        <span class="fa fa-search form-control-feedback"></span>
                                        <input type="text" class="form-control" id="search-order" placeholder="Search">
                                    </div>

                                    <form class="form col" action="" method="#">
                                        <div class="input-group order-filters-search">
                                            <input type="text" placeholder="Select Date For Filter" class="form-control"
                                                id="expiry_date" aria-label="expiry_date" name="expiry_date" required>
                                        </div>
                                    </form>
                                </div>
                                <button type="button" name="clear" value="all" id="clear" class="btn btn-site-theme clear-button order-filters-search">Clear</button>

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
