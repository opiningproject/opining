<?php $theme = \Request::session()->get('theme'); ?>

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="{{ $theme }}">
@include('layouts.admin.header')
<body>
<div class="position-fixed inset-0 bg-transparent-layer" style="display:none;" id="loader">
    <img src="{{ asset('images/loader.gif') }}" style="height: 250px">
</div>
@yield('content')

@if($theme == 'dark')
<a href="{{ url('/change-theme/light') }}">
    <div class="dark-light-btn p-3 cursor-pointer">
<<<<<<< Updated upstream
        <img src="{{ asset('images/light-theme.svg')}}">
=======

        <img src="{{ asset('images/light-theme.svg') }}">
>>>>>>> Stashed changes
    </div>
</a>
@else
<a href="{{ url('/change-theme/dark') }}">
    <div class="dark-light-btn p-3 cursor-pointer">
<<<<<<< Updated upstream
        <img src="{{ asset('images/dark-theme.svg')}}">
=======
        <img src="{{ asset('images/dark-theme.svg') }}">
       
>>>>>>> Stashed changes
    </div>
</a>
@endif


@include('layouts.admin.footer')
@yield('script')

</body>
</html>
