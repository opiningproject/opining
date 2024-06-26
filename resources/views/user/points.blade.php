@extends('layouts.user-app')

@section('content')
<style>
.disabled-coupon {
    pointer-events: none;
    opacity: var(--bs-btn-disabled-opacity);
}
</style>
    <div class="main">
        <div class="main-view">
            <div class="container-fluid bd-gutter bd-layout">
                @include('layouts.user.side_nav_bar')
                <main class="bd-main order-1">
                    <div class="main-content">
                        <div class="section-page-title main-page-title mb-0 title-mobile">
                            <div class="col-xxl-6 col-xl-6 col-lg-5 col-md-6 col-sm-6 col-12">
                                <h1 class="page-title">{{ trans('user.collected_points.title') }}</h1>
                            </div>
                        </div>
                        <!-- start category list section -->
                        <section class="custom-section informativeterms-section h-100 pb-0">
                            <div class="card custom-card h-100 overflow-hidden px-0">

                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-md-6">
                                            <div id="chart-container-one" class="collected-points-charts"></div>
                                        </div>
                                        <div class="col-md-6 mb-4 text-start">

                                            <div class="colleting-points">
                                                <h5>How do I earn points?</h5>
                                                <h3>{{ trans('user.collected_points.content_1') }}</h3>
                                                <h3 class="mb-0">
                                                    {{ trans('user.collected_points.content_2') }}</h3>
                                            </div>

                                            {{-- <a class="btn btn-custom-yellow track-order-btn mt-4"  href="{{ route('user.dashboard') }}">
                    <span class="align-middle">{{ trans('user.collected_points.order_now') }} </span>
                  </a> --}}
                                        </div>
                                    </div>

                                    {{-- <div class="card-body pb-0 px-0 px-md-3 d-none">
                                  <div class="collected-points-list">
                                      <p class="text-capitalize">{{ trans('user.collected_points.instruction') }}</p>
                                      <ul>
                                          <li>{{ trans('user.collected_points.content_1') }}</li>
                                          <li>{{ trans('user.collected_points.content_2') }}</li>
                                      </ul>
                                  </div>
                              </div> --}}

                                    <div class="row justify-content-center mb-5">
                                        <div class="col-12">
                                            <div class="accordion collecting-accordian" id="accordionExample">
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header">
                                                        <button class="accordion-button" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapseOne"
                                                            aria-expanded="true" aria-controls="collapseOne">
                                                            What are points?
                                                        </button>
                                                    </h2>
                                                    <div id="collapseOne" class="accordion-collapse collapse show"
                                                        data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut non
                                                            porttitor nisi, et dictum nibh. Aenean facilisis enim lectus, at
                                                            sagittis ipsum tincidunt quis.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapseTwo"
                                                            aria-expanded="false" aria-controls="collapseTwo">
                                                            How to change them in to coupons?
                                                        </button>
                                                    </h2>
                                                    <div id="collapseTwo" class="accordion-collapse collapse"
                                                        data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut non
                                                            porttitor nisi, et dictum nibh. Aenean facilisis enim lectus, at
                                                            sagittis ipsum tincidunt quis.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapseThree"
                                                            aria-expanded="false" aria-controls="collapseThree">
                                                            How long are my points valid?
                                                        </button>
                                                    </h2>
                                                    <div id="collapseThree" class="accordion-collapse collapse"
                                                        data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut non
                                                            porttitor nisi, et dictum nibh. Aenean facilisis enim lectus, at
                                                            sagittis ipsum tincidunt quis.
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="row justify-content-center">

                                        <div class="col-12">

                                            <h3 class="title-site mb-4">Offers</h3>

                                            <div class="accordion discount-coupon-accordian" id="accordionExample">
                                                @foreach($coupons as $key => $coupon)
                                        
                                                @php 

                                                $givenDate = $coupon->end_expiry_date; // example given date

                                                // Current date
                                                $currentDate = new DateTime();

                                                // Convert the target date to a DateTime object
                                                $expirationDate = new DateTime($givenDate);

                                                // Calculate the difference between the two dates
                                                $interval = $currentDate->diff($expirationDate);

                                                // Get the number of days left
                                                $daysLeft = $interval->days;

                                                $leftDays = '';

                                                // Check if the target date is in the future
                                                if ($expirationDate > $currentDate) {
                                                    // Check if the difference is less than 1 day (but not zero)
                                                    if ($interval->invert == 0 && $interval->days == 0 && $currentDate->format('Y-m-d') != $expirationDate->format('Y-m-d')) {
                                                        $leftDays = '<label>1 DAY LEFT</label>';
                                                    } else {
                                                        $leftDays = '<label>'.$daysLeft.' DAYS LEFT</label>';
                                                    }
                                                }
                                        
                                                @endphp

                                                <?php $lockedCoupon = ''; ?>
                                                                    
                                                @if($user->collected_points < $coupon->points)
                                                    <?php $lockedCoupon = 'disabled-coupon'; ?>
                                                @elseif($currentDate->format('Y-m-d') == $expirationDate->format('Y-m-d'))
                                                    <?php $lockedCoupon = 'disabled-coupon'; ?>
                                                @endif

                                                <div class="accordion-item">
                                                    <h2 class="accordion-header">
                                                        <button class="accordion-button {{ $key == 0 ? 'collapsed' : '' }}" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#coupon-collapse-{{ $coupon->id }}"
                                                            aria-expanded="true" aria-controls="coupon-collapse-{{ $coupon->id }}">
                                                            <div class="acc-header">
                                                                <div class="ico">
                                                                    <img src="{{ getRestaurantDetail()->restaurant_logo }}" />
                                                                </div>
                                                                <div class="con-title">
                                                                    <h3 class="mb-1">{{ $coupon->percentage_off }}% discount coupon</h3>
                                                                    @if($user->collected_points < $coupon->points)
                                                                    <p class="mb-0 d-flex align-items-center free-coins">{{ trans('user.coupons.earn_points',['points' => $coupon->points]) }} {!!$leftDays!!}</p>
                                                                    @elseif($coupon->points > 0)
                                                                        <p class="mb-0 d-flex align-items-center free-coins">{{ trans('user.coupons.earned_points',['points' => $coupon->points]) }} Points {!!$leftDays!!}</p>
                                                                    @elseif($coupon->points == 0)
                                                                        <p class="mb-0 d-flex align-items-center free-coins">{{ trans('user.coupons.free_points') }} {!!$leftDays!!}</p>
                                                                    @endif
                                                                  
                                                                </div>
                                                            </div>
                                                        </button>
                                                    </h2>
                                                    <div id="coupon-collapse-{{ $coupon->id }}" class="accordion-collapse collapse {{ $key == 0 ? 'show' : '' }}"
                                                        data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            <h3>Conditions</h3>
                                                            <ul class="mb-3">
                                                                <li>{{ trans('user.coupons.min_order') }} €{{ $coupon->price }}</li>
                                                                <li>{{ trans('user.coupons.valid_till') }} {{ $coupon->end_expiry_date }}</li>
                                                            </ul>
                                                            <a
                                                                class="btn btn-custom-yellow btn-default d-block d-md-inline-block text-white {{ $lockedCoupon }}" id="coupon-code-{{ $coupon->id }}" data-code="{{ $coupon->promo_code }}" onclick='showCouponPopup({{ $coupon->id }})'>
                                                                Redeem my points
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                    @endforeach
                                                    <input type="hidden" id="coupon-code">
                                                    <input type="hidden" id="coupon-id">

                                                {{-- <div class="accordion-item">
                                                    <h2 class="accordion-header">
                                                        <button class="accordion-button" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapseCpOne"
                                                            aria-expanded="true" aria-controls="collapseCpOne">
                                                            <div class="acc-header">
                                                                <div class="ico">
                                                                    <img
                                                                        src="{{ getRestaurantDetail()->restaurant_logo }}" />
                                                                </div>

                                                                <div class="con-title">
                                                                    <h3 class="mb-1">20% discount coupon</h3>
                                                                    <p class="mb-0">5 points</p>
                                                                </div>
                                                            </div>
                                                        </button>
                                                    </h2>
                                                    <div id="collapseCpOne" class="accordion-collapse collapse show"
                                                        data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            <h3>Conditions</h3>
                                                            <ul class="mb-3">
                                                                <li>Minumum order of 30 euros</li>
                                                                <li>Valid for 2 weeks after redeem.</li>
                                                            </ul>
                                                            <a
                                                                class="btn btn-custom-yellow btn-default d-block d-md-inline-block text-white">
                                                                Redeem my points
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapseCpTwo"
                                                            aria-expanded="false" aria-controls="collapseCpTwo">
                                                            <div class="acc-header">
                                                              <div class="ico">
                                                                  <img
                                                                      src="{{ getRestaurantDetail()->restaurant_logo }}" />
                                                              </div>

                                                              <div class="con-title">
                                                                  <h3 class="mb-1">50% discount coupon</h3>
                                                                  <p class="mb-0">10 points</p>
                                                              </div>
                                                          </div>
                                                        </button>
                                                    </h2>
                                                    <div id="collapseCpTwo" class="accordion-collapse collapse"
                                                        data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            <h3>Conditions</h3>
                                                            <ul class="mb-3">
                                                                <li>Minumum order of 30 euros</li>
                                                                <li>Valid for 2 weeks after redeem.</li>
                                                            </ul>
                                                            <a
                                                                class="btn btn-custom-yellow btn-default d-block d-md-inline-block text-white">
                                                                Redeem my points
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header">
                                                        <button class="accordion-button collapsed" type="button"
                                                            data-bs-toggle="collapse" data-bs-target="#collapseCpThree"
                                                            aria-expanded="false" aria-controls="collapseCpThree">
                                                            <div class="acc-header">
                                                              <div class="ico">
                                                                  <img
                                                                      src="{{ getRestaurantDetail()->restaurant_logo }}" />
                                                              </div>

                                                              <div class="con-title">
                                                                  <h3 class="mb-1">50% discount coupon</h3>
                                                                  <p class="mb-0 d-flex align-items-center free-coins">FREE <label>1 DAY LEFT</label></p>
                                                              </div>
                                                          </div>
                                                        </button>
                                                    </h2>
                                                    <div id="collapseCpThree" class="accordion-collapse collapse"
                                                        data-bs-parent="#accordionExample">
                                                        <div class="accordion-body">
                                                            <h3>Conditions</h3>
                                                            <ul class="mb-3">
                                                                <li>Minumum order of 30 euros</li>
                                                                <li>Valid for 2 weeks after redeem.</li>
                                                            </ul>
                                                            <a
                                                                class="btn btn-custom-yellow btn-default d-block d-md-inline-block text-white">
                                                                Redeem my points
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>



                            </div>
                        </section>
                        <!-- end category list section -->
                    </div>
                </main>
            </div>
            <!-- start toaster -->
            <div class="toast align-items-center bg-yellow border-yellow show custom-toast rounded-0 d-none"
                role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="500">
                <div class="d-flex text-center justify-content-center">
                    <div class="toast-body">
                        <p class="mb-0 alert-custom-text"> To have your food delivery to your area, please add €10 worth of
                            items to your order</p>
                    </div>
                </div>
            </div>
            <!-- end toaster -->
        </div>
        <!-- start footer -->
        @include('layouts.user.footer_design')
        <!-- end footer -->
    </div>


@include('user.modals.coupon-redeem')
@include('user.modals.redeem-confirmation')
@endsection

@section('script')
    <script type="text/javascript">



    $('#redeem-confirmed-btn').on('click', function(event) {
        event.preventDefault(); 
        var url = $(this).data('target');
    
        location.replace(baseURL+url);
    });

    function showCouponPopup(id)
    {
        var code = $('#coupon-code-'+id).data('code');

        $('#redeemConfirmationModal').modal('show')
        $('#coupon-code').val(code);
        $('#coupon-id').val(id);
        $('#coupon-code-name').text(code)
    }

    function couponCodeConfirmation() {
            var code = $('#coupon-code').val();
            var id = $('#coupon-id').val();
    
            // $('#coupon-code-' + id).text(code)

            $.ajax({
                url: baseURL + '/user/coupons/confirm/' + id,
                type: 'GET',
                success: function(response) {
                    $('#redeemConfirmationModal').modal('hide');
                    $('#redeemConfirmedModal').modal('show')
                    //location.reload()
                },
                error: function(response) {
                    var errorMessage = JSON.parse(response.responseText).message
                    alert(errorMessage);
                }
            })
        }

        var collected_points = "<?php echo Auth::user()->collected_points; ?>";

        const chartData = [{
                label: "",
                value: "80",
                color: "#FFC00B",
                plotBorderThickness: 10
            },
            {
                label: "",
                value: "20",
                plotBorderThickness: 10
                // "color": "#FFF8E2"
            }
        ];

        const dataSourceData = {
            caption: false,
            baseFontSize: "18",
            subcaption: false,
            showpercentvalues: "1",
            defaultcenterlabel: collected_points,
            captionFontSize: "3rem",
            decimals: "1",
            doughnutRadius: "60",
            useDataPlotColorForLabels: "0",
            labelFontColor: "#292929",
            theme: "fusion",
            enableMultiSlicing: "0",
            showLegend: false,
            legendposition: "bottom",
            textoutline: "0",
            labelPosition: 'inside',
            showvalues: false,
            plotBorderThickness: 80,
            plotBorderColor: '#ffffff',
            paletteColors: "#FFF8E2",
            plotBorderThickness: 5,
            setDataLabelStyle: {
                fontColor: 'white',
                fontSize: 166,
                fontWeight: 'bold'
            }

        };

        FusionCharts.ready(function() {
            var myChart = new FusionCharts({
                type: "doughnut2d",
                renderAt: "chart-container-one",
                plotBorderThickness: 90,
                width: "100%",
                height: "100%",
                dataFormat: "json",
                dataSource: {
                    chart: dataSourceData,
                    data: chartData
                }
            }).render();
        });
    </script>
@endsection
