<aside class="menu-sidebar">
    <div class="bd-navbar-toggle">
        <button class="navbar-toggler p-2" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#bdSidebar" aria-controls="bdSidebar" aria-label="Toggle docs navigation">
            <img src="{{ asset('images/expand.svg') }}" alt="" width="24" height="24" class="svg">
            <span class="d-none fs-6 pe-1">Browse</span>
        </button>
    </div>
    <div class="siderbarmenu-brand">
        <a href="{{ route('home') }}" class="navbar-brand sidebar-logo">
            <div class="">
                <img src="{{ asset('images/logo-admin.png') }}" class="web-logo">

            </div>
        </a>
    </div>

    <div class="offcanvas-lg offcanvas-start position-relative" tabindex="-1" id="bdSidebar"
         aria-labelledby="bdSidebarOffcanvasLabel">
        <div class="offcanvas-body py-4">
            <nav class="">
                <div
                    class="menu-sidebar-content d-flex flex-column align-items-center align-items-sm-start">
                    <div class="navbar-collapse menunavbar-collapse w-100 d-block"
                         id="navbarSupportedContent">
                        <ul class="nav nav-pills side-bar-menu flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
                            <li class="nav-item">
                                <a href="{{ route('home') }}" class="nav-link {{ activeMenu('menu') }} align-middle">
                                    <img class="svg" src="{{ asset('images/menu-menu.svg') }}" alt="" height="34" width="34">
                                    <span class="ms-1 d-sm-inline align-middle">{{ trans('rest.sidebar.menu') }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('orders') }}" class="nav-link {{ activeMenu('orders') }} align-middle">
                                    <img class="svg" src="{{ asset('images/order-menu.svg') }}" alt="" height="34" width="34">
                                    <span class="ms-1 d-sm-inline align-middle">{{ trans('rest.sidebar.food_order') }}</span>
                                    <span class="ms-1 d-sm-inline align-middle order-count">{{ getOpenOrders() }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('payments') }}" class="nav-link {{ activeMenu('payments') }} align-middle">
                                    <img class="svg" src="{{ asset('images/finance-menu.svg') }}" alt="" height="34" width="34">
                                    <span class="ms-1 d-sm-inline align-middle">{{ trans('rest.sidebar.my_finance') }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('coupons.index') }}" class="nav-link {{ activeMenu('coupons') }} align-middle">
                                    <img class="svg" src="{{ asset('images/coupons-menu.svg') }}" alt="" height="34" width="34">
                                    <span class="ms-1 d-sm-inline align-middle">{{ trans('rest.sidebar.coupons') }}</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('chat') }}" class="nav-link {{ activeMenu('chat') }} align-middle">
                                    <img class="svg" src="{{ asset('images/user-chat-menu.svg') }}" alt="" height="34" width="34">
                                    <span class="ms-1 d-sm-inline align-middle">{{ trans('rest.sidebar.user_chat') }}</span>
                                </a>
                            </li>
                            <li class="nav-item fixed_bottom">
                                <a href="{{ route('settings') }}" class="nav-link {{ activeMenu('settings') }} align-middle">
                                    <img class="svg" src="{{ asset('images/settings-menu.svg') }}" alt="" height="34" width="34">
                                    <span class="ms-1 d-sm-inline align-middle">{{ trans('rest.sidebar.settings') }}</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>

        </div>

    </div>
</aside>
