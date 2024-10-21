@extends('layouts.user-app')
@section('content')
    <div class="main">
        <div class="main-view">
            <div class="container-fluid bd-gutter bd-layout">
                @include('layouts.user.side_nav_bar')
                <main class="bd-main content-main-part">
                    <div class="main-content">
                        <div class="section-page-title main-page-title row justify-content-between">
                            <div class="col-xxl-6 col-xl-6 col-lg-5 col-md-6 col-sm-6 col-12  title-search-mobile">
                                <h1 class="page-title">{{ trans('user.dashboard.title') }} new</h1>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <!-- start footer -->
        @include('layouts.user.footer_design')
        <!-- end footer -->
    </div>

{{--    @include('user.modals.address')--}}
{{--    @include('user.modals.customize-dish')--}}
@endsection

@section('script')
    <script>
        var app_name = '{!! env('APP_NAME') !!}'
    </script>
{{--    <script type="text/javascript" src="{{ asset('js/user/dashboard.js') }}"></script>--}}
@endsection
