@extends('layouts.app')
@section('content')

    <?php
    $monthlyAmount = array_sum(array_map(function($item) {
        return $item['value'];
    }, $totalMonthOrders));

    $weeklyAmount = array_sum(array_map(function($item) {
        return $item['value'];
    }, $totalWeekOrders));

    $yearlyAmount = array_sum(array_map(function($item) {
        return $item['value'];
    }, $totalYearOrders));
        ?>

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
                <h1 class="page-title">{{ trans('rest.my_finance.title') }}</h1>
              </div>
                <input type="hidden" id="weeklyIncomeChart" value="{{ $weeklyAmount }}">
                <input type="hidden" id="monthlyIncomeChart" value="{{ $monthlyAmount }}">
                <input type="hidden" id="yearlyIncomeChart" value="{{ $yearlyAmount }}">
              <div class="hero-incomebox bg-white">
                <div class="hero-incomebox-item d-flex align-items-center">
                  <img src="{{ asset('images/totalincome-icon.svg') }}" alt="img" class="img-fluid svg" width="90" height="90">
                  <div class="text-grp d-flex flex-column gap-2">
                    <div class="title">{{ trans('rest.my_finance.total_income') }}</div>
                    <div class="number">
                      <span class="fw-600">€</span>{{ number_format($totalIncome, 2) }}
                    </div>
                  </div>
                </div>
              </div>
              <div class="income-diagrams d-flex flex-wrap justify-content-between">
                  <div class="income-diagrams-item d-flex flex-column gap-5">
                      <div class="income-diagrams-item-header d-flex align-items-center justify-content-between">
                          <div class="text-grp d-flex flex-column gap-1">
                              <div class="title">{{ trans('rest.my_finance.total_income') }}</div>
                              <div class="number">
                                  <span class="fw-600">€</span><span id="chart-fluctuate-amount">{{ number_format($monthlyAmount, 2) }}</span>
                              </div>
                          </div>
                          <div class="btn-grp d-flex flex-wrap align-items-center">
                              <button class="btn active incomeChartBtn" value="monthlyIncomeChart">{{ trans('rest.my_finance.monthly') }}</button>
                              <button class="btn incomeChartBtn" value="weeklyIncomeChart">{{ trans('rest.my_finance.weekly') }}</button>
                              <button class="btn incomeChartBtn" value="yearlyIncomeChart">{{ trans('rest.my_finance.yearly') }}</button>
                          </div>
                      </div>
                      <div id="monthly-chart-container" class="monthlyIncomeChart">{{ trans('rest.my_finance.chart_loading') }}</div>
                      <div id="weekly-chart-container" class="weeklyIncomeChart"></div>
                      <div id="yearly-chart-container" class="yearlyIncomeChart"></div>
                  </div>
                  <?php
                      $arrChartConfig = array(
                          "chart" => array(
                              "numberPrefix"=> "€",
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
                      <div class="title">{{ trans('rest.my_finance.income') }}</div>
                      <div class="btn-grp d-flex flex-wrap align-items-center">
                        <button class="btn active doughnutChartBtn" value="monthlyDoughnutChart">{{ trans('rest.my_finance.monthly') }}</button>
                        <button class="btn doughnutChartBtn" value="weeklyDoughnutChart">{{ trans('rest.my_finance.weekly') }}</button>
                        <button class="btn doughnutChartBtn" value="yearlyDoughnutChart">{{ trans('rest.my_finance.yearly') }}</button>
                      </div>
                    </div>

                    <div class="float-container">
                      <div class="row">
                         <div class="col-12 mb-2">
                             <div class="d-flex chart-indicates">
                               <div class="indicate"><label></label> {{ trans('rest.my_finance.online') }}</div>
                               <div class="indicate low"><label></label> {{ trans('rest.my_finance.cod') }}</div>
                             </div>
                         </div>
                      </div>
                      <div class="row">
                         <div class="col-md-6 mb-2">
                             <div class="chartBox">
                           <div class="float-child monthlyDoughnutChart" id="monthly-online-delivery-container">{{ trans('rest.my_finance.chart_loading') }}</div>
                           <div class="float-child weeklyDoughnutChart" id="weekly-online-delivery-container"></div>
                           <div class="float-child yearlyDoughnutChart" id="yearly-online-delivery-container"></div>
                             <h3 class="text-center chartLabel">{{ trans('rest.my_finance.delivery_income') }}</h3>
                             </div>
                         </div>
                         <div class="col-md-6 mb-2">
                             <div class="chartBox">
                            <div class="float-child monthlyDoughnutChart" id="monthly-take-away-container">{{ trans('rest.my_finance.chart_loading') }}</div>
                            <div class="float-child weeklyDoughnutChart" id="weekly-take-away-container"></div>
                            <div class="float-child yearlyDoughnutChart" id="yearly-take-away-container"></div>
                                 <h3 class="text-center chartLabel">{{ trans('rest.my_finance.take_away_income') }}</h3>
                         </div>
                         </div>
                      </div>
                    </div>

                    <?php
                      $chartConfig = array(
                          "chart" => array(
                              "startingAngle"=> "210",
                              "decimals"=> "0",
                              "theme"=> "fusion",
                              "valuePosition"=> "inside",
                              "palettecolors"=> "#FFC00B,#FFE9A8",
                              "numberPrefix"=> "€",
                          )
                      );

                      // monthly
                      $chartConfig["data"] = $monthlyDeliveryOnlineChartData;
                      $jsonEncodedData = json_encode($chartConfig);

                      //$chartConfig['chart']['caption'] = "Take Away Income";
                      $jsonEncodedData1 = json_encode($chartConfig);

                      $chart = new FusionCharts("doughnut2d", "monthly-delivery-chart" , "350", "350", "monthly-online-delivery-container", "json", $jsonEncodedData);
                      $chart->render();

                      $chartConfig["data"] = $monthlyTAOnlineChartData;
                      $jsonEncodedData = json_encode($chartConfig);

                      $chart = new FusionCharts("doughnut2d", "monthly-take-away-chart" , "350", "350", "monthly-take-away-container", "json", $jsonEncodedData);
                      $chart->render();

                      // weekly
                      $chartConfig["data"] = $weeklyDeliveryOnlineChartData;
                      $jsonEncodedData = json_encode($chartConfig);

                      $chart = new FusionCharts("doughnut2d", "weekly-delivery-chart" , "350", "350", "weekly-online-delivery-container", "json", $jsonEncodedData);
                      $chart->render();

                      $chartConfig["data"] = $weeklyTAOnlineChartData;
                      $jsonEncodedData = json_encode($chartConfig);

                      $chart = new FusionCharts("doughnut2d", "weekly-take-away-chart" , "350", "350", "weekly-take-away-container", "json", $jsonEncodedData);
                      $chart->render();

                      // yearly
                      $chartConfig["data"] = $yearlyDeliveryOnlineChartData;
                      $jsonEncodedData = json_encode($chartConfig);

                      $chart = new FusionCharts("doughnut2d", "yearly-delivery-chart" , "350", "350", "yearly-online-delivery-container", "json", $jsonEncodedData);
                      $chart->render();

                      $chartConfig["data"] = $yearlyTAOnlineChartData;
                      $jsonEncodedData = json_encode($chartConfig);

                      $chart = new FusionCharts("doughnut2d", "yearly-take-away-chart" , "350", "350", "yearly-take-away-container", "json", $jsonEncodedData);
                      $chart->render();
                    ?>
                  </div>

                  <div class="income-diagrams-item d-flex flex-column gap-3">
                    <div class="income-diagrams-item-header d-flex align-items-center justify-content-between">
                      <div class="title"> {{ trans('rest.my_finance.total_revenue') }}</div>
                      <div class="btn-grp d-flex flex-wrap align-items-center">
                        <button class="btn active lineChartBtn" value="monthlyLineChart">{{ trans('rest.my_finance.monthly') }}</button>
                        <button class="btn lineChartBtn" value="weeklyLineChart">{{ trans('rest.my_finance.weekly') }}</button>
                        <button class="btn lineChartBtn" value="yearlyLineChart">{{ trans('rest.my_finance.yearly') }}</button>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-12 mb-2">
                           <div class="d-flex chart-indicates">
                                 <div class="indicate"><label></label> {{ trans('rest.my_finance.delivery') }}</div>
                                 <div class="indicate low"><label></label> {{ trans('rest.my_finance.take_away') }}</div>
                           </div>
                      </div>
                    </div>

                    <div class="income-diagrams-item-img h-100">
                      <div id="monthly" class="monthlyLineChart">{{ trans('rest.my_finance.chart_loading') }}</div>
                      <div id="weekly" class="weeklyLineChart"></div>
                      <div id="yearly" class="yearlyLineChart"></div>
                    </div>

                    <?php
                      $chartConfig = array(
                            "chart" => array(
                                  "numdivlines" => "3",
                                  "numberPrefix"=> "€",
                                  "theme"=>"fusion",
                                  "palettecolors"=> "#FFC00B,#FFE9A8",
                                  "legendPosition"=>"top-left",
                                  "legendIconSides"=>"4",
                                  "showplotBorder"=> "1",
                                  "legendIconBgColor"=>"#FF8300",
                                  "drawAnchors"=>"0",
                                  "legendBorderColor"=>"#FBC490",
                            ),
                        );

                      $lineChartData = json_encode($chartConfig+$monthlyLineChartData);
                      $lineChart = new FusionCharts("msline", "ex2", "700", "300", "monthly", "json",$lineChartData);
                      $lineChart->render();

                      $lineChartData = json_encode($chartConfig+$weeklyLineChartData);
                      $lineChart = new FusionCharts("msline", "ex1", "700", "300", "weekly", "json",$lineChartData);
                      $lineChart->render();


                      $lineChartData = json_encode($chartConfig+$yearlyLineChartData);
                      $lineChart = new FusionCharts("msline", "ex3", "700", "300", "yearly", "json",$lineChartData);
                      $lineChart->render();
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
        $('#chart-fluctuate-amount').text($("#"+k).val());
    });

    // 2nd Doughnut chart
    $(".weeklyDoughnutChart").hide();
    $(".yearlyDoughnutChart").hide();

    $(".doughnutChartBtn").click(function(){
        $(".monthlyDoughnutChart").hide();
        $(".weeklyDoughnutChart").hide();
        $(".yearlyDoughnutChart").hide();

        $(".doughnutChartBtn").removeClass('active');

        $(this).addClass('active');
        var k= $(this).val();

        //alert(k);

        $("."+k).show();
    });

    // 3rd Line chart
    $(".weeklyLineChart").hide();
    $(".yearlyLineChart").hide();

    $(".lineChartBtn").click(function()
    {
        $(".monthlyLineChart").hide();
        $(".weeklyLineChart").hide();
        $(".yearlyLineChart").hide();

        $(".lineChartBtn").removeClass('active');

        $(this).addClass('active');
        var k= $(this).val();

        $("."+k).show();
    });
</script>
@endsection
