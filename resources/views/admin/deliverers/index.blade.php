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
                                    <h1 class="page-title">{{ trans('rest.deliverers.title') }}</h1>
                                </div>
                            </div>
                        </div>

                        <!-- start edit dish card section -->
                        <section class="custom-section">
                            <div class="card editdish-card ingredients-card">
                                <div class="card-header border-0 bg-white border-bottom-0">
                                    <div class="row">
                                        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">

                                        </div>
                                    </div>
                                </div>
                                <div class="card-body py-0">
                                    <form method="POST" name="delivererForm" id="delivererForm">
                                        @csrf
                                        <div class="row delivery-row">
                                            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12 delivery-col">
                                                <div class="form-group">
                                                    <label for="first_name"
                                                           class="form-label">{{ trans('rest.deliverers.first_name') }}</label>
                                                    <input type="text" class="form-control" name="first_name"
                                                           maxlength="250" id="first_name"/>
                                                </div>
                                            </div>
                                            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12 delivery-col">
                                                <div class="form-group">
                                                    <label for="last_name"
                                                           class="form-label">{{ trans('rest.deliverers.last_name') }}</label>
                                                    <input type="text" class="form-control" name="last_name"
                                                           maxlength="250" id="last_name"/>
                                                </div>
                                            </div>
                                            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12 delivery-col">
                                                <div class="form-group">
                                                    <label for="phone"
                                                           class="form-label">{{ trans('rest.deliverers.phone') }}
                                                    </label>
                                                    <input type="text" class="form-control" name="phone"
                                                           maxlength=10 id="phone"/>
                                                </div>
                                            </div>
                                            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12 delivery-col">
                                                <div class="form-group">
                                                    <label for="email"
                                                           class="form-label">{{ trans('rest.deliverers.email') }}
                                                    </label>
                                                    <input type="email" class="form-control" name="email" id="email"/>
                                                </div>
                                            </div>
                                            <div class="col-xxl-2 col-xl-3 col-lg-3 col-md-4 col-sm-6 col-12 delivery-btnCol">
                                                <div class="form-group">
                                                    <label for="discountpercentage" class="form-label">&nbsp;</label>
                                                    <button type="submit"
                                                            class="btn btn-site-theme btn-default d-block w-130px mt-0 save-ing-cat-div">
                                                        <span class="align-middle">{{ trans('rest.button.add') }}</span>
                                                    </button>
                                                </div>
                                            </div>

                                        </div>
                                    </form>
                                </div>

                                <div class="card-body pt-0">
                                    <div class="add-edit-dish-table custom-table ingredients-table">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th scope="col"
                                                    class="text-center">{{ trans('rest.deliverers.first_name') }}
                                                </th>
                                                <th scope="col"
                                                    class="text-center">{{ trans('rest.deliverers.last_name') }}
                                                </th>
                                                <th scope="col"
                                                    class="text-center">{{ trans('rest.deliverers.phone') }}
                                                </th>
                                                <th scope="col"
                                                    class="text-center">{{ trans('rest.deliverers.email') }}
                                                </th>
                                                <th scope="col"
                                                    class="text-center">{{ trans('rest.deliverers.status') }}
                                                </th>

                                                <th scope="col"
                                                    class="text-center">{{ trans('rest.button.action') }}</th>
                                            </tr>
                                            </thead>
                                            <tbody id="delivererTbody">
                                            @foreach ($delivererUser as $deliverers)
                                                {{--                                            <tr id="ing-tr{{ $category->id }}">--}}
                                                <tr id="deliverer-tr{{ $deliverers->id }}" draggable="true"
                                                    class="delivererRow" data-id="{{ $deliverers->id }}">
                                                    <td class="text-center">
                                                        <input type="text" class="form-control text-center m-auto"
                                                               data-id="{{ $deliverers->id }}"
                                                               value="{{ $deliverers->first_name }}"
                                                               id="first_name{{ $deliverers->id }}" readonly/>
                                                    </td>
                                                    <td class="text-center">
                                                        <input type="text" class="form-control text-center m-auto"
                                                               value="{{ $deliverers->last_name }}"
                                                               id="last_name{{ $deliverers->id }}" readonly/>
                                                    </td>
                                                    <td class="text-center">
                                                        <input type="text" class="form-control text-center m-auto"
                                                               data-id="{{ $deliverers->id }}"
                                                               value="{{ $deliverers->phone }}"
                                                               id="phone{{ $deliverers->id }}" readonly/>
                                                    </td>
                                                    <td class="text-center">
                                                        <input type="text" class="form-control text-center m-auto"
                                                               value="{{ $deliverers->email }}"
                                                               id="email{{ $deliverers->id }}" readonly/>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="form-check form-switch custom-switch justify-content-center ps-0">
                                                            <input class="form-check-input" type="checkbox" role="switch" id="deliverer_status_{{ $deliverers->id }}"
                                                                   {{ $deliverers->status ? "checked":"" }} onchange="changeDelivererStatus({{ $deliverers->id }})">
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="d-flex flex-nowrap gap-2">
                                                            <a class="btn btn-site-theme btn-icon edit-deliverer-icon"
                                                               id="edit-btn{{ $deliverers->id }}"
                                                               data-id="{{ $deliverers->id }}" tabindex="0">
                                                                <i class="fa-solid fa-pen-to-square"></i>
                                                            </a>
                                                            <a class="btn btn-site-theme btn-icon del-deliverer-icon"
                                                               id="del-btn{{ $deliverers->id }}"
                                                               data-id="{{ $deliverers->id }}">
                                                                <i class="fa-regular fa-trash-can"></i>
                                                            </a>
                                                            <a class="btn btn-site-theme btn-default save-edit-btn d-block"
                                                               id="save-edit-btn{{ $deliverers->id }}"
                                                               style="width: auto;margin-left: 0px; display: none!important;"
                                                               data-id="{{ $deliverers->id }}">
                                                                <span
                                                                    class="align-middle">{{ trans('rest.button.save') }}</span>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        {{ $delivererUser->links() }}
                                        <div>
                                            <label>{{ trans('rest.button.rows_per_page') }}</label>
                                            <select id="per_page_dropdown" onchange="">
                                                @for($i=5; $i<=20; $i+=5)
                                                    <option
                                                        {{ $perPage == $i ? 'selected' : '' }} value="{{ Request::url().'?per_page=' }}{{ $i }}">
                                                        {{ $i }}
                                                    </option>
                                                @endfor
                                            </select>
                                        </div>
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
    <!-- start delete category Modal -->
    <div class="modal fade custom-modal" id="deleteAlertModal" tabindex="-1"
         aria-labelledby="dleteAlertModal" aria-hidden="true">
        <div class="modal-dialog custom-w-441px modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <input type="hidden" value="" id="catId">
                    <div class="row">
                        <div class="col-12">
                            <h4 class="alert-text-1 mb-40px">{{ trans('rest.modal.deliverer.delete_message') }}</h4>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <button type="button"
                                class="btn btn-outline-secondary fw-400 text-uppercase font-sebibold w-160px"
                                data-bs-dismiss="modal">
                            {{ trans('rest.button.cancel') }}
                        </button>
                        <button type="button" id="delete-deliverer-btn"
                                class="btn btn-site-theme fw-400 text-uppercase font-sebibold w-160px">
                            {{ trans('rest.button.delete') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end delete category Modal -->

    <!-- start delete Ingredients Modal -->
    <div class="modal fade custom-modal" id="deleteAlertModalMsg" tabindex="-1"
         aria-labelledby="deleteAlertModalMsg" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <h4 class="alert-text-1 mb-40px">{{ trans('rest.modal.deliverer.alert_message') }}</h4>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <button type="button" class="btn btn-site-theme fw-400 text-uppercase font-sebibold w-160px"
                                data-bs-dismiss="modal">
                            {{ trans('rest.button.ok') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end delete Ingredients Modal -->
@endsection
@section('script')
    <script>
        var dishValidation = {
            save_btn: '{{ trans('rest.button.save') }}',
        }
    </script>
    <script type="text/javascript" src="{{ asset('js/deliverer.js')}}"></script>
@endsection


