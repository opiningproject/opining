@extends('layouts.app')

@section('content')
<div class="main">
    <div class="main-view">
        <div class="container-fluid bd-gutter bd-layout bg-light">
            @include('layouts.admin.side_nav_bar')

            <main class="order-1 w-100">
                <div class="main-content">
                    <div class="section-page-title mb-0">
                        <h1 class="page-title">{{ trans('rest.settings.title') }}</h1>
                    </div>

                    <!-- start Setting section -->
                    <section class="custom-section">
                        <div class="customize-tab setting-tab horizontal_tab_setting">
                            <ul class="nav nav-tabs flex-wrap" id="myTab" role="tablist">
                                <li class="empty_space"></li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="restaurantProfile-tab" data-bs-toggle="tab" data-bs-target="#restaurantProfile-tab-pane" type="button" role="tab" aria-controls="restaurantProfile-tab-pane" aria-selected="false">
                                        {{ trans('rest.settings.profile.title') }}
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="paymentHistory-tab" data-bs-toggle="tab" data-bs-target="#paymentHistory-tab-pane" type="button" role="tab"
                                            aria-controls="paymentHistory-tab-pane" aria-selected="false">{{ trans('rest.settings.payment.history') }}
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="cmsPagesen-tab" data-bs-toggle="tab" data-bs-target="#cmsPagesen-tab-pane" type="button" role="tab"
                                            aria-controls="cmsPagesen-tab-pane" aria-selected="false">{{ trans('rest.settings.cms.title') }}(English)
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="cmsPagesdutch-tab" data-bs-toggle="tab" data-bs-target="#cmsPagesdutch-tab-pane" type="button" role="tab"
                                            aria-controls="cmsPagesdutch-tab-pane" aria-selected="false">{{ trans('rest.settings.cms.title') }}(Dutch)
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="refundPayment-tab" data-bs-toggle="tab" data-bs-target="#refundPayment-tab-pane" type="button" role="tab"
                                            aria-controls="refundPayment-tab-pane" aria-selected="false">{{ trans('rest.settings.payment.refund_payment') }}
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="zipCode-tab" data-bs-toggle="tab" data-bs-target="#zipCode-tab-pane" type="button" role="tab"
                                            aria-controls="zipCode-tab-pane" aria-selected="false">{{ trans('rest.settings.zipcode.title') }}
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link domainSetting-tab" id="domainSetting-tab" data-bs-toggle="tab" data-bs-target="#domainSetting-tab-pane" type="button" role="tab"
                                            aria-controls="domainSetting-tab-pane" aria-selected="false">
                                        {{ trans('rest.settings.domain_setting.title') }}
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="apiSetting-tab" data-bs-toggle="tab" data-bs-target="#apiSetting-tab-pane" type="button" role="tab"
                                            aria-controls="apiSetting-tab-pane" aria-selected="false">{{ trans('rest.settings.api_setting.title') }}
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="paymentSetting-tab" data-bs-toggle="tab" data-bs-target="#paymentSetting-tab-pane" type="button" role="tab"
                                            aria-controls="paymentSetting-tab-pane" aria-selected="false">{{ trans('rest.settings.payment_setting.title') }}
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="checkoutSetting-tab" data-bs-toggle="tab" data-bs-target="#checkoutSetting-tab-pane" type="button" role="tab"
                                            aria-controls="checkoutSetting-tab-pane" aria-selected="false">{{ trans('rest.settings.checkout_setting.title') }}
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="plansBills-tab" data-bs-toggle="tab" data-bs-target="#plansBills-tab-pane" type="button" role="tab"
                                            aria-controls="plansBills-tab-pane" aria-selected="false">{{ trans('rest.settings.plans_bill.title') }}
                                    </button>
                                </li>
                            </ul>

                            <div class="tab-content card editdish-card setting-tab-content" id="myTabContent">
                                <div class="tab-content" id="myTabContent">
                                    <div class="tab-pane fade" id="domainSetting-tab-pane" role="tabpanel" aria-labelledby="domainSetting-tab">
                                        <!-- Content will be loaded here -->
                                    </div>
                                </div>
                                @include('admin.settings.profile')
                                @include('admin.settings.payment-history')
                                @include('admin.settings.cms-en')
                                @include('admin.settings.cms-nl')
                                @include('admin.settings.refund-history')
                                @include('admin.settings.zipcode')
                                @include('admin.settings.plans-bills')
                                @include('admin.settings.api-setting')
                                @include('admin.settings.payment-setting')
                                @include('admin.settings.checkout-setting')
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
                        <h4 class="alert-text-1 mb-40px">{{ trans('rest.modal.cms.alert_message') }}</h4>
                    </div>
                </div>
                <div class="">
                    <button type="button" class="btn btn-outline-secondary fw-400 text-uppercase font-sebibold w-100" data-bs-dismiss="modal">{{ trans('rest.button.ok') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end Modal -->
@endsection
