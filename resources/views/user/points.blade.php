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
             <div class="card custom-card h-100 overflow-hidden">
               <div class="row">
                 <div class="col-xxl-6 col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 position-relative p-0">
                   <div id="chart-container-one" class="collected-points-charts"></div>
                   <h3 class="chart-caption">Get 1 point order above €20 plus</h3>
                 </div>
                 <div class="col-xxl-6 col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 position-relative p-0">
                   <div id="chart-container-two" class="collected-points-charts"></div>
                   <h3 class="chart-caption">Get 2 point order above €30 plus</h3>
                 </div>
               </div>
               <div class="card-body pb-0">
                 <div class="collected-points-list">
                   <p class="text-capitalize">instruction</p>
                   <ul>
                     <li>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since Lorem Ipsum is simply</li>
                     <li>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since Lorem Ipsum is simply</li>
                     <li>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since Lorem Ipsum is simply</li>
                     <li>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since Lorem Ipsum is simply</li>
                     <li>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since Lorem Ipsum is simply</li>
                     <li>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since Lorem Ipsum is simply</li>
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
     <div class="toast align-items-center bg-yellow border-yellow show custom-toast rounded-0" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="500">
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

      const chartData =  [
                        {
                            label: "04",
                            value: "20",
                            color: "#FFC00B",
                            plotBorderThickness: 10
                        },
                        {
                            label: "03",
                            value: "20",
                            color: "#FFC00B",
                            plotBorderThickness: 10
                        },
                        {
                            label: "02",
                            value: "20",
                            color: "#FFC00B",
                            plotBorderThickness: 10
                        },
                        {
                            label: "01",
                            value: "20",
                            color: "#FFC00B",
                            plotBorderThickness: 10
                        },
                        {
                            label: "05",
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
                        defaultcenterlabel: "4 Points",
                        captionFontSize: "3rem",
                        decimals: "1",
                        doughnutRadius: "60",
                        useDataPlotColorForLabels: "1",
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

      FusionCharts.ready(function () {
            var myChart = new FusionCharts({
                type: "doughnut2d",
                renderAt: "chart-container-two",
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

