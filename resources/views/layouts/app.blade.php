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
            <svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" data-name="Layer 1" viewBox="0 0 24 24" width="28"
                height="28">
                <path
                    d="M0,4c0-.55,.45-1,1-1H18c.55,0,1,.45,1,1s-.45,1-1,1H1c-.55,0-1-.45-1-1Zm18,15H1c-.55,0-1,.45-1,1s.45,1,1,1H18c.55,0,1-.45,1-1s-.45-1-1-1Zm5-8H6c-.55,0-1,.45-1,1s.45,1,1,1H23c.55,0,1-.45,1-1s-.45-1-1-1Z" />
            </svg>
        </a>
        @yield('content')
    </div>

    {{--@if($theme == 'dark')
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
    @endif--}}
    <!-- start order category Modal -->
    <div class="order-modal-div" id="order-modal-div"></div>
    <!-- end order category  Modal -->
    <audio id="myaudio" src="{{asset('/notificationSound/notification-sound.mp3')}}"> </audio>

    @include('layouts.admin.footer')
    @yield('script')

</body>

</html>