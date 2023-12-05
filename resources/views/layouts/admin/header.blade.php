<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Bootstrap CSS -->
    <link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/font_bootstrap_icons.css') }}">
{{--    <link rel="stylesheet" href="{{ asset('css/font-awesome_6.4.2_all.min.css') }}" />--}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('css/datepicker.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/jquery.timepicker.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/swiper-bundle.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('css/dark-mode.css')}}" />

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
{{--    @vite(['resources/sass/app.scss', 'resources/js/app.js'])--}}



</head>
