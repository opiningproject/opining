@extends('layouts.user-app')
@section('content')
    <div class="main">
        <div class="main-view">
            <div class="container-fluid bd-gutter bd-layout">
                @include('layouts.user.side_nav_bar')
                <main class="bd-main order-1">
                    <div class="main-content mobile-main-content">
                        <div class="section-page-title main-page-title mb-0 title-mobile">
                            <div class="col-xxl-6 col-xl-6 col-lg-5 col-md-6 col-sm-6 col-12">
                                <h1 class="page-title">{{ trans('user.coupons.title') }}</h1>
                            </div>
                        </div>


                        <section class="custom-section h-100 pb-0 mobile-card-bg">
                            <div class="card custom-card h-100 mobile-card-transperant">

                                <div class="card-body card-body-mobile">
                                    <div class="customize-tab coupons-tab">
                                        <ul class="nav nav-tabs border-0 flex-nowrap" id="myTab" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active shadow-mobile" id="unused-coupons-tab" data-bs-toggle="tab"
                                                    data-bs-target="#unused-tab-pane" type="button" role="tab"
                                                    aria-controls="unused-tab-pane" aria-selected="false">
                                                    {{ trans('user.coupons.unused') }}
                                                </button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link shadow-mobile" id="expired-coupons-tab" data-bs-toggle="tab"
                                                    data-bs-target="#expired-tab-pane" type="button" role="tab"
                                                    aria-controls="expired-tab-pane"
                                                    aria-selected="false">{{ trans('user.coupons.expired') }}
                                                </button>
                                            </li>
                                        </ul>

                                        <div class="tab-content border-0 card editdish-card coupons-tab-content" id="myTabContent">
                                            @include('user.coupons.unused')
                                            @include('user.coupons.expired')
                                        </div>
                                    </div>
                                </div>



                            </div>
                        </section>



                        <!-- start coupons card section -->
                    </div>
                </main>
            </div>
        </div>
        <!-- start footer -->
        @include('layouts.user.footer_design')
        <!-- end footer -->

    </div>

    @include('user.modals.coupon-confirmation')
    @include('user.modals.coupon-redeem')
@endsection

@section('script')
<script type="text/javascript" src="{{ asset('js/user/coupons.js') }}"></script>
    <script type="text/javascript">
        $(".coupons-card").click(function() {
            $(".checkcircle").toggle();
        });

        $(".coupons-card").hover(function() {
            $(".checkcircle").css("display", "block");
        }, function() {
            $(".checkcircle").css("display", "none");
        });
        $(".coupons-card").click(function() {
            $(".checkcircle").toggle();
        });

        function showCouponPopup(id) {
            var code = $('#coupon-code-' + id).data('code');

            $('#couponConfirmationModal').modal('show')
            $('#coupon-code').val(code);
            $('#coupon-id').val(id);
            $('#coupon-code-name').text(code)
        }

        function couponCodeConfirmation() {
            var code = $('#coupon-code').val();
            var id = $('#coupon-id').val();

            $('#coupon-code-' + id).text(code)

            $.ajax({
                url: baseURL + '/user/coupons/confirm/' + id,
                type: 'GET',
                success: function(response) {
                    $(".coupon-code-box").removeClass("d-none");
                    $("#submit-btn").addClass("d-none");
                    $("#coupon-code-text").addClass("d-none");
                    //location.reload()
                },
                error: function(response) {
                    var errorMessage = JSON.parse(response.responseText).message
                    alert(errorMessage);
                }
            })
        }

        $('#couponConfirmationModal').on('hidden.bs.modal', function() {
            location.reload()
        })
    </script>
@endsection
