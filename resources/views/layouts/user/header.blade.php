<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Bootstrap CSS -->
    <link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/font_bootstrap_icons.css') }}">
    <link rel="stylesheet" href="{{ asset('css/font-awesome_6.4.2_all.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/datepicker.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/jquery.timepicker.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/swiper-bundle.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/dark-mode.css')}}" />

    <link rel="stylesheet" type="text/css" href="{{ asset('css/user/style.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/user/style.scss')}}" />
    
</head>
