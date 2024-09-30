<?php $theme = \Request::session()->get('theme'); ?>

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="{{ $theme }}">
@include('layouts.admin.header')

<body>

    <div class="position-fixed inset-0 bg-transparent-layer d-none" id="loader">
        <img src="{{ asset('images/loader.gif') }}" style="height: 250px">
    </div>

    <div class="body-main">

        <div class="overlay-sidebar"></div>
        <a href="javascript:void(0)" id="sidebar-toggle-btn" class="sidebar-toggle">

            <svg width="18" height="14" viewBox="0 0 18 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                <line y1="1.25" x2="18" y2="1.25" stroke="black" stroke-width="1.5" />
                <line x1="-6.55671e-08" y1="7.25" x2="18" y2="7.25" stroke="black"
                    stroke-width="1.5" />
                <line x1="-6.55671e-08" y1="13.25" x2="18" y2="13.25" stroke="black"
                    stroke-width="1.5" />
            </svg>

        </a>
        @yield('content')
    </div>

    {{-- @if ($theme == 'dark')
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
    @endif --}}
    <!-- start order category Modal -->
    <div class="order-modal-div" id="order-modal-div"></div>
    <!-- end order category  Modal -->
    <audio id="myaudio" src="{{ asset('/notificationSound/notification-sound.mp3') }}"> </audio>

    @include('layouts.admin.footer')
    @yield('script')

</body>

</html>
