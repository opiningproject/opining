@extends('layouts.app')

@section('content')
    <div class="main">
        <div class="main-view">
            <div class="container-fluid bd-gutter bd-layout bg-light">
                @include('layouts.admin.side_nav_bar')

                <main class=" order-1 w-100">
                    <div class="main-content">
                        <div class="section-page-title mb-0">
                            <h1 class="page-title">Settings</h1>
                        </div>

                        <!-- start Setting section -->
                        <section class=" custom-section">
                            <div class="customize-tab setting-tab">
                                <ul class="nav nav-tabs flex-nowrap" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link {{ (isset($_GET['per_page']) || isset($_GET['page_no'])) ? '' : 'active'}}" id="restaurantProfile-tab" data-bs-toggle="tab"
                                                data-bs-target="#restaurantProfile-tab-pane" type="button" role="tab"
                                                aria-controls="restaurantProfile-tab-pane" aria-selected="{{ (isset($_GET['per_page']) || isset($_GET['page_no'])) ? 'false' : 'true'}}">
                                            Restaurant
                                            Profile
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="paymentHistory-tab" data-bs-toggle="tab"
                                                data-bs-target="#paymentHistory-tab-pane" type="button" role="tab"
                                                aria-controls="paymentHistory-tab-pane" aria-selected="false">Payment
                                            History
                                        </button>
                                    </li>
                                    <li class="nav-item " role="presentation">
                                        <button class="nav-link" id="cmsPagesen-tab" data-bs-toggle="tab"
                                                data-bs-target="#cmsPagesen-tab-pane" type="button" role="tab"
                                                aria-controls="cmsPagesen-tab-pane" aria-selected="false">CMS
                                            Pages(English)
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="cmsPagesdutch-tab" data-bs-toggle="tab"
                                                data-bs-target="#cmsPagesdutch-tab-pane" type="button" role="tab"
                                                aria-controls="cmsPagesdutch-tab-pane" aria-selected="false">CMS
                                            Pages(Dutch)
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link" id="refundPayment-tab" data-bs-toggle="tab"
                                                data-bs-target="#refundPayment-tab-pane" type="button" role="tab"
                                                aria-controls="refundPayment-tab-pane" aria-selected="false">Refund
                                            Payment
                                        </button>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link {{ (isset($_GET['per_page']) || isset($_GET['page_no'])) ? 'active' : ''}}" id="zipCode-tab" data-bs-toggle="tab"
                                                data-bs-target="#zipCode-tab-pane" type="button" role="tab"
                                                aria-controls="zipCode-tab-pane" aria-selected="{{ (isset($_GET['per_page']) || isset($_GET['page_no'])) ? 'true' : 'false'}}">Zip Code
                                        </button>
                                    </li>
                                </ul>

                                <div class="tab-content card editdish-card setting-tab-content" id="myTabContent">
                                    @include('admin.settings.profile')
                                    @include('admin.settings.payment-history')
                                    @include('admin.settings.cms-en')
                                    @include('admin.settings.cms-nl')
                                    @include('admin.settings.refund-history')
                                    @include('admin.settings.zipcode')
                                </div>
                            </div>
                        </section>
                        <!-- end Setting section -->
                    </div>
                </main>
            </div>
        </div>
        <!-- start footer -->
        @include('layouts.admin.footer_design')
        <!-- end footer -->
    </div>

    <!-- start CMS save msg Modal -->
    <div class="modal fade custom-modal" id="CMSCouponModal" tabindex="-1" aria-labelledby="dleteAlertModal" aria-hidden="true">
        <div class="modal-dialog custom-w-441px modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <h4 class="alert-text-1 mb-40px">Your content has been successfully saved !!</h4>
                        </div>
                    </div>
                    <div class="">
                        <button type="button" class="btn btn-outline-secondary fw-400 text-uppercase font-sebibold w-100" data-bs-dismiss="modal">Ok</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end Modal -->

@endsection