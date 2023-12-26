@extends('layouts.app')

@section('content')
    <div class="main">
        <div class="main-view">
            <div class="container-fluid bd-gutter bd-layout">
                @include('layouts.admin.side_nav_bar')

                <main class=" order-1 w-100">
                    <div class="main-content">
                        <div class="section-page-title mb-0">
                            <h1 class="page-title">Claim History</h1>
                        </div>

                        <!-- start claim history card section -->
                        <section class="custom-section">
                            <div class="card editdish-card">
                                <div class="card-header border-0 bg-white border-bottom-0">
                                    <h3 class="text-custom-muted editdish-card-title mb-0">
                                        <a href="{{ route('coupons.index') }}">Coupons</a> /
                                        <span class="text-yellow-2">Claim History
                                        </span>
                                    </h3>
                                </div>
                                <div class="card-body pt-0">
                                    <div class="rounded-custom-12 border-custom-1 py-3">
                                        <div class="claimhistory-table custom-table ">
                                            <table class="table mb-0">
                                                <thead>
                                                <tr>
                                                    <th class="text-center">Order Id</th>
                                                    <th class="text-center">Username</th>
                                                    <th class="text-center">Date & Time</th>
                                                    <th class="text-center">Points</th>
                                                    <th class="text-center">Order Price</th>
                                                    <th class="text-center">Coupon</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($orders as $key => $order)
                                                    <tr>
                                                        <td class="text-center"><span class="text-muted-1">{{ $order->id }}</span></td>
                                                        <td class="text-center"><span class="text-muted-1">{{ $order->user->full_name }}</span></td>
                                                        <td class="text-center"><span class="text-muted-1">{{ date('d M Y | H:m A',strtotime($order->created_at)) }}</span></td>
                                                        <td class="text-center"><span class="text-muted-1">{{ $order->points }}</span></td>
                                                        <td class="text-center"><span class="text-muted-1">€{{ $order->total_amount }}</span></td>
                                                        <td class="text-center"><span class="text-muted-1">€{{ $order->coupon_discount }}</span></td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            <div>
                                                <nav class="table-pagination" aria-label="Page navigation example">
                                                    <ul class="pagination mb-0">
                                                        <li class="page-item me-2">
                                                            <a class="page-link" href="javascript:void(0);"
                                                               aria-label="Previous">
                                                                <span aria-hidden="true"><i
                                                                        class="fa-solid fa-angle-left"></i></span>
                                                            </a>
                                                        </li>
                                                        <li class="page-item labelactive">01</a></li>
                                                        <li class="page-item">of</a></li>
                                                        <li class="page-item">05</a></li>
                                                        <li class="page-item ms-2">
                                                            <a class="page-link" href="javascript:void(0);"
                                                               aria-label="Next">
                                                                <span aria-hidden="true"><i
                                                                        class="fa-solid fa-angle-right"></i></span>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                    <div class="pagenumberdp d-flex align-items-center">
                                                        <p class="mb-0">Rows Per page</p>
                                                        <div class="dropdown">
                                                            <button class="btn dropdown-toggle pagination-dropdown-value" value="15" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                15
                                                            </button>
                                                            <ul class="dropdown-menu">
                                                                <li><button class="dropdown-item" type="button">30</button></li>
                                                                <li><button class="dropdown-item" type="button">50</button></li>
                                                                <li><button class="dropdown-item" type="button">100</button></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </nav>
                                            </div>
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
        @include('layouts.admin.footer_design')
        <!-- end footer -->
    </div>


    <!-- start add coupon Modal -->
    <div class="modal fade custom-modal" id="addCouponModal" tabindex="-1" aria-labelledby="addCouponModal"
         aria-hidden="true">
        <div class="modal-dialog custom-w-441px modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h1 class="modal-title mb-0">Add Coupon</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="points" class="form-label">Points</label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="price" class="form-label">Price</label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="promocode" class="form-label">Promo Code</label>
                                    <input type="text" class="form-control" maxlength="50">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="percentageofoff" class="form-label">Percentage of OFF</label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="percentageofoff" class="form-label">Validity date</label>
                                    <div class="prev-default-input-group">
                                        <span class="input-group-icon">
                                            <img src="{{ asset('images/calender-icon.svg')}}" alt="calender-icon" class="img-fluid">
                                        </span>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group mb-0">
                                    <label for="newpassword" class="form-label">Confirm New Password</label>
                                    <input type="text" class="form-control">
                                </div>
                            </div>
                        </div>
                        <button type="button"
                                class="btn btn-custom-yellow fw-400 text-uppercase font-sebibold w-100 mt-30px">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end add coupon  Modal -->
@endsection
