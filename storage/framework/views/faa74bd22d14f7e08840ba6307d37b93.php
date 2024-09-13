<footer id="footer-style">
    <div class="footer-link-item-grid">
    </div>
    <div class="container">
    <div class="row footer-link-item text-center text-md-start">
        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-12 text-left mb-4 mb-md-0 logo-col">
            <div class="footer-logo">
                <a href="javascript:void(0);">
                    <img src="<?php echo e(getRestaurantDetail()->footer_logo); ?>" class="web-logo">
                </a>
            </div>
        </div>
        <div class="col-xxl-9 col-xl-9 col-lg-9 col-md-9 col-sm-12 col-12">
            <div class="row">
                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-12 mb-4 mb-md-3 d-none d-md-block">
                    <div class="footer-link">
                        <ul>
                            <li class="mb-2"><a href="<?php echo e(route('user.dashboard')); ?>" class="nav-link auth-link-check"><?php echo e(trans('user.footer.dashboard')); ?></a></li>
                            <li class="mb-2"><a href="<?php echo e(route('user.settings')); ?>" class="nav-link auth-link-check"><?php echo e(trans('user.footer.profile')); ?></a></li>
                            <li class="mb-2"><a href="<?php echo e(route('user.coupons')); ?>" class="nav-link auth-link-check"><?php echo e(trans('user.footer.my_coupons')); ?></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-6 col-6 mb-4 mb-md-3 d-none d-md-block">
                    <div class="footer-link">
                        <ul>
                            <li class="mb-2"><a href="<?php echo e(route('user.chat')); ?>" class="nav-link auth-link-check"><?php echo e(trans('user.footer.chat')); ?></a></li>
                            <li class="mb-2"><a href="<?php echo e(route('terms')); ?>"><?php echo e(trans('user.footer.terms')); ?></a></li>
                            <li class="mb-2"><a href="<?php echo e(route('privacy-policy')); ?>"><?php echo e(trans('user.footer.privacy')); ?></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-12 order-2 order-md-1 mb-0 mb-md-3">
                    <div class="footer-link contact-us-listing">
                        <ul>
                            <li class="mb-0 mb-md-2"><span class="d-block m-title">Contact us</span></li>
                            <li class="mb-2">
                                <a href="tel:+31<?php echo e(getRestaurantDetail()->phone_no); ?>" class="d-flex align-items-start justify-content-center justify-content-md-start">
                                    <img src="<?php echo e(asset('images/phone-icon.svg')); ?>" class="img-fluid mt-1" width="16" height="16">
                                    <span class="d-inline-block ps-2">+31 <?php echo e(getRestaurantDetail()->phone_no); ?></span>
                                </a>
                            </li>
                            <li class="mb-2">
                                <a href="mailto:<?php echo e(getRestaurantDetail()->user->email); ?>" class="d-flex align-items-start justify-content-center justify-content-md-start">
                                    <img src="<?php echo e(asset('images/mail-icon.svg')); ?>" class="img-fluid mt-2"  width="18" height="13">
                                    <span class="d-inline-block ps-2"><?php echo e(getRestaurantDetail()->user->email); ?></span>
                                </a>
                            </li>
                            <li class="mb-2">
                                <a href="javascript:void(0);" class="d-flex align-items-start justify-content-center justify-content-md-start">
                                    <img src="<?php echo e(asset('images/address-icon.svg')); ?>" class="img-fluid mt-1" width="13" height="17">
                                    <span class="d-inline-block ps-2"><?php echo e(getRestaurantDetail()->rest_address); ?></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-12 order-1 order-md-2 mb-4 mb-md-3">
                    <div class="footer-link">
                        <ul class="hrs-listing">
                            <li class="mb-0 mb-md-2"><span class="d-block m-title"><?php echo e(trans('user.footer.opening_hours')); ?></span></li>
                            <?php

                            $days = App\Models\OperatingHour::all();

                            if(!empty($days))
                            {
                                // Initialize an array to store grouped days
                                $groupedDays = array();

                                // Group days with the same opening and closing times
                                foreach ($days as $day => $times)
                                {
                                    $formattedTimes =  date("H:i", strtotime($times['start_time'])) .' - '. date("H:i", strtotime($times['end_time']));

                                    if (!isset($groupedDays[$formattedTimes]))
                                    {
                                        $groupedDays[$formattedTimes] = array();
                                    }

                                    $groupedDays[$formattedTimes][] = $times->day;
                                }

                                // Display the result
                                foreach ($groupedDays as $formattedTimes => $days)
                                {
                                    if(count($days) > 2)
                                    {
                                         echo '<li  class="mb-2">'.$days[0].' - '.$days[count($days)-1]." : $formattedTimes</li>";
                                    }
                                    else
                                    {
                                         echo '<li  class="mb-2">'.implode(' - ', $days) . " : $formattedTimes</li>";
                                    }
                                }
                            }

                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <div class="footer-bottom text-center">
        <p class="mb-1 footer-copyright-text"><?php echo e(trans('user.footer.rights_reserved',['app_name' => env('APP_NAME')])); ?></p>
        <p class="d-block d-md-none footer-bottom-link mb-0"><a href="<?php echo e(route('terms')); ?>"><?php echo e(trans('user.footer.terms')); ?></a>  -  <a href="<?php echo e(route('privacy-policy')); ?>"><?php echo e(trans('user.footer.privacy')); ?></a></p>
    </div>
</footer>
<?php /**PATH E:\wamp\www\go-meal\resources\views/layouts/user/footer_design.blade.php ENDPATH**/ ?>