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
               <h1 class="page-title">My Order</h1>
             </div>
           </div>
         </div>
       </main>
     </div>
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

