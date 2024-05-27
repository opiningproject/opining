@extends('layouts.app')

@section('content')
<div class="main">
    <div class="main-view">
        <div class="container-fluid bd-gutter bd-layout">
            @include('layouts.admin.side_nav_bar')

            <main class=" order-1 w-100">
                <div class="main-content">
                    <div class="section-page-title mb-0">
                        <h1 class="page-title">{{ trans('rest.coupons.title') }}</h1>
                        <div class="col text-end">
                            <div class="form-group mb-0">
                                <a class="btn btn-outline-secondary border-light btn-default me-4 btn-box-shadow"
                                   href="{{ route('claimHistoryLog') }}">
                                    <img class="svg" src="{{ asset('images/claim-history.svg') }}" alt="" height="20" width="20">
                                    <span class="align-middle ms-3">{{ trans('rest.coupons.claim_history') }}</span>
                                </a>
                                <a class="btn btn-custom-yellow btn-default btn-box-shadow" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#addCouponModal">
                                    <img src="{{ asset('images/add.svg') }}" alt="" height="20" width="20" class="svg">
                                    <span class="align-middle ms-3">{{ trans('rest.coupons.add') }}</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- start coupons card section -->
                    <section class="custom-section">
                        <div class="coupon-card-grid">
                            @foreach($coupons as $key => $coupon)
                            <input type="hidden" id="id" value="{{ $coupon->id }}">
                            <div class="card editdish-card coupons-card">
                                <div class="card-body pb-0">
                                    <div class="card-custom-header d-flex align-items-center justify-content-between">
                                        <div class="form-check form-switch custom-switch justify-content-center ps-0">
                                            <input class="form-check-input" type="checkbox" role="switch" {{ $coupon->status ? 'checked':'' }}>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <a class="btn btn-custom-yellow btn-icon me-2" tabindex="0" href="javascript:void(0);" id="coupon-edit-btn" onclick="editCoupon({{ $coupon->id }})">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <a class="btn btn-custom-yellow btn-icon" data-bs-toggle="modal" data-bs-target="#deleteCouponModal" onclick="deleteCoupon({{ $coupon->id }})">
                                                <i class="fa-regular fa-trash-can"></i>
                                            </a>
                                        </div>
                                    </div>
                                    <div class="inner-card">
                                        <div class="inner-card-body">
                                            <h3>{{ $coupon->percentage_off }}<sup>%</sup><sub>{{ trans('rest.coupons.off') }}</sub></h3>
                                            <h6>{{ trans('rest.coupons.per_off') }}</h6>
                                            <div class="dotted-divider"></div>
                                            <p class="valid-date mb-0">{{ trans('rest.coupons.valid_until') }} {{ $coupon->end_expiry_date }}</p>
                                        </div>
                                        <div class="promocode-box">
                                            <p class="mb-0 d-inline-block">{{ trans('rest.coupons.promo_code') }}</p>
                                            <span class="badge text-bg-white d-inline-block">{{ $coupon->promo_code }}</span>
                                        </div>
                                        <div class="circle1"></div>
                                        <div class="circle2"></div>
                                    </div>

                                </div>
                                <div class="card-footer bg-white border-0">
                                    <p class="mb-0 text-center coupons-card-footer-text text-truncate">{{ $coupon->description }}</p>
                                </div>
                            </div>
                            @endforeach
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
<div class="modal fade custom-modal" id="addCouponModal" tabindex="-1" aria-labelledby="addCouponModal" aria-hidden="true">
    <div class="modal-dialog custom-w-441px modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h1 class="modal-title mb-0">{{ trans('rest.coupons.add') }}</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" id="coupon-form">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="points" class="form-label">{{ trans('rest.coupons.points') }}</label>
                                <input type="number" class="form-control" id="points" name="points" min="1" max="1000">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="price" class="form-label">{{ trans('rest.coupons.min_order_price') }}</label>
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon1">€</span>
                                    <input type="text" class="form-control" id="price" min="1" name="price" required/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="promocode" class="form-label">{{ trans('rest.coupons.promo_code') }}</label>
                                <input type="text" class="form-control" id="promo_code" name="promo_code" maxlength="20" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="percentageofoff" class="form-label">{{ trans('rest.coupons.per_off') }}</label>
                                <input type="number" class="form-control" id="percentage_off" name="percentage_off" min="1" max="100" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="percentageofoff" class="form-label">{{ trans('rest.coupons.validity_date') }}</label>
                                <div class="input-group dateselect-group date">
                                    <span class="input-group-text" id="basic-addon1">
                                         <img class="svg" src="{{ asset('images/calendar.svg') }}" height="20" width="20">
                                    </span>
                                    <input type="text" class="form-control" id="expiry_date" aria-label="dateofbirth" aria-describedby="basic-addon1" name="expiry_date" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group mb-0">
                                <label for="newpassword" class="form-label">{{ trans('rest.coupons.description') }}</label>
                                <textarea class="form-control" rows="3" id="description" name="description" maxlength="200" required></textarea>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" id="id" value="">
                    <button type="submit" class="btn btn-custom-yellow fw-400 text-uppercase font-sebibold w-100 mt-30px" id="coupon-save-btn">{{ trans('rest.button.save') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- end add coupon  Modal -->

<div class="modal fade custom-modal" id="deleteCouponModal" tabindex="-1" aria-labelledby="dleteAlertModal" aria-hidden="true">
    <div class="modal-dialog custom-w-441px modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <h4 class="alert-text-1 mb-40px">{{ trans('rest.modal.coupon.delete_message') }}</h4>
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <button type="button" class="btn btn-outline-secondary fw-400 text-uppercase font-sebibold w-160px" data-bs-dismiss="modal">
                    {{ trans('rest.button.cancel') }}</button>
                    <button type="button" class="btn btn-custom-yellow fw-400 text-uppercase font-sebibold w-160px" id="coupon-delete-btn">{{ trans('rest.button.delete') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
    <script type="text/javascript" src="{{ asset('js/coupons.js')}}"></script>
@endsection
