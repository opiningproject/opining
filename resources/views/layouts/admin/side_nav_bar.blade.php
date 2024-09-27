<aside class="menu-sidebar">

    <a href="javascript:void(0)" id="sidebar-toggle-back" class="sidebar-toggle"><img
            src="{{ asset('images/sidebar-arrow.svg') }}" alt="" /></a>

    <div class="menu-sidebar-inner">
        <div class="bd-navbar-toggle">
            <button class="navbar-toggler p-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#bdSidebar"
                aria-controls="bdSidebar" aria-label="Toggle docs navigation">
                <img src="{{ asset('images/expand.svg') }}" alt="" width="24" height="24" class="svg">
                <span class="d-none fs-6 pe-1">Browse</span>
            </button>
        </div>
        <div class="siderbarmenu-brand">
            <a href="{{ route('home') }}" class="navbar-brand sidebar-logo">
                <div class="admin-logo">
                    <img src="{{ asset('images/opening-icon.svg') }}" class="icon-logo" />
                    <img src="{{ asset('images/opining-text-logo.svg') }}" class="text-logo" />
                    {{-- <img src="{{ asset('images/logo-admin.png') }}" class="web-logo" /> --}}
                </div>
            </a>
        </div>

        <div class="offcanvas-lg offcanvas-start position-relative" tabindex="-1" id="bdSidebar"
            aria-labelledby="bdSidebarOffcanvasLabel">
            <div class="offcanvas-body py-4">
                <nav class="w-100">
                    <div class="menu-sidebar-content d-flex flex-column align-items-center align-items-sm-start">
                        <div class="navbar-collapse menunavbar-collapse w-100 d-block" id="navbarSupportedContent">
                            <ul class="nav nav-pills side-bar-menu flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start"
                                id="menu">

                                <label class="menu-label pt-0">Main</label>
                                <li class="nav-item">
                                    <a href="{{ route('dashboard') }}"
                                        class="nav-link {{ activeMenu('dashboard') }} align-middle">
                                        <div class="icon-span">
                                            <img src="{{ asset('images/admin-menu-icons/dashboard-gray.svg') }}"
                                                class="svg actual" height="18" width="20" />

                                            <img src="{{ asset('images/admin-menu-icons/dashboard-black.svg') }}"
                                                class="svg hoverable" height="18" width="20" />
                                        </div>
                                        <span class="ms-0 d-sm-inline align-middle">Dashboard</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('orders') }}"
                                        class="align-items-center nav-link {{ activeMenu('orders') }} align-middle">
                                        <div class="icon-span">
                                            <img src="{{ asset('images/admin-menu-icons/order-gray.svg') }}"
                                                class="svg actual" height="22" width="22" />

                                            <img src="{{ asset('images/admin-menu-icons/order-black.svg') }}"
                                                class="svg hoverable" height="22" width="22" />
                                        </div>
                                        <span
                                            class="ms-0 d-sm-inline align-middle">{{ trans('rest.sidebar.food_order') }}</span>
                                        <span
                                            class="ms-1 d-sm-inline align-middle order-count ms-auto">{{ getOpenOrders() }}</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('home') }}"
                                        class="nav-link {{ activeMenu('menu') }} align-middle">
                                        <div class="icon-span">
                                            <img src="{{ asset('images/admin-menu-icons/menu-gray.svg') }}"
                                                class="svg actual" height="22" width="22" />

                                            <img src="{{ asset('images/admin-menu-icons/menu-black.svg') }}"
                                                class="svg hoverable" height="22" width="22" />
                                        </div>
                                        <span
                                            class="ms-0 d-sm-inline align-middle">{{ trans('rest.sidebar.menu') }}</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('archives') }}"
                                        class="nav-link {{ activeMenu('archive') }} align-middle">
                                        <div class="icon-span">
                                            <img src="{{ asset('images/admin-menu-icons/archive-gray.svg') }}"
                                                class="svg actual" height="20" width="20" />

                                            <img src="{{ asset('images/admin-menu-icons/archive-black.svg') }}"
                                                class="svg hoverable" height="20" width="20" />
                                        </div>
                                        <span
                                            class="ms-0 d-sm-inline align-middle">{{ trans('rest.sidebar.archive_order') }}</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('payments') }}"
                                        class="nav-link {{ activeMenu('payments') }} align-middle">
                                        <div class="icon-span">
                                            <img src="{{ asset('images/admin-menu-icons/finance-gray.svg') }}"
                                                class="svg actual" height="22" width="22" />

                                            <img src="{{ asset('images/admin-menu-icons/finance-black.svg') }}"
                                                class="svg hoverable" height="22" width="22" />
                                        </div>
                                        <span
                                            class="ms-0 d-sm-inline align-middle">{{ trans('rest.sidebar.analytics') }}</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('coupons.index') }}"
                                        class="nav-link {{ activeMenu('coupons') }} align-middle">
                                        <div class="icon-span">
                                            <img src="{{ asset('images/admin-menu-icons/coupons-gray.svg') }}"
                                                class="svg actual" height="22" width="22" />

                                            <img src="{{ asset('images/admin-menu-icons/coupons-black.svg') }}"
                                                class="svg hoverable" height="22" width="22" />
                                        </div>
                                        <span
                                            class="ms-0 d-sm-inline align-middle">{{ trans('rest.sidebar.coupons') }}</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('chat') }}"
                                        class="nav-link {{ activeMenu('chat') }} align-middle">
                                        <div class="icon-span">
                                            <img src="{{ asset('images/admin-menu-icons/chat-gray.svg') }}"
                                                class="svg actual" height="22" width="22" />

                                            <img src="{{ asset('images/admin-menu-icons/chat-black.svg') }}"
                                                class="svg hoverable" height="22" width="22" />
                                        </div>
                                        <span
                                            class="ms-0 d-sm-inline align-middle">{{ trans('rest.sidebar.user_chat') }}</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('deliverers.index') }}"
                                        class="nav-link {{ activeMenu('deliverers') }} align-middle">
                                        <div class="icon-span">
                                            <img src="{{ asset('images/admin-menu-icons/deliverer-gray.svg') }}"
                                                class="svg actual" height="22" width="22" />

                                            <img src="{{ asset('images/admin-menu-icons/deliverer-black.svg') }}"
                                                class="svg hoverable" height="22" width="22" />
                                        </div>
                                        <span
                                            class="ms-0 d-sm-inline align-middle">{{ trans('rest.sidebar.deliverers') }}</span>
                                    </a>
                                </li>

                                <label class="menu-label">{{ trans('rest.sidebar.sales_channels') }}</label>

                                <li class="nav-item">
                                    <a href="{{ route('myWebsite') }}"
                                        class="nav-link {{ activeMenu('my-website') }} align-middle">
                                        <div class="icon-span">
                                            <img src="{{ asset('images/admin-menu-icons/website-gray.svg') }}"
                                                class="svg actual" height="22" width="22" />

                                            <img src="{{ asset('images/admin-menu-icons/website-black.svg') }}"
                                                class="svg hoverable" height="22" width="22" />
                                        </div>
                                        <span
                                            class="ms-0 d-sm-inline align-middle">{{ trans('rest.sidebar.my_website') }}</span>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="#" class="nav-link align-middle">
                                        <div class="icon-span">
                                            <img src="{{ asset('images/admin-menu-icons/points-gray.svg') }}"
                                                class="svg actual" height="22" width="22" />

                                            <img src="{{ asset('images/admin-menu-icons/points-black.svg') }}"
                                                class="svg hoverable" height="22" width="22" />
                                        </div>
                                        <span class="ms-0 d-sm-inline align-middle">Point of Sale</span>
                                    </a>
                                </li>

                                <label class="menu-label">SETTINGS</label>

                                <li class="nav-item">
                                    <a href="#" class="nav-link align-middle">
                                        <div class="icon-span">
                                            <img src="{{ asset('images/admin-menu-icons/chat-gray.svg') }}"
                                                class="svg actual" height="22" width="22" />

                                            <img src="{{ asset('images/admin-menu-icons/chat-black.svg') }}"
                                                class="svg hoverable" height="22" width="22" />
                                        </div>
                                        <span class="ms-0 d-sm-inline align-middle">Support</span>
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('settings') }}"
                                        class="nav-link {{ activeMenu('settings') }} align-middle">
                                        <div class="icon-span">
                                            <img src="{{ asset('images/admin-menu-icons/setting-gray.svg') }}"
                                                class="svg actual" height="22" width="22" />

                                            <img src="{{ asset('images/admin-menu-icons/setting-black.svg') }}"
                                                class="svg hoverable" height="22" width="22" />
                                        </div>
                                        <span
                                            class="ms-0 d-sm-inline align-middle">{{ trans('rest.sidebar.settings') }}</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>


            </div>

        </div>
    </div>

    <div class="sidebar-menu-top-box position-relative border-top mt-3">
        <div class="d-flex gap-2 align-items-center">
            <div class="userPhoto">
                <img src="{{ getRestaurantDetail()->restaurant_logo }}" alt="user image" class="img-fluid" width="50"
                    height="50">
            </div>
            <div class="text-start">
                <div class="dropdown">
                    {{ Auth::user()->name }}
                </div>
                <div class="text-truncate">
                    {{ Auth::user()->email }}
                </div>
            </div>

            <div class="ms-auto">
                <a class="dropdown-item log-out-item" href="javascript:void(0)"
                    onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                    <img src="{{ asset('images/sign-out-up.svg') }}" class="svg" width="20" height="20" />
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf </form>
            </div>


        </div>
    </div>

</aside>