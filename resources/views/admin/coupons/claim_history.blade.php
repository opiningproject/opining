@extends('layouts.app')

@section('content')
<div class="main">
    <div class="main-view">
        <div class="container-fluid bd-gutter bd-layout">
            @include('layouts.admin.side_nav_bar')

            <main class=" order-1 w-100">
                <div class="main-content">
                    <div class="section-page-title mb-0">
                        <h1 class="page-title">{{ trans('rest.coupons.claim_history') }}</h1>
                    </div>

                    <!-- start claim history card section -->
                    <section class="custom-section">
                        <div class="card editdish-card">
                            <div class="card-header border-0 bg-white border-bottom-0">
                                <h3 class="text-custom-muted editdish-card-title mb-0">
                                    <a href="{{ route('coupons.index') }}">{{ trans('rest.coupons.title') }}</a> /
                                    <span class="text-yellow-2">{{ trans('rest.coupons.claim_history') }}
                                    </span>
                                </h3>
                            </div>
                            <div class="card-body pt-0">
                                <div class="rounded-custom-12 border-custom-1 py-3">
                                    <div class="claimhistory-table custom-table ">
                                        <table class="table mb-0">
                                            <thead>
                                            <tr>
                                                <th class="text-center">{{ trans('rest.coupons.order_id') }}</th>
                                                <th class="text-center">{{ trans('rest.coupons.username') }}</th>
                                                <th class="text-center">{{ trans('rest.coupons.date_time') }}</th>
                                                <th class="text-center">{{ trans('rest.coupons.points') }}</th>
                                                <th class="text-center">{{ trans('rest.coupons.order_price') }}</th>
                                                <th class="text-center">{{ trans('rest.coupons.coupon') }}</th>
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

                                        <div class="d-flex justify-content-between align-items-center pt-3" style="padding: 0 20px 0 20px;">
                                            {{ $orders->links() }}
                                            <div class="ms-auto d-flex align-items-center custom-pagination justify-content-end w-100">
                                                <label class="text-nowrap">{{ trans('rest.button.rows_per_page') }}</label>
                                                <select id="per_page_dropdown" onchange="" class="form-control bg-white ms-2">
                                                    @for($i=5; $i<=20; $i+=5)
                                                    <option {{ $perPage == $i ? 'selected' : '' }} value="{{ Request::url().'?per_page=' }}{{ $i }}">
                                                        {{ $i }}
                                                    </option>
                                                    @endfor
                                                </select>
                                            </div>
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
@endsection
