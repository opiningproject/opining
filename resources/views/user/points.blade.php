@extends('layouts.user-app')

@section('content')

 <div class="main">
   <div class="main-view">
     <div class="container-fluid bd-gutter bd-layout">
       @include('layouts.user.side_nav_bar')
       <main class="bd-main order-1">
         <div class="main-content">
           <div class="section-page-title main-page-title mb-0">
             <div class="col-xxl-6 col-xl-6 col-lg-5 col-md-6 col-sm-6 col-12">
               <h1 class="page-title">Collected Points</h1>
             </div>
           </div>
           <!-- start category list section -->
           <section class="custom-section informativeterms-section h-100">
             <div class="card custom-card h-100 overflow-hidden px-2">
               <div class="row align-items-center">
                  <div class="col-md-6">
                    <div id="chart-container-one" class="collected-points-charts"></div>
                  </div>
                  <div class="col-md-6 text-center text-md-start">
                    <h3 class="fs-4">Get 1 point order above €20 plus</h3>
                    <h3 class="mt-4 mb-0 fs-4">Get 2 points order above €30 plus</h3>
                    <a class="btn btn-custom-yellow track-order-btn"  href="{{ route('user.dashboard') }}">
                      <span class="align-middle">Order Now</span>
                    </a>
                  </div>
               </div>
               <div class="card-body pb-0">
                 <div class="collected-points-list">
                   <p class="text-capitalize">instruction</p>
                   <ul>
                     <li>Get 1 point order above €20 plus</li>
                     <li>Get 2 points order above €30 plus
                     </li>
                   </ul>
                 </div>
               </div>
             </div>
           </section>
           <!-- end category list section -->
         </div>
       </main>
     </div>
     <!-- start toaster -->
     <div class="toast align-items-center bg-yellow border-yellow show custom-toast rounded-0 d-none" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="500">
       <div class="d-flex text-center justify-content-center">
         <div class="toast-body">
           <p class="mb-0 alert-custom-text"> To have your food delivery to your area, please add €10 worth of items to your order</p>
         </div>
       </div>
     </div>
     <!-- end toaster -->
   </div>
   <!-- start footer -->
   @include('layouts.user.footer_design')
   <!-- end footer -->
 </div>
@endsection

@section('script')
<script type="text/javascript">

      var collected_points = "<?php echo Auth::user()->collected_points; ?>";

      const chartData =  [{
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
                        defaultcenterlabel: collected_points+" Points Collected",
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

      FusionCharts.ready(function () {
            var myChart = new FusionCharts({
                type: "doughnut2d",
                renderAt: "chart-container-one",
                plotBorderThickness: 90,
                width: "100%",
                height: "100%",
                dataFormat: "json",
                dataSource: {
                    chart : dataSourceData,
                    data: chartData
                }
            }).render();
        });

</script>
@endsection

