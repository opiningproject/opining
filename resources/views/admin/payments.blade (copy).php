@extends('layouts.app') @section('content') <div class="main">
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
                      <span class="fw-400">€</span>12,890,00
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
                        <span class="fw-400">€</span>12,890,00
                      </div>
                    </div>
                    <div class="btn-grp d-flex flex-wrap align-items-center">
                      <button class="btn active">Monthly</button>
                      <button class="btn">Weekly</button>
                      <button class="btn">Year</button>
                    </div>
                  </div>
                  <div class="income-diagrams-item-img h-100">
                    <img src="images/take-graph-1-min.png" alt="img" class="img-fluid">
                  </div>
                </div>
                <div class="income-diagrams-item d-flex flex-column gap-3">
                  <div class="income-diagrams-item-header d-flex align-items-center justify-content-between">
                    <div class="title">Income</div>
                    <div class="btn-grp d-flex flex-wrap align-items-center">
                      <button class="btn active">Monthly</button>
                      <button class="btn">Weekly</button>
                      <button class="btn">Year</button>
                    </div>
                  </div>
                  <div class="income-diagrams-item-img h-100">
                    <img src="images/take-graph-2-min.png" alt="img" class="img-fluid">
                  </div>
                </div>
                <div class="income-diagrams-item d-flex flex-column gap-3">
                  <div class="income-diagrams-item-header d-flex align-items-center justify-content-between">
                    <div class="title">Income</div>
                    <div class="btn-grp d-flex flex-wrap align-items-center">
                      <button class="btn active">Monthly</button>
                      <button class="btn">Weekly</button>
                      <button class="btn">Year</button>
                    </div>
                  </div>
                  <div class="income-diagrams-item-img h-100">
                    <img src="images/take-graph-3-min.png" alt="img" class="img-fluid">
                  </div>
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