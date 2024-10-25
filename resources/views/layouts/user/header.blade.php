<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, shrink-to-fit=no, user-scalable=no" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'Laravel'))</title>
    <!-- Bootstrap CSS -->
    <link rel="shortcut icon" href="{{ getRestaurantDetail()->restaurant_logo }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.min.css')}}"  />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/font_bootstrap_icons.css') }}">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/datepicker.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/jquery.timepicker.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/swiper-bundle.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/dark-mode.css')}}" />

    <link rel="stylesheet" type="text/css" href="{{ asset('css/user-style.css')}}" />
{{--    <link rel="stylesheet" type="text/css" href="{{ asset('css/user-style.scss')}}" />--}}
    <link rel="stylesheet" type="text/css" href="{{ asset('css/user-style.css.map')}}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/user-payment-base.css')}}" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    @vite(['resources/js/app.js'])

</head>
