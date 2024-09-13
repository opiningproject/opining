<aside class="menu-sidebar sticky-top">
    <div class="menu-sidebar-inner">
        <div class="bd-navbar-toggle">
            <button class="navbar-toggler p-2" id="menu-sidebar" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#bdSidebar" aria-controls="bdSidebar" aria-label="Toggle docs navigation">
                <img src="<?php echo e(asset('images/toggle-icon.svg')); ?>" class="svg actual" width="24" height="21">
                <span class="d-none fs-6 pe-1">Browse</span>
            </button>
        </div>

        <div class="siderbarmenu-brand">
            <a href="<?php echo e(route('user.dashboard')); ?>" class="navbar-brand sidebar-logo">
                <img src="<?php echo e(getRestaurantDetail()->restaurant_logo); ?>" class="web-logo">
            </a>
        </div>

        <div class="bd-navbar-toggle cartsidebar-icon ms-auto align-items-center">
            <button class="navbar-toggler p-2 searcheatboxbtn d-none" type="button">
                <img src="<?php echo e(asset('images/toggle-icon.svg')); ?>" class="svg actual" width="18" height="18">
            </button>


            <!-- Just show in dahboard - Condition will added by Jamal -->
            <button
                class="navbar-toggler p-0 searchMobileIcon d-md-none <?php echo e(request()->segment(count(request()->segments())) != 'dashboard' && request()->segment(count(request()->segments()) - 1) != 'dashboard' ? 'd-none' : ''); ?> "
                id="mobilesearchToggle" type="button">
                <img class="svg actual" src="<?php echo e(asset('images/search-icon-up.svg')); ?>" alt="" height="18"
                    width="18">
            </button>

            <?php if(Route::currentRouteName() == 'user.dashboard'): ?>
                <button
                    class="navbar-toggler bag-count d-flex  dashboard-cart-navbar-toggler cart-navbar-toggler ms-3 p-0 d-flex"
                    type="button" data-bs-toggle="offcanvas" data-bs-target="#bdSidebarCart"
                    aria-controls="bdSidebarCart" aria-label="Toggle docs navigation">
                    <span class="count"
                        id="cart-item-count"><?php echo e(isset(Auth::user()->cart) ? Auth::user()->cart->dishDetails->count() : 0); ?></span>
                    <svg width="22px" height="22px" viewBox="-4 0 32 32" version="1.1"
                        xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                        xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
                        <defs></defs>
                        <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"
                            sketch:type="MSPage">
                            <g id="Icon-Set" sketch:type="MSLayerGroup" transform="translate(-572.000000, -723.000000)"
                                fill="#191919">
                                <path
                                    d="M594,747 L574,747 L574,731 C574,729.896 574.896,729 576,729 L578,729 L578,735 L580,735 L580,729 L588,729 L588,735 L590,735 L590,729 L592,729 C593.104,729 594,729.896 594,731 L594,747 L594,747 Z M594,751 C594,752.104 593.104,753 592,753 L576,753 C574.896,753 574,752.104 574,751 L574,749 L594,749 L594,751 L594,751 Z M584,725 C586.209,725 588,725.619 588,727 L580,727 C580,725.619 581.791,725 584,725 L584,725 Z M592,727 L590,727 C590,724.791 587.313,723 584,723 C580.687,723 578,724.791 578,727 L576,727 C573.791,727 572,728.791 572,731 L572,751 C572,753.209 573.791,755 576,755 L592,755 C594.209,755 596,753.209 596,751 L596,731 C596,728.791 594.209,727 592,727 L592,727 Z"
                                    id="bag" sketch:type="MSShapeGroup"></path>
                            </g>
                        </g>
                    </svg>
                </button>
            <?php endif; ?>

            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"
                data-bs-target="#bdSidebarCart"></button>
        </div>

        <div class="offcanvas-lg offcanvas-start" tabindex="-1" id="bdSidebar"
            aria-labelledby="bdSidebarOffcanvasLabel">
            <div class="offcanvas-header border-bottom position-relative pb-lg-2 pt-lg-0">

                <div class="sidebar-mobile-head">
                    <div class="mobile-sidebar-logo">
                        <img src="<?php echo e(getRestaurantDetail()->restaurant_logo); ?>" class="web-logo block d-lg-none" />
                    </div>

                    <button type="button" class="btn-close d-block drawer-close d-lg-none" id="menu-sidebar-close"
                        data-bs-dismiss="offcanvas" aria-label="Close" data-bs-target="#bdSidebar">
                        <img src="<?php echo e(asset('images/menu-back.svg')); ?>" class="svg actual" height="24" width="24" />
                    </button>
                </div>
            </div>

            <div class="offcanvas-body pb-0 pt-2">
                <nav class="w-100">
                    <div class="menu-sidebar-content d-flex flex-column align-items-center align-items-sm-start">
                        <div class="navbar-collapse menunavbar-collapse w-100" id="navbarSupportedContent">
                            <ul class="nav nav-pills side-bar-menu flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start"
                                id="menu">
                                <li class="nav-item">
                                    <a href="<?php echo e(route('user.dashboard')); ?>"
                                        class="nav-link <?php echo e(activeMenu('user.dashboard')); ?> align-middle">
                                        <div class="icon-span">
                                            <img src="<?php echo e(asset('images/menu-icons/dashboard-gray.svg')); ?>"
                                                class="svg actual" height="20" width="20" />

                                            <img src="<?php echo e(asset('images/menu-icons/dashboard-black.svg')); ?>"
                                                class="svg hoverable" height="20" width="20" />
                                        </div>
                                        <span
                                            class="d-sm-inline align-middle"><?php echo e(trans('user.sidebar.dashboard')); ?></span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo e(route('user.orders')); ?>"
                                        class="nav-link <?php echo e(activeMenu('user.orders')); ?> align-middle auth-link-check">
                                        <div class="icon-span">
                                            <img src="<?php echo e(asset('images/menu-icons/myorder-gray.svg')); ?>"
                                                class="svg actual" height="20" width="20" />

                                            <img src="<?php echo e(asset('images/menu-icons/myorder-black.svg')); ?>"
                                                class="svg hoverable" height="20" width="20"  />
                                        </div>
                                        <span
                                            class="d-sm-inline align-middle"><?php echo e(trans('user.sidebar.my_order')); ?></span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo e(route('user.favorite')); ?>"
                                        class="nav-link <?php echo e(activeMenu('user.favorite')); ?> align-middle auth-link-check">
                                        <div class="icon-span">
                                            <img src="<?php echo e(asset('images/menu-icons/favourite-gray.svg')); ?>" class="svg actual"
                                            height="20" width="20" />

                                        <img src="<?php echo e(asset('images/menu-icons/favourite-black.svg')); ?>" class="svg hoverable"
                                            height="20" width="20"  />
                                        </div>
                                        <span
                                            class="d-sm-inline align-middle"><?php echo e(trans('user.sidebar.favorite')); ?></span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo e(route('user.chat')); ?>"
                                        class="nav-link <?php echo e(activeMenu('user.chat')); ?> align-middle auth-link-check">
                                        <div class="icon-span">
                                            <img src="<?php echo e(asset('images/menu-icons/chat-gray.svg')); ?>" class="svg actual"
                                            height="20" width="20" />

                                        <img src="<?php echo e(asset('images/menu-icons/chat-black.svg')); ?>" class="svg hoverable"
                                            height="20" width="20" />
                                        </div>
                                        <span
                                            class="d-sm-inline align-middle"><?php echo e(trans('user.sidebar.chat')); ?></span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo e(route('user.points')); ?>"
                                        class="nav-link <?php echo e(activeMenu('user.points')); ?> align-middle auth-link-check">
                                        <div class="icon-span">
                                            <img src="<?php echo e(asset('images/menu-icons/points-gray.svg')); ?>" class="svg actual"
                                            height="20" width="20" />

                                        <img src="<?php echo e(asset('images/menu-icons/points-black.svg')); ?>" class="svg hoverable"
                                            height="20" width="20"  />
                                        </div>
                                        <span
                                            class="d-sm-inline align-middle"><?php echo e(trans('user.sidebar.collected_points')); ?></span>
                                    </a>
                                </li>
                                

                                
                                <li class="nav-item">
                                    <a href="<?php echo e(route('user.coupons')); ?>"
                                        class="nav-link <?php echo e(activeMenu('user.coupons')); ?> align-middle auth-link-check">
                                        <div class="icon-span">
                                            <img src="<?php echo e(asset('images/menu-icons/coupons-gray.svg')); ?>" class="svg actual"
                                            height="20" width="20" />

                                        <img src="<?php echo e(asset('images/menu-icons/coupons-black.svg')); ?>" class="svg hoverable"
                                            height="20" width="20"  />
                                        </div>
                                        <span
                                            class="d-sm-inline align-middle"><?php echo e(trans('user.sidebar.my_coupons')); ?></span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?php echo e(route('user.settings')); ?>"
                                        class="nav-link <?php echo e(activeMenu('user.settings')); ?> align-middle auth-link-check">
                                        <div class="icon-span">
                                            <img src="<?php echo e(asset('images/menu-icons/setting-gray.svg')); ?>" class="svg actual"
                                            height="20" width="20" />

                                        <img src="<?php echo e(asset('images/menu-icons/setting-black.svg')); ?>" class="svg hoverable"
                                            height="20" width="20"  />
                                        </div>
                                        <span
                                            class="d-sm-inline align-middle"><?php echo e(trans('user.sidebar.settings')); ?></span>
                                    </a>
                                </li>
                            </ul>
                            
                        </div>
                    </div>
                </nav>

                <div class="sidebar-menu-top-box  position-relative border-top">
                    <?php if(!Auth::user()): ?>
                        <div class="auth_enter_btns">

                            <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#signInModal"
                                class="btn">Log In</a>
                            <!--                            <a href="#" data-bs-toggle="modal" data-bs-target="#signUpModal"
                               class="text-yellow-2"><?php echo e(trans('modal.button.sign_up')); ?></a>-->
                            <a href="#" class="btn btn-site-theme" data-bs-toggle="modal"
                                data-bs-target="#signUpModal">Sign Up</a>

                        </div>
                        <div class="menu-signsignup-link d-none">
                            <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#signInModal">
                                <img src="<?php echo e(asset('images/user-icon-up.svg')); ?>" class="svg actual" width="22"
                                    height="22">
                                <p class="mb-0 d-inline-block align-middle"><?php echo e(trans('user.sidebar.sign_in')); ?> </p>
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="d-flex gap-3 align-items-center">
                            <div class="userPhoto">
                                <img src="<?php echo e(Auth::user()->image); ?>" alt=""  width="50"
                                    height="50" />
                            </div>
                            <div class="text-start">
                                <div class="dropdown">
                                    <?php echo e(Auth::user()->full_name); ?>

                                    <ul class="dropdown-menu py-0">
                                        <li>
                                            <a class="dropdown-item log-out-item" href="#"
                                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                <img src="<?php echo e(asset('images/log-out.svg')); ?>" class="svg actual"
                                                    width="25" height="26">
                                                <?php echo e(trans('user.sidebar.logout')); ?>

                                            </a>
                                            <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST"
                                                class="d-none"> <?php echo csrf_field(); ?> </form>
                                        </li>
                                    </ul>
                                </div>
                                <div class="text-truncate" style="color: #a4a4a4;"><?php echo e(Auth::user()->email); ?>

                                </div>
                            </div>

                            <div class="ms-auto">
                                <a class="dropdown-item log-out-item" href="#"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <img src="<?php echo e(asset('images/sign-out-up.svg')); ?>" class="svg actual" width="20"
                                        height="20" />
                                    
                                </a>
                                <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST"
                                    class="d-none"> <?php echo csrf_field(); ?>
                                </form>
                            </div>


                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="sidebar-menu-top-box d-none">
                <?php if(!Auth::user()): ?>
                    <div class="auth_enter_btns">

                    </div>
                    <div class="menu-signsignup-link d-none">
                        <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#signInModal">
                            <img src="<?php echo e(asset('images/user-icon-up.svg')); ?>" class="svg actual" width="22"
                                height="22">
                            <p class="mb-0 d-inline-block align-middle"><?php echo e(trans('user.sidebar.sign_in')); ?> </p>
                        </a>
                    </div>
                <?php else: ?>
                    <div class="d-flex gap-3 align-items-center">
                        <div class="userPhoto">
                            <img src="<?php echo e(Auth::user()->image); ?>" alt=""  width="50"
                                height="50" />
                        </div>
                        <div class="text-start">
                            <div class="dropdown">
                                
                                <ul class="dropdown-menu py-0">
                                    <li>
                                        <a class="dropdown-item log-out-item" href="#"
                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <img src="<?php echo e(asset('images/log-out.svg')); ?>" class="svg actual"
                                                width="25" height="26">
                                            <?php echo e(trans('user.sidebar.logout')); ?>

                                        </a>
                                        <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST"
                                            class="d-none"> <?php echo csrf_field(); ?> </form>
                                    </li>
                                </ul>
                            </div>
                            <div class="text-truncate" style="color: var(--theme-dark1);"><?php echo e(Auth::user()->email); ?>

                            </div>
                        </div>

                        <div class="ms-auto">
                            <a class="dropdown-item log-out-item" href="#"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <img src="<?php echo e(asset('images/sign-out-up.svg')); ?>"  width="20"
                                    height="20" />
                                
                            </a>
                            <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
                                <?php echo csrf_field(); ?>
                            </form>
                        </div>
                    </div>
                <?php endif; ?>
            </div>



        </div>


    </div>


</aside>
<?php /**PATH E:\wamp\www\go-meal\resources\views/layouts/user/side_nav_bar.blade.php ENDPATH**/ ?>