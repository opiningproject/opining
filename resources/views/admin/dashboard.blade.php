@extends('layouts.app') @section('content')
    <div class="main">
        <div class="main-view">
            <div class="container-fluid bd-gutter bd-layout">
                @include('layouts.admin.side_nav_bar')
                <main class="w-100">
                    <div class="main-content">
                        <div class="dashboard-container">
                            <div class="container">
                                <div class="row mb-4 align-items-center">
                                    <div class="col-md-6 mb-2">
                                        <div class="logo-details d-flex align-items-center gap-3">
                                            <img src="images/dash-logo.png" alt="" />
                                            <div class="res-det">
                                                <h1 class="mb-0">Restaurant name</h1>
                                                <p class="mb-0">E-mail account</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-2">
                                        <div class="text-right d-flex align-items-center justify-content-end gap-3">
                                            <div class="domain-details">
                                                <a href="#" class="m-url">www.salerno.nl</a>
                                                <a href="#">domain settings</a>
                                            </div>

                                            <div class="icon-link">
                                                <img src="images/link-icon.svg" alt="" width="47"
                                                    height="47" />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="dashboard-action-head mb-2">
                                    <div class="row">
                                        <div class="col mb-2">
                                            <h2>Quick Statistics</h2>
                                        </div>
                                        <div class="col ml-auto text-end mb-2">
                                            <div class="dropdown">
                                                <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    Today
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a class="dropdown-item" href="#">Action</a></li>
                                                    <li><a class="dropdown-item" href="#">Another action</a></li>
                                                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="dashboard-inn-box">
                                    <div class="row">
                                        <div class="col col-md-3 mb-2">
                                            <div class="dt-box">
                                                <h3>Total visitors</h3>
                                                <div class="text-center">
                                                    <h4>1000</h4>
                                                    <h3 class="roi">+12%</h3>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col col-md-3 mb-2">
                                            <div class="dt-box">
                                                <h3>total Orders</h3>
                                                <div class="text-center">
                                                    <h4>100</h4>
                                                    <h3 class="roi">+9%</h3>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col col-md-3 mb-2">
                                            <div class="dt-box">
                                                <h3>Conversion Rate</h3>
                                                <div class="text-center">
                                                    <h4>10%</h4>
                                                    <h3 class="roi danger">-2%</h3>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col col-md-3 mb-2">
                                            <div class="dt-box">
                                                <h3>New Customers</h3>
                                                <div class="text-center">
                                                    <h4>9</h4>
                                                    <h3 class="roi">+0%</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <p class="text-end"><a href="#" class="see-more">See more </a></p>
                                </div>

                                <div class="plans-section mb-4">
                                    <div class="dashboard-action-head mb-2">
                                        <div class="row">
                                            <div class="col mb-2">
                                                <h2>Account details</h2>
                                            </div>
                                        </div>

                                        <div class="card-box mb-3">
                                            <h3 class="mb-0">Basic Plan&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;Monthly</h3>
                                            <a href="#" class="btn btn-outline-success">Active</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="plans-section mb-4">
                                    <div class="dashboard-action-head mb-2">
                                        <div class="row">
                                            <div class="col mb-2">
                                                <h2>New at opining</h2>
                                            </div>
                                        </div>

                                        <div class="card-box mb-3">
                                            <h3 class="mb-0">Our system is updated with new features!</h3>
                                            <a href="#" class="btn btn-outline-secondary">Read More</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <!-- start footer --> @include('layouts.admin.footer_design')
        <!-- end footer -->
    </div>
@endsection
