@extends('layouts.app')
@section('page_title', 'Customers')
@section('content')

    <div class="main-content">
        <div class="section-page-title mb-0 d-flex align-items-center justify-content-between gap-2 order-page-bar">

            <div class="d-flex align-items-center btn-grp-gap-10 btn-grp-tab">
                <button type="button"
                        class="btn btn-site-theme d-flex align-items-center gap-3 justify-content-center"
                        style="min-width: auto"><img src="{{ asset('images/customer.svg') }}"
                                                     class="svg" height="20" width="20" /> Customers</button>

                <button type="button"
                        class="btn bg-white text-black d-flex align-items-center gap-3 justify-content-center"
                        style="min-width: auto">
                    <img src="{{ asset('images/email.svg') }}" class="svg" height="20"
                         width="20" /> E-mails</button>
            </div>

            {{-- <h1 class="page-title me-auto">{{ trans('rest.food_order.orders') }} <span
                    class="count count-order"> {{ getOpenOrders() }} </span></h1> --}}


            <div class="btn-grp btn-grp-gap-10 d-flex align-items-center flex-wrap" id="order-dilters">
                <div class="header-filter-order d-flex align-items-center flex-wrap">

                    <div class="drop_with_search">
                        <div class="search-has col order-filters-search">
                            <span class="fa fa-search form-control-feedback"></span>
                            <input type="text" class="form-control" id="search-order-new"
                                   value="{{ request()->query('search', '') }}" placeholder="Search">
                        </div>
                    </div>
                </div>
                <div class="add-customer customer-create">
                    <a class="btn m-auto btn-site-theme" data-id="1" tabindex="0">
                        Add Customer
                    </a>
                </div>

            </div>
        </div>

        <div class="order-content-container">
            @include('layouts.admin.side_nav_bar')
            <section class="custom-section">
                <div class="card editdish-card ingredients-card">
                    <div class="card-header border-0 bg-white border-bottom-0">
                        <div class="row">
                            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">

                            </div>
                        </div>
                    </div>

                    <div class="card-body pt-0">
                        <div class="add-edit-dish-table custom-table ingredients-table">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th scope="col" class="text-left">{{ trans('rest.deliverers.name') }}</th>
{{--                                    <th scope="col" class="text-center">{{ trans('rest.deliverers.last_name') }}</th>--}}
{{--                                    <th scope="col" class="text-center">Street</th>--}}
{{--                                    <th scope="col" class="text-center">Zip Code</th>--}}
{{--                                    <th scope="col" class="text-center">City</th>--}}
                                    <th scope="col" class="text-left">{{ trans('rest.deliverers.email') }}</th>
                                    <th scope="col" class="text-left">{{ trans('rest.deliverers.phone') }}</th>
                                    <th scope="col" class="text-left">Address</th>
                                    <th scope="col" class="text-left">Orders</th>
                                    <th scope="col" class="text-left">Total</th>
                                    <th scope="col" class="text-left">{{ trans('rest.button.action') }}</th>
                                </tr>
                                </thead>
                                <tbody id="delivererTbody">
                                {{--                                            @foreach ($delivererUser as $deliverers)--}}
                                @for($i = 0; $i < 3; $i++ )
                                <tr id="deliverer-tr-$deliverers_id" draggable="true"
                                    class="delivererRow" data-id="1">
                                    <td class="text-left">
                                        <lable class="text-center m-auto" id="first_name1"> Serdar Orman </lable>
                                    </td>
                                    <td class="text-left">
                                        <lable class="text-center m-auto" id="email"> serdarorman74@gmail.com </lable>
                                    </td>

                                    <td class="text-left">
                                        <lable class="text-center m-auto" id="phone"> 0614522453 </lable>
                                    </td>

                                    <td class="text-left">
                                        <select class="form-control">
                                            <option> Tochtstraat 40  3036SK Rotterdam </option>
                                            <option> Tochtstraat 40  3036SK Rotterdam </option>
                                            <option> Tochtstraat 40  3036SK Rotterdam </option>
                                            <option> Tochtstraat 40  3036SK Rotterdam </option>
                                            <option> Tochtstraat 40  3036SK Rotterdam </option>
                                            <option> Tochtstraat 40  3036SK Rotterdam </option>
                                        </select>
                                    </td>

                                    <td class="text-left">
                                        <lable class="text-center m-auto"> 15 </lable>
                                    </td>

                                    <td class="text-left">
                                        <lable class="text-center m-auto"> €722,06 </lable>
                                    </td>

                                    <td class="text-left">
                                        <div class="m-auto">
                                            <a class="btn m-auto btn-site-theme edit-deliverer-icon"
                                               id="edit-btn-1"
                                               data-id="1" tabindex="0">
                                                <i class="fa-regular fa-eye"></i>
                                                Customer Overview
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endfor
                                {{--                                            @endforeach--}}
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            {{--                                        {{ $delivererUser->links() }}--}}
                            <div>
                                <label>{{ trans('rest.button.rows_per_page') }}</label>
                                <select id="per_page_dropdown" onchange="">
                                    @for($i=5; $i<=20; $i+=5)
                                        <option value="{{ $i }}">
                                            {{ $i }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

            </section>
        </div>
    </div>
    @include('admin.manual-order.create-customer-popup')
@endsection
@section('script')
    <script type="text/javascript" src="{{ asset('js/manual-order.js') }}"></script>
    <script>
        var dishValidation = {
            save_btn: '{{ trans('rest.button.save') }}',
        }
    </script>
{{--    <script type="text/javascript" src="{{ asset('js/deliverer.js')}}"></script>--}}
@endsection

