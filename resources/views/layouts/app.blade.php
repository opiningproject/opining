<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('layouts.admin.header')
<body>
<div class="position-fixed inset-0 bg-transparent-layer" style="display:none;" id="loader">
    <img src="{{ asset('images/loader.gif') }}" style="height: 250px">
</div>
@yield('content')
@include('layouts.admin.footer')
@yield('script')
</body>
</html>
