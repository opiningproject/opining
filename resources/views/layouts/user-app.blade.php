<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('layouts.user.header')
<body>

@yield('content')
@include('layouts.user.footer')
@yield('script')
</body>
</html>
