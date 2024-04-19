@extends('layouts.app')

@section('content')
<div class="main">
    <div class="main-view">
        <div class="container-fluid bd-gutter bd-layout">
            @include('layouts.admin.side_nav_bar')

            <main class=" order-1 w-100">
                <div class="main-content">
                    <div class="section-page-title main-page-title mb-0">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                <h1 class="page-title">{{ trans('rest.menu.dishes') }}</h1>
                            </div>
                        </div>
                    </div>

                    <!-- start edit dish card section -->
                    <section class="custom-section">
                        <div class="card editdish-card ingredients-card">
                            <div class="card-header border-0 bg-white border-bottom-0">
                                <div class="row">
                                    <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                        <nav class="page-breadcrumb" aria-label="breadcrumb">
                                            <ol class="breadcrumb">
                                                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ trans('rest.menu.title') }}</a>
                                                </li>
                                                <li class="breadcrumb-item active">{{ trans('rest.menu.dishes') }}</li>
                                            </ol>
                                        </nav>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-0">
                                <div class="add-edit-dish-table custom-table ingredients-table">
                                        @include('admin.dish.dish-list')
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center" style="padding: 0 15px 15px 15px">
                                {{ $dishes->links() }}
                                <div>
                                    <label>{{ trans('rest.button.rows_per_page') }}</label>
                                    <select id="per_page_dropdown" onchange="">
                                        <option {{ $perPage == 5 ? 'selected' : '' }} value="{{ Request::url().'?per_page=5' }}">5</option>
                                        <option {{ $perPage == 10 ? 'selected' : '' }} value="{{ Request::url().'?per_page=10' }}">10</option>
                                        <option {{ $perPage == 15 ? 'selected' : '' }} value="{{ Request::url().'?per_page=15' }}">15</option>
                                        <option {{ $perPage == 20 ? 'selected' : '' }} value="{{ Request::url().'?per_page=20' }}">20</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- end edit dish card section -->
                </div>
            </main>
        </div>
    </div>
    <!-- start footer -->
    @include('layouts.admin.footer_design')
    <!-- end footer -->
</div>
<!-- start delete dish Modal -->
<div class="modal fade custom-modal" id="deleteDishAlertModal" tabindex="-1" aria-labelledby="dleteAlertModal" aria-hidden="true">
    <div class="modal-dialog custom-w-441px modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <input type="hidden" value="" id="dishId">
                <div class="row">
                    <div class="col-12">
                        <h4 class="alert-text-1 mb-40px">{{ trans('rest.modal.category.delete_message') }}</h4>
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <button type="button" class="btn btn-outline-secondary fw-400 text-uppercase font-sebibold w-160px" data-bs-dismiss="modal">
                        {{ trans('rest.button.cancel') }}
                    </button>
                    <button type="button" id="delete-dish-btn" class="btn btn-custom-yellow fw-400 text-uppercase font-sebibold w-160px">
                        {{ trans('rest.button.delete') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end delete dish Modal -->
@endsection

@section('script')
    <script type="text/javascript" src="{{ asset('js/dish-home-operations.js')}}"></script>
@endsection
