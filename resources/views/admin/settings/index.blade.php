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
                            <div class="form-group mb-0">
                                <div
                                    class="form-check form-switch custom-switch dark-theme-switch d-flex align-items-center justify-content-between ps-0">
                                    <label class="form-check-label form-label mb-0 text-muted-default"
                                           for="darkSwitch">Dark Theme</label>
                                    <input class="form-check-input" type="checkbox" role="switch" id="darkSwitch">
                                </div>
                            </div>
                        </div>

                        <!-- start Setting section -->
                        <section class=" custom-section">
                            <div class="customize-tab setting-tab">
                                <ul class="nav nav-tabs" id="myTab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link active" id="restaurantProfile-tab" data-bs-toggle="tab"
                                                data-bs-target="#restaurantProfile-tab-pane" type="button" role="tab"
                                                aria-controls="restaurantProfile-tab-pane" aria-selected="true">
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
                                        <button class="nav-link" id="zipCode-tab" data-bs-toggle="tab"
                                                data-bs-target="#zipCode-tab-pane" type="button" role="tab"
                                                aria-controls="zipCode-tab-pane" aria-selected="false">Zip Code
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

@section('script')
    
    <script type="text/javascript">
        $('.timepicker').timepicker({
            timeFormat: 'h:mm',
            interval: 60,
            minTime: '10',
            maxTime: '6:00pm',
            defaultTime: '11',
            startTime: '10:00',
            dynamic: false,
            dropdown: true,
            scrollbar: true
        });

        var editor_config = {
            skin: 'moono',
            height: '40vh',
            enterMode: CKEDITOR.ENTER_BR,
            shiftEnterMode: CKEDITOR.ENTER_P,
            toolbar: [{ name: 'basicstyles', groups: ['basicstyles'], items: ['Bold', 'Italic', 'Underline', "-", 'TextColor', 'BGColor'] },
                { name: 'styles', items: ['Format', 'Font', 'FontSize'] },
                { name: 'scripts', items: ['Subscript', 'Superscript'] },
                { name: 'justify', groups: ['blocks', 'align'], items: ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock'] },
                { name: 'paragraph', groups: ['list', 'indent'], items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent'] },
                { name: 'links', items: ['Link', 'Unlink'] },
                { name: 'insert', items: ['Image'] },
                { name: 'spell', items: ['jQuerySpellChecker'] },
                { name: 'table', items: ['Table'] }
            ],
        };

        CKEDITOR.replace('privacy-en',editor_config);
        CKEDITOR.replace('terms-en',editor_config);
        CKEDITOR.replace('privacy-nl',editor_config);
        CKEDITOR.replace('terms-nl',editor_config);
        
    </script>
@endsection
