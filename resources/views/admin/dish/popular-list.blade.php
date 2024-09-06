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
                                    <h1 class="page-title">{{ trans('rest.menu.popular_week') }}</h1>
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
                                                    <li class="breadcrumb-item"><a
                                                            href="{{ route('home') }}">{{ trans('rest.menu.title') }}</a>
                                                    </li>
                                                    <li class="breadcrumb-item active">{{ trans('rest.menu.popular_week') }}</li>
                                                </ol>
                                            </nav>
                                        </div>
                                    </div>
                                </div>
                                <div class="bestselling-item-grid">
                                    @if(count($popularDishes) > 0)
                                        @foreach ($popularDishes as $dish_id => $order)
                                            @php
                                                $dish = App\Models\Dish::find($dish_id);
                                            @endphp
                                            <div class="card bestselling-detail-card">
                                                <div class="card-body p-0">
                                                    <div class="food-image">
                                                        <img src="{{ $dish->image }}" alt="burger imag"
                                                             class="img-fluid"/>
                                                    </div>
                                                    <div class="text-start flex-fill">
                                                        <h4 class="food-name-text text-start text-truncate w-100">{{ $dish->name }}</h4>
                                                        <p class="food-price d-inline-block">€{{ $dish->price }}</p>
                                                        <p class="mb-0 sellingpercantage-count d-inline-flex align-items-center">
                                                            @if($order['percentage'] < 0)
                                                                {{ $order['percentage'] }}%
                                                                <img src="{{ asset('images/down-arrow.svg') }}" alt=""
                                                                     class="svg" height="19" width="19">
                                                            @else
                                                                +{{ $order['percentage'] }}%
                                                                <img src="{{ asset('images/up-arrow.svg') }}" alt=""
                                                                     class="svg" height="19" width="19">
                                                            @endif
                                                        </p>
                                                        <p class="lead-1 mb-0">{{ trans('rest.menu.sold_dishes',['sold_qty' => $order['total_orders']]) }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="card-body">
                                            {{ trans('rest.menu.dish.no_popular') }}
                                        </div>
                                    @endif
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
@endsection
