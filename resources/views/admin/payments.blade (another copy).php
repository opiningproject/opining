@extends('layouts.app') 
@section('content') 

<style>
    [pointer-events="bounding-box"] {
    display: none
}
</style>
<script type="text/javascript" src="{{ asset('js/fusioncharts.js') }}"></script>
<script type="text/javascript" src="https://cdn.fusioncharts.com/fusioncharts/latest/themes/fusioncharts.theme.fusion.js"></script>

<div class="main">
  <div class="main-view">
    <div class="container-fluid bd-gutter bd-layout"> 
        @include('layouts.admin.side_nav_bar') 
        <main class="bd-main order-1 w-100 position-relative">
            <div class="main-content">
              <div class="section-page-title mb-0">
                <h1 class="page-title">My Finance</h1>
              </div>
              <div class="hero-incomebox bg-white">
                <div class="hero-incomebox-item d-flex align-items-center">
                  <img src="{{ asset('images/totalincome-icon-up.svg') }}" alt="img" class="img-fluid svg" width="90" height="90">
                  <div class="text-grp d-flex flex-column gap-2">
                    <div class="title">Total Income</div>
                    <div class="number">
                      <span class="fw-400">€</span>{{ $totalIncome }}
                    </div>
                  </div>
                </div>
              </div>
              <div class="income-diagrams d-flex flex-wrap justify-content-between">
                  <div class="income-diagrams-item d-flex flex-column gap-5">
                      <div class="income-diagrams-item-header d-flex align-items-center justify-content-between">
                          <div class="text-grp d-flex flex-column gap-1">
                              <div class="title">Total Income</div>
                              <div class="number">
                                  <span class="fw-400">€</span>{{$totalIncome}}
                              </div>
                          </div>
                          <div class="btn-grp d-flex flex-wrap align-items-center">
                              <button class="btn active incomeChartBtn" value="monthlyIncomeChart">Monthly</button>
                              <button class="btn incomeChartBtn" value="weeklyIncomeChart">Weekly</button>
                              <button class="btn incomeChartBtn" value="yearlyIncomeChart">Year</button>
                          </div>
                      </div>
                      <div id="monthly-chart-container" class="monthlyIncomeChart">Chart will render here!</div>
                      <div id="weekly-chart-container" class="weeklyIncomeChart">Chart will render here!</div>
                      <div id="yearly-chart-container" class="yearlyIncomeChart">Chart will render here!</div>
                  </div>
                  <?php
                      $arrChartConfig = array(
                          "chart" => array(
                              "numberSuffix" => "K",
                              "theme" => "fusion",
                              "yAxisMaxValue" => "100",
                              'paletteColors' => '#FFC00B',
                              "xAxisValuesPadding" => "200"
                          )
                      );

                      // Monthly chart
                      $arrChartConfig["data"] = $totalMonthOrders;
                      $jsonEncodedData = json_encode($arrChartConfig);

                      $chart = new FusionCharts("column2d", "monthly-chart", "1200", "400", "monthly-chart-container", "json", $jsonEncodedData);
                      $chart->render();

                      // Weekly chart
                      $arrChartConfig["data"] = $totalWeekOrders;
                      $jsonEncodedData1 = json_encode($arrChartConfig);

                      $chart = new FusionCharts("column2d", "weekly-chart", "1200", "400", "weekly-chart-container", "json", $jsonEncodedData1);
                      $chart->render();

                      // Yearly chart
                      $arrChartConfig["data"] = $totalYearOrders;
                      $jsonEncodedData2 = json_encode($arrChartConfig);

                      $chart = new FusionCharts("column2d", "yearly-chart", "1200", "400", "yearly-chart-container", "json", $jsonEncodedData2);
                      $chart->render();
                  ?>

                  <div class="income-diagrams-item d-flex flex-column gap-3">
                    <div class="income-diagrams-item-header d-flex align-items-center justify-content-between">
                      <div class="title">Income</div>
                      <div class="btn-grp d-flex flex-wrap align-items-center">
                        <button class="btn active doughnutChart" value="monthlyDoughnutChart">Monthly</button>
                        <button class="btn doughnutChart" value="weeklyDoughnutChart">Weekly</button>
                        <button class="btn doughnutChart" value="yearlyDoughnutChart">Year</button>
                      </div>
                    </div>

                    <div class="float-container">
                      <div class="row">
                         <div class="col-12 mb-2">
                             <div class="d-flex chart-indicates">
                               <div class="indicate"><label></label> Online</div>
                               <div class="indicate low"><label></label> COD</div>
                             </div>
                         </div>
                      </div>
                      <div class="row">
                         <div class="col-md-6 mb-2">
                           <div class="float-child monthlyDoughnutChart" id="online-delivery-container">FusionCharts XT will load here!</div>
                           <div class="float-child weeklyDoughnutChart" id="online-delivery-container">FusionCharts XT will load here!</div>
                           <div class="float-child yearlyDoughnutChart" id="online-delivery-container">FusionCharts XT will load here!</div>
                         </div>
                         <div class="col-md-6 mb-2">
                            <div class="float-child monthlyDoughnutChart" id="take-away-container">FusionCharts XT will load here!</div>
                            <div class="float-child weeklyDoughnutChart" id="take-away-container">FusionCharts XT will load here!</div>
                            <div class="float-child yearlyDoughnutChart" id="take-away-container">FusionCharts XT will load here!</div>  
                         </div>
                      </div>
                    </div>  

                    <?php
                      $chartConfig = array(
                          "chart" => array(
                              "caption"=> "Online Delivery Income",
                              "startingAngle"=> "210",
                              "decimals"=> "0",
                              "theme"=> "fusion",
                              "valuePosition"=> "inside",
                              "palettecolors"=> "#FFC00B,#FFE9A8"
                          )
                      );
                      
                      $arrChartData = array(["75"],[ "25"]);
                      $arrLabelValueData = array();

                      for($i = 0; $i < count($arrChartData); $i++) 
                      {
                          array_push($arrLabelValueData, array(
                              "value" => $arrChartData[$i][0]
                          ));
                      }

                      $chartConfig["data"] = $arrLabelValueData;
                      $jsonEncodedData = json_encode($chartConfig);

                      $chartConfig['chart']['caption'] = "Take Away Income";
                      $jsonEncodedData1 = json_encode($chartConfig);

                      $chart = new FusionCharts("doughnut2d", "delivery-chart" , "350", "350", "online-delivery-container", "json", $jsonEncodedData);
                      $chart->render();

                      $chart = new FusionCharts("doughnut2d", "take-away-chart" , "350", "350", "take-away-container", "json", $jsonEncodedData1);
                      $chart->render();
                    ?>
                  </div>

                  <div class="income-diagrams-item d-flex flex-column gap-3">
                    <div class="income-diagrams-item-header d-flex align-items-center justify-content-between">
                      <div class="title">Total Revenue</div>
                      <div class="btn-grp d-flex flex-wrap align-items-center">
                        <button class="btn active">Monthly</button>
                        <button class="btn">Weekly</button>
                        <button class="btn">Year</button>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-12 mb-2">
                           <div class="d-flex chart-indicates">
                                 <div class="indicate"><label></label> Delivery</div>
                                 <div class="indicate low"><label></label> Take Away</div>
                           </div>
                      </div>
                    </div>

                    <div class="income-diagrams-item-img h-100">
                      <div id="yearly">FusionCharts XT will load here!</div>
                    </div>

                    <?php

                    $columnChart2 = new FusionCharts("msspline", "ex3", "750", "300", "yearly", "json", '{
                    "chart": {
                        "numdivlines": "3",
                        "numberSuffix" : "K",
                        "theme":"fusion",
                        "palettecolors": "#FFC00B,#FFE9A8",
                        "legendPosition":"top-left",
                        "legendIconSides":"4",
                        "showplotBorder": "1",
                        "legendIconBgColor":"#FF8300",
                        "drawAnchors":"0",
                        "legendBorderColor":"#FBC490",
                    },
                    "categories": [
                        {
                        "category": [
                            {
                                "label": "2021"
                            },
                            {
                                "label": "2022"
                            },
                            {
                                "label": "2023"
                            },
                            {
                                "label": "2024"
                            }
                        ]
                        }
                      ],
                      "dataset": [
                        {
                            "data": [
                            {
                                "value": "20k"
                            },
                            {
                                "value": "42k"
                            },
                            {
                                "value": "40k"
                            },
                            {
                                "value": "55k"
                            }
                          ]
                        },
                        {
                            "data": [
                            {
                                "value": "40k"
                            },
                            {
                                "value": "40k"
                            },
                            {
                                "value": "15k"
                            },
                            {
                                "value": "80k"
                            }
                          ]
                        }
                      ]
                    }');

                    $columnChart2->render();
                    ?>
                </div>
              </div>
            </div>
        </main>
    </div>
  </div>
  <!-- start footer --> 
  @include('layouts.admin.footer_design')
  <!-- end footer -->
</div>

@section('script')
<script>

    // 1st income chart
    $(".weeklyIncomeChart").hide();
    $(".yearlyIncomeChart").hide();
    
    $(".incomeChartBtn").click(function(){
        $(".monthlyIncomeChart").hide();
        $(".weeklyIncomeChart").hide();
        $(".yearlyIncomeChart").hide();
        $(".incomeChartBtn").removeClass('active');
        
        $(this).addClass('active');
        var k= $(this).val();
        $("."+k).show();
    });

    // 1st income chart
    $(".weeklyIncomeChart").hide();
    $(".yearlyIncomeChart").hide();
    
    $(".incomeChartBtn").click(function(){
        $(".monthlyIncomeChart").hide();
        $(".weeklyIncomeChart").hide();
        $(".yearlyIncomeChart").hide();
        $(".incomeChartBtn").removeClass('active');
        
        $(this).addClass('active');
        var k= $(this).val();
        $("."+k).show();
    });
</script>
@endsection