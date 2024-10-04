@extends('layouts.app')
@section('page_title', 'Customers')
@section('content')

    <div class="main-content">
        <div class="section-page-title mb-0 d-flex align-items-center justify-content-between gap-2 order-page-bar">

            <div class="d-flex align-items-center btn-grp-gap-10">
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
                        <div class="select-options">
                            <select class="form-control" id="order-tabs-dropdown">
                                <option value="all" selected>{{ trans('rest.sidebar.all') }}
                                </option>
                                <option value="name">{{ trans('rest.food_order.name') }}</option>
                                <option value="phone_number">{{ trans('rest.food_order.phone_number') }}
                                </option>
                                <option value="address">{{ trans('rest.food_order.address') }}</option>
                                <option value="zip_code">{{ trans('rest.food_order.zip_code') }}</option>
                                <option value="dish">Email</option>
                            </select>
                        </div>
                        <div class="search-has col order-filters-search">
                            <span class="fa fa-search form-control-feedback"></span>
                            <input type="text" class="form-control" id="search-order-new"
                                   value="{{ request()->query('search', '') }}" placeholder="Search">
                        </div>
                    </div>
                </div>
                <button type="button"
                        class="btn bg-white text-black d-flex align-items-center gap-3 justify-content-center order-setting"
                        style="min-width: auto">
                    <img src="{{ asset('images/admin-menu-icons/header-settings.svg') }}" class="svg"
                         height="20" width="20" /> {{ trans('rest.food_order.settings') }}</button>

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
                                    <th scope="col" class="text-center">{{ trans('rest.deliverers.first_name') }}</th>
                                    <th scope="col" class="text-center">{{ trans('rest.deliverers.last_name') }}</th>
                                    <th scope="col" class="text-center">Street</th>
                                    <th scope="col" class="text-center">Zip Code</th>
                                    <th scope="col" class="text-center">City</th>
                                    <th scope="col" class="text-center">{{ trans('rest.deliverers.phone') }}</th>
                                    <th scope="col" class="text-center">{{ trans('rest.deliverers.email') }}</th>
                                    <th scope="col" class="text-center">Orders</th>
                                    <th scope="col" class="text-center">Total</th>
                                    <th scope="col" class="text-center">Block/Unblock</th>
                                    <th scope="col" class="text-center">{{ trans('rest.button.action') }}</th>
                                </tr>
                                </thead>
                                <tbody id="delivererTbody">
                                {{--                                            @foreach ($delivererUser as $deliverers)--}}
                                {{--                                            <tr id="ing-tr{{ $category->id }}">--}}
                                <tr id="deliverer-tr-$deliverers_id" draggable="true"
                                    class="delivererRow" data-id="1">
                                    <td class="text-center">
                                        <input type="text" class="form-control text-center m-auto"
                                               data-id="1"
                                               value="Serdar"
                                               id="first_name1 " readonly/>
                                    </td>
                                    <td class="text-center">
                                        <input type="text" class="form-control text-center m-auto"
                                               value="Orman"
                                               id="last_name1" readonly/>
                                    </td>
                                    <td class="text-center">
                                        <input type="text" class="form-control text-center m-auto"
                                               value="Tochtstraat 40"
                                               id="street" readonly/>
                                    </td>
                                    <td class="text-center">
                                        <input type="text" class="form-control text-center m-auto"
                                               value="3036sk"
                                               id="zip_code" readonly/>
                                    </td>
                                    <td class="text-center">
                                        <input type="text" class="form-control text-center m-auto"
                                               value="Rotterdam"
                                               id="city" readonly/>
                                    </td>
                                    <td class="text-center">
                                        <input type="text" class="form-control text-center m-auto"
                                               data-id="1"
                                               value="0614522453"
                                               id="phone-1" readonly/>
                                    </td>
                                    <td class="text-center">
                                        <input type="text" class="form-control text-center m-auto"
                                               value="serdarorman74@gmail.com"
                                               id="email-1" readonly/>
                                    </td>
                                    <td class="text-center">
                                        <lable class="text-center m-auto"> 15 </lable>
                                    </td>
                                    <td class="text-center">
                                        <lable class="text-center m-auto"> €722,06 </lable>
                                    </td>
                                    <td class="text-center">
                                        <div class="form-check form-switch custom-switch justify-content-center ps-0">
                                            <input class="form-check-input" type="checkbox" role="switch" id="deliverer_status_1"
                                                   checked>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="d-flex flex-nowrap gap-2">
                                            <a class="btn btn-site-theme btn-icon edit-deliverer-icon"
                                               id="edit-btn-1"
                                               data-id="1" tabindex="0">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <a class="btn btn-site-theme btn-icon del-deliverer-icon"
                                               id="del-btn-1"
                                               data-id="1">
                                                <i class="fa-regular fa-trash-can"></i>
                                            </a>
                                            <a class="btn btn-site-theme btn-default save-edit-btn d-block"
                                               id="save-edit-btn1"
                                               style="width: auto;margin-left: 0px; display: none!important;"
                                               data-id="1">
                                                                <span
                                                                    class="align-middle">{{ trans('rest.button.save') }}</span>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
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
                                        <option
                                            value="{{ $i }}">
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
@endsection
@section('script')
    <script>
        var dishValidation = {
            save_btn: '{{ trans('rest.button.save') }}',
        }
    </script>
{{--    <script type="text/javascript" src="{{ asset('js/deliverer.js')}}"></script>--}}
@endsection

