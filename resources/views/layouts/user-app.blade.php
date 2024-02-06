<?php $theme = \Request::session()->get('theme'); ?>

    <!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="{{ $theme }}">
@include('layouts.user.header')
<body>

<div class="position-fixed inset-0 bg-transparent-layer d-none" id="loader">
    <img src="{{ asset('images/loader.gif') }}" style="height: 250px">
</div>

@yield('content')

@if($theme == 'dark')
    <a href="{{ url('/change-theme/light') }}">
        <div class="dark-light-btn p-3 cursor-pointer">
            <img src="{{ asset('images/light-theme.svg') }}" alt="" height="240" width="240" class="svg">
        </div>
    </a>
@else
    <a href="{{ url('/change-theme/dark') }}">
        <div class="dark-light-btn p-3 cursor-pointer">

            <img src="{{ asset('images/dark-theme.svg') }}" alt="" height="20" width="20" class="svg">
        </div>
    </a>
@endif

@if(!Auth::user())
    @include('user.modals.signup')
    @include('user.modals.forgot-password')
@endif

@include('user.modals.signin')
@include('layouts.user.footer')
@yield('script')
</body>
</html>
