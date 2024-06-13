<aside class="menu-sidebar sticky-top">
    <div class="bd-navbar-toggle">
        <button class="navbar-toggler p-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#bdSidebar" aria-controls="bdSidebar" aria-label="Toggle docs navigation">
            <img src="{{ asset('images/toggle-icon.svg') }}" class="svg" width="24" height="21">
            <span class="d-none fs-6 pe-1">Browse</span>
        </button>
    </div>

    <div class="siderbarmenu-brand">
        <a href="#" class="navbar-brand sidebar-logo">
            <img src="{{ getRestaurantDetail()->restaurant_logo }}" class="web-logo">
        </a>
    </div>

    <div class="bd-navbar-toggle cartsidebar-icon ms-auto align-items-center">
        <button class="navbar-toggler p-2 searcheatboxbtn d-none" type="button">
            <img src="{{ asset('images/toggle-icon.svg') }}" class="svg" width="18" height="18">
        </button>


        <!-- Just show in dahboard - Condition will added by Jamal -->
        <button class="navbar-toggler p-0 searchMobileIcon d-md-none {{ (request()->segment(count(request()->segments())) != 'dashboard' &&  request()->segment(count(request()->segments())-1) != 'dashboard') ? 'd-none' : '' }} " id="mobilesearchToggle" type="button">
        <img class="svg" src="{{ asset('images/search.svg') }}" alt="" height="32" width="32">
        </button>

        @if(Route::currentRouteName() == 'user.dashboard')
            <button class="navbar-toggler bag-count d-flex  dashboard-cart-navbar-toggler cart-navbar-toggler ms-2  p-0 d-flex" type="button" data-bs-toggle="offcanvas" data-bs-target="#bdSidebarCart" aria-controls="bdSidebarCart" aria-label="Toggle docs navigation">
                <span class="count" id="cart-item-count">{{ isset(Auth::user()->cart) ? Auth::user()->cart->dishDetails->count() : 0 }}</span>
                <svg width="22px" height="22px" viewBox="-4 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg"
                     xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns"><defs></defs>
                    <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
                        <g id="Icon-Set" sketch:type="MSLayerGroup" transform="translate(-572.000000, -723.000000)" fill="#FFC00B">
                            <path
                                d="M594,747 L574,747 L574,731 C574,729.896 574.896,729 576,729 L578,729 L578,735 L580,735 L580,729 L588,729 L588,735 L590,735 L590,729 L592,729 C593.104,729 594,729.896 594,731 L594,747 L594,747 Z M594,751 C594,752.104 593.104,753 592,753 L576,753 C574.896,753 574,752.104 574,751 L574,749 L594,749 L594,751 L594,751 Z M584,725 C586.209,725 588,725.619 588,727 L580,727 C580,725.619 581.791,725 584,725 L584,725 Z M592,727 L590,727 C590,724.791 587.313,723 584,723 C580.687,723 578,724.791 578,727 L576,727 C573.791,727 572,728.791 572,731 L572,751 C572,753.209 573.791,755 576,755 L592,755 C594.209,755 596,753.209 596,751 L596,731 C596,728.791 594.209,727 592,727 L592,727 Z"
                                id="bag" sketch:type="MSShapeGroup"></path>
                        </g>
                    </g>
                </svg>
            </button>
        @endif

        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close" data-bs-target="#bdSidebarCart"></button>
    </div>

    <div class="offcanvas-lg offcanvas-start" tabindex="-1" id="bdSidebar" aria-labelledby="bdSidebarOffcanvasLabel">
        <div class="offcanvas-header border-bottom position-relative">
            <div class="sidebar-menu-top-box">
                @if(!Auth::user())
                    <div class="menu-signsignup-link">
                        <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#signInModal">
                            <img src="{{ asset('images/user-icon.svg') }}" class="svg" width="25" height="26">
                            <p class="mb-0 d-inline-block align-middle">{{ trans('user.sidebar.sign_in') }} </p>
                        </a>
                    </div>
                @else
                    <div class="d-flex gap-3 align-items-center">
                        <div class="userPhoto">
                            <img src="{{ Auth::user()->image }}" alt="" class="" width="60" height="60">
                        </div>
                        <div class="text-start">
                            <div class="dropdown">
                                <div class="dropdown-toggle custom-arrow" type="button" data-bs-toggle="dropdown" style="color: #FFC00A;text-wrap: wrap;">
                                    {{ Auth::user()->full_name }}
                                </div>
                                <ul class="dropdown-menu py-0">
                                    <li>
                                        <a class="dropdown-item log-out-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                           <img src="{{ asset('images/log-out.svg') }}" class="svg" width="25" height="26">
                                            {{ trans('user.sidebar.logout') }}
                                        </a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none"> @csrf </form>
                                    </li>
                                </ul>
                            </div>
                            <div class="text-truncate" style="color: var(--theme-dark1);">{{ Auth::user()->email }}</div>
                        </div>
                    </div>
                @endif
            </div>

            <button type="button" class="btn-close d-block drawer-close d-lg-none" data-bs-dismiss="offcanvas" aria-label="Close" data-bs-target="#bdSidebar">
            </button>
        </div>

        <div class="offcanvas-body p-0">
            <nav class="">
                <div class="menu-sidebar-content d-flex flex-column align-items-center align-items-sm-start">
                    <div class="navbar-collapse menunavbar-collapse" id="navbarSupportedContent">
                        <ul class="nav nav-pills side-bar-menu flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
                            <li class="nav-item">
                                <a href="{{ route('user.dashboard') }}" class="nav-link {{ activeMenu('user.dashboard') }} align-middle">
                                    <img src="{{ asset('images/dashboard-menu.svg') }}" class="svg" width="40" height="40">
                                    <span class="ms-1 d-sm-inline align-middle">{{ trans('user.sidebar.dashboard') }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('user.orders') }}" class="nav-link {{ activeMenu('user.orders') }} align-middle auth-link-check">
                                    <img src="{{ asset('images/myorder-menu.svg') }}" class="svg" width="40" height="40">
                                    <span class="ms-1 d-sm-inline align-middle">{{ trans('user.sidebar.my_order') }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('user.favorite') }}" class="nav-link {{ activeMenu('user.favorite') }} align-middle auth-link-check">
                                    <img src="{{ asset('images/favorite-menu.svg') }}" class="svg" width="40" height="40">
                                    <span class="ms-1 d-sm-inline align-middle">{{ trans('user.sidebar.favorite') }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('user.chat') }}" class="nav-link {{ activeMenu('user.chat') }} align-middle auth-link-check">
                                    <img src="{{ asset('images/user-chat-menu.svg') }}" class="svg" width="40" height="40">
                                    <span class="ms-1 d-sm-inline align-middle">{{ trans('user.sidebar.chat') }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('user.settings') }}" class="nav-link {{ activeMenu('user.settings') }} align-middle auth-link-check">
                                    <img src="{{ asset('images/settings-menu.svg') }}" class="svg" width="40" height="40">
                                    <span class="ms-1 d-sm-inline align-middle">{{ trans('user.sidebar.settings') }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('user.points') }}" class="nav-link {{ activeMenu('user.points') }} align-middle auth-link-check">
                                    <img src="{{ asset('images/collected-points-menu.svg') }}" class="svg" width="40" height="40">
                                    <span class="ms-1 d-sm-inline align-middle">{{ trans('user.sidebar.collected_points') }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('user.coupons') }}" class="nav-link {{ activeMenu('user.coupons') }} align-middle auth-link-check">
                                    <img src="{{ asset('images/coupons-menu.svg') }}" class="svg" width="40" height="40">
                                    <span class="ms-1 d-sm-inline align-middle">{{ trans('user.sidebar.my_coupons') }}</span>
                                </a>
                            </li>

                            {{-- New Coupons menu --}}
                            <li class="nav-item">
                                <a href="{{ route('user.couponss') }}" class="nav-link {{ activeMenu('user.couponss') }} align-middle auth-link-check">
                                    <img src="{{ asset('images/coupons-menu.svg') }}" class="svg" width="40" height="40">
                                    <span class="ms-1 d-sm-inline align-middle">My Coupenss</span>
                                </a>
                            </li>
                        </ul>
                        <div class="sidebar-bottom mb-5">
                            <div class="card sidebar-offer-card position-relative">
                                <div class="card-body">
                                    <p class="mb-0">{{ trans('user.sidebar.content') }}</p>
                                    <div class="circle-bg-shape">
                                        <img src="{{ asset('images/nav-grade.svg') }}" class="svg" width="90" height="95">
                                    </div>
                                </div>
                            </div>

                            <div class="language-selector">
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        @if(App::isLocale('en'))
                                            <img src="{{ asset('images/english-flag.svg') }}" class="img-fluid" alt="country-flag" width="28" height="28"/>
                                            <span class="">English</span>
                                        @else
                                            <img src="{{ asset('images/dutch-flag.svg') }}" class="img-fluid" alt="country-flag" width="28" height="28"/>
                                            <span class="">Dutch</span>
                                        @endif
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item {{ (App::isLocale('en')) ? 'active': '' }}" href="{{ route('app.setLocal', 'en') }}">
                                                <img src="{{ asset('images/english-flag.svg') }}" class="img-fluid" width="28" height="28" alt="country-flag"/>English
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item {{ (App::isLocale('nl')) ? 'active': '' }}" href="{{ route('app.setLocal', 'nl') }}">
                                                <img src="{{ asset('images/dutch-flag.svg') }}" class="img-fluid" width="28" height="28" alt="country-flag"/>Dutch
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </div>
</aside>
