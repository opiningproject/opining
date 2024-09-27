<aside class="menu-sidebar">

    <div class="menu-sidebar-inner">
        <div class="bd-navbar-toggle">
            <button class="navbar-toggler p-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#bdSidebar"
                aria-controls="bdSidebar" aria-label="Toggle docs navigation">
                <img src="{{ asset('images/expand.svg') }}" alt="" width="24" height="24" class="svg">
                <span class="d-none fs-6 pe-1">Browse</span>
            </button>
        </div>
        <div class="siderbarmenu-brand">
            <a href="{{ route('super-admin.dashboard') }}" class="navbar-brand sidebar-logo">
                <div class="">
                    <img src="{{ asset('images/logo-admin.png') }}" class="web-logo">

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
                                    <a href="{{ route('super-admin.dashboard') }}"
                                        class="nav-link {{ activeMenu('super-admin.dashboard') }} align-middle">
                                        <div class="icon-span">
                                            <img src="{{ asset('images/admin-menu-icons/dashboard-gray.svg') }}"
                                                class="svg actual" height="18" width="20" />

                                            <img src="{{ asset('images/admin-menu-icons/dashboard-black.svg') }}"
                                                class="svg hoverable" height="18" width="20" />
                                        </div>
                                        <span
                                            class="ms-0 d-sm-inline align-middle">Dashboard</span>
                                    </a>
                                </li>
                                      <li class="nav-item">
                                    <a href="{{ route('super-admin.dashboard') }}"
                                        class="nav-link {{ activeMenu('super-admin.dashboard') }} align-middle">
                                        <div class="icon-span">
                                            <img src="{{ asset('images/admin-menu-icons/dashboard-gray.svg') }}"
                                                class="svg actual" height="18" width="20" />

                                            <img src="{{ asset('images/admin-menu-icons/dashboard-black.svg') }}"
                                                class="svg hoverable" height="18" width="20" />
                                        </div>
                                        <span
                                            class="ms-0 d-sm-inline align-middle">Customers</span>
                                    </a>
                                </li>

                         {{--        <li class="nav-item">
                                    <a href="{{ route('users') }}"
                                        class="nav-link {{ activeMenu('dashboard') }} align-middle">
                                        <div class="icon-span">
                                            <img src="{{ asset('images/admin-menu-icons/dashboard-gray.svg') }}"
                                                class="svg actual" height="18" width="20" />

                                            <img src="{{ asset('images/admin-menu-icons/dashboard-black.svg') }}"
                                                class="svg hoverable" height="18" width="20" />
                                        </div>
                                        <span
                                            class="ms-0 d-sm-inline align-middle">Dashboard</span>
                                    </a>
                                </li> --}}

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
                <img src="{{ getRestaurantDetail()->restaurant_logo }}" alt="user image"
                    class="img-fluid" width="50" height="50">
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
                    <img src="{{ asset('images/sign-out-up.svg') }}" class="svg" width="20"
                        height="20" />
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf </form>
            </div>


        </div>
    </div>

</aside>
