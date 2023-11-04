<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('layouts.admin.header')
<body>

@yield('content')
@include('layouts.admin.footer')
@yield('script')
</body>
</html>
