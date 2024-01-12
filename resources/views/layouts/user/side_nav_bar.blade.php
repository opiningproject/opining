<aside class="menu-sidebar sticky-top">
    <div class="bd-navbar-toggle">
        <button class="navbar-toggler p-2" type="button" data-bs-toggle="offcanvas"
            data-bs-target="#bdSidebar" aria-controls="bdSidebar" aria-label="Toggle docs navigation">
           <img src="{{ asset('images/toggle-icon.svg') }}" class="svg" 
                                                    width="24" height="21">
            <span class="d-none fs-6 pe-1">Browse</span>
        </button>
    </div>

    <div class="siderbarmenu-brand">
        <a href="#" class="navbar-brand sidebar-logo">
            Gomeal<span class="text-yellow-1">.</span>
        </a>
    </div>

    <div class="bd-navbar-toggle cartsidebar-icon">
        <button class="navbar-toggler p-2 searcheatboxbtn" type="button">
            <img src="{{ asset('images/toggle-icon.svg') }}" class="svg" width="18" height="18">
        </button>
        <button class="navbar-toggler p-2" type="button" data-bs-toggle="offcanvas"
            data-bs-target="#bdSidebarCart" aria-controls="bdSidebarCart"
            aria-label="Toggle docs navigation">
             <img src="{{ asset('images/sidebar-toggle.svg') }}" class="svg" width="18" height="22">
           
        </button>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"
            data-bs-target="#bdSidebarCart"></button>
    </div>

    <div class="offcanvas-lg offcanvas-start" tabindex="-1" id="bdSidebar" aria-labelledby="bdSidebarOffcanvasLabel">
        <div class="offcanvas-header border-bottom position-relative">
            <div class="sidebar-menu-top-box">
                @if(!Auth::user())
                <div class="menu-signsignup-link">
                  <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#signInModal">
                    <img src="{{ asset('images/user-icon.svg') }}" class="svg" width="25" height="26">
                    <p class="mb-0 d-inline-block align-middle"> Sign In / Sign Up </p>
                  </a>
                </div>
                @else
                <div class="d-flex gap-3">
                    <div class="rounded">
                        <img src="{{ Auth::user()->image }}" alt="" class="" width="60" height="60">
                    </div>
                    <div class="text-start">
                        <div class="dropdown">
                            <div class="dropdown-toggle custom-arrow" type="button" data-bs-toggle="dropdown" style="color: #FFC00A;">
                                {{ Auth::user()->full_name }}
                            </div>
                            <ul class="dropdown-menu">
                              <li>
                                <a class="dropdown-item" href="#" onclick="event.preventDefault();
                                                                                 document.getElementById('logout-form').submit();">
                                  {{ __('Logout') }}
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
                <div
                    class="menu-sidebar-content d-flex flex-column align-items-center align-items-sm-start">

                    <div class="navbar-collapse menunavbar-collapse" id="navbarSupportedContent">
                        <ul class="nav nav-pills side-bar-menu flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start"
                            id="menu">
                            <li class="nav-item">
                                 <a href="{{ route('user.dashboard') }}" class="nav-link {{ activeMenu('user.dashboard') }} align-middle">
                                    <img src="{{ asset('images/dashboard-menu.svg') }}" class="svg" width="40" height="40">
                                    
                                    <span class="ms-1 d-sm-inline align-middle">Dashboard</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('user.orders') }}" class="nav-link {{ activeMenu('user.orders') }} align-middle">
                                   <img src="{{ asset('images/myorder-menu.svg') }}" class="svg" width="40" height="40">
                                    <span class="ms-1 d-sm-inline align-middle">My Order</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('user.favorite') }}" class="nav-link {{ activeMenu('user.favorite') }} align-middle">
                                    <img src="{{ asset('images/favorite-menu.svg') }}" class="svg" width="40" height="40">
                                    <span class="ms-1 d-sm-inline align-middle">Favorite</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('user.chat') }}" class="nav-link {{ activeMenu('user.chat') }} align-middle">
                                    <img src="{{ asset('images/user-chat-menu.svg') }}" class="svg" width="40" height="40">
                                    
                                    <span class="ms-1 d-sm-inline align-middle">Chat Support</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('user.settings') }}" class="nav-link {{ activeMenu('user.settings') }} align-middle">
                                  
                                    <img src="{{ asset('images/settings-menu.svg') }}" class="svg" width="40" height="40">
                                    
                                    <span class="ms-1 d-sm-inline align-middle">Setting</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('user.points') }}" class="nav-link {{ activeMenu('user.points') }} align-middle">

                                    <img src="{{ asset('images/collected-points-menu.svg') }}" class="svg" width="40" height="40">
                                   
                                    <span class="ms-1 d-sm-inline align-middle">Collected points</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('user.coupons') }}" class="nav-link {{ activeMenu('user.coupons') }} align-middle">
                                    <img src="{{ asset('images/coupons-menu.svg') }}" class="svg" width="40" height="40">
                                    <span class="ms-1 d-sm-inline align-middle">My coupons</span>
                                </a>
                            </li>
                        </ul>
                        <div class="sidebar-bottom">
                            <div class="card sidebar-offer-card position-relative">
                                <div class="card-body">
                                    <p class="mb-0">Every 5th order you will get a 20% discount coupon!
                                    </p>
                                    <div class="circle-bg-shape">
                                        <img src="{{ asset('images/nav-grade.svg') }}" class="svg" width="90" height="95">
                                        
                                    </div>
                                </div>
                            </div>

                            <div class="language-selector">
                                <div class="dropdown">
                                  <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    @if(App::isLocale('en'))
                                      <img src="{{ asset('images/english-flag.svg') }}" class="img-fluid" alt="country-flag" width="28" height="28" />
                                      <span class="">English</span>
                                    @else
                                      <img src="{{ asset('images/dutch-flag.svg') }}" class="img-fluid" alt="country-flag" width="28" height="28" />
                                      <span class="">Dutch</span>
                                    @endif
                                  </button>
                                  <ul class="dropdown-menu">
                                      <li>
                                        <a class="dropdown-item {{ (App::isLocale('en')) ? 'active': '' }}" href="{{ route('app.setLocal', 'en') }}">
                                          <img src="{{ asset('images/english-flag.svg') }}" class="img-fluid" width="28" height="28" alt="country-flag" />English
                                        </a>
                                      </li>
                                      <li>
                                        <a class="dropdown-item {{ (App::isLocale('nl')) ? 'active': '' }}" href="{{ route('app.setLocal', 'nl') }}">
                                          <img src="{{ asset('images/dutch-flag.svg') }}" class="img-fluid" width="28" height="28" alt="country-flag" />Dutch
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
