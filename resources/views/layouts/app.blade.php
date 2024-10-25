<?php $theme = \Request::session()->get('theme'); ?>

<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="{{ $theme }}">
@include('layouts.admin.header')

<body>

    <div class="position-fixed inset-0 bg-transparent-layer d-none" id="loader">
        <img src="{{ asset('images/loader.gif') }}" style="height: 250px">
    </div>



    <div class="body-main">
        @if (auth()->user())
            <div class="header-top">
                <div class="header-container">
                    <div class="header-row">
                        <div class="left">
                            <a href="javascript:void(0)" id="sidebar-toggle-btn" class="sidebar-toggle">

                                <svg width="18" height="14" viewBox="0 0 18 14" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <line y1="1.25" x2="18" y2="1.25" stroke="black"
                                        stroke-width="1.5" />
                                    <line x1="-6.55671e-08" y1="7.25" x2="18" y2="7.25" stroke="black"
                                        stroke-width="1.5" />
                                    <line x1="-6.55671e-08" y1="13.25" x2="18" y2="13.25" stroke="black"
                                        stroke-width="1.5" />
                                </svg>

                            </a>
                            <h1 class="mb-0 title">@yield('page_title', 'Dashboard')
                                @hasSection('order_count')
                                    <label class="count count-order">@yield('order_count')</label>
                                @endif
                            </h1>
                            <!-- Placeholder for count -->

                        </div>
                        <div class="right">
                            <button class="sound-check">
                                @if(getRestaurantDetail()->order_notif_sound == 1)
                                    <input type="hidden" value="1" class="orderNotifSound">
                                    <img src="{{ asset('images/admin-menu-icons/volume.svg') }}" class="svg volumeOn"
                                         height="20" width="20"/>
                                    <img src="{{ asset('images/admin-menu-icons/volume-slash.svg') }}"
                                         class="svg volumeOff d-none"
                                         height="20" width="20"/>
                                @else
                                    <input type="hidden" value="0" class="orderNotifSound">
                                    <img src="{{ asset('images/admin-menu-icons/volume-slash.svg') }}"
                                         class="svg volumeOff"
                                         height="20" width="20"/>
                                    <img src="{{ asset('images/admin-menu-icons/volume.svg') }}"
                                         class="svg volumeOn d-none"
                                         height="20" width="20"/>
                                @endif
                            </button>

                            <a href="{{ route('chat') }}" class="chat-link">
                                <img src="{{ asset('images/admin-menu-icons/message-text.svg') }}" class="svg"
                                    height="20" width="20" />
                                @if (getUnreadChatCount() > 0)
                                    <span class="count">{{ getUnreadChatCount() }}</span>
                                @endif
                            </a>
                            @if (auth()->user())
                                <div class="dropdown profile-link custom-default-dropdown">
                                    <button class="btn" type="button" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <img src="{{ getRestaurantDetail()->restaurant_logo }}" alt="user image">
                                        {{ Auth::user()->name }}
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="#"
                                                onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                                {{ trans('rest.settings.profile.logout') }}
                                            </a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                class="d-none"> @csrf </form>
                                        </li>
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="overlay-sidebar"></div>

        @yield('content')

            <div class="modal fade custom-modal order-detail-popup" id="orderDetailModal" tabindex="-1"
                 aria-labelledby="orderDetailModal" aria-hidden="true">
            </div>
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
