@extends('layouts.app')

@section('content')
<div class="main">
    <div class="main-view">
        <div class="container-fluid bd-gutter bd-layout bg-light">
            @include('layouts.admin.side_nav_bar')

            <main class="order-1 w-100">
                <div class="main-content">
                    <div class="section-page-title mb-0">
                        <h1 class="page-title">{{ trans('rest.my_website.title') }}</h1>
                    </div>

                    <!-- start Setting section -->
                    <section class="custom-section">
                        <div class="customize-tab setting-tab horizontal_tab_setting">
                            <ul class="nav nav-tabs flex-wrap" id="myTab" role="tablist">
                                <li class="empty_space"></li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="restaurantProfile-tab" data-bs-toggle="tab" data-bs-target="#restaurantProfile-tab-pane" type="button" role="tab" aria-controls="restaurantProfile-tab-pane" aria-selected="false">
                                        {{ trans('rest.my_website.banners.title') }}
                                    </button>
                                </li>
                            </ul>

                            <div class="tab-content card editdish-card setting-tab-content" id="myTabContent">
                                @include('admin.my-website.banners.index')
                            </div>
                        </div>
                    </section>
                    <!-- end Setting section -->
                </div>
            </main>
        </div>
    </div>
    <!-- start footer -->
    @include('layouts.admin.footer_design')
    <!-- end footer -->
</div>
@endsection
@section('script')
    <script type="text/javascript" src="{{ asset('js/banners.js')}}"></script>
@endsection
