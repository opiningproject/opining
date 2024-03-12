<footer>
    <div class="footer-link-item-grid">
    </div>
    <div class="container">
    <div class="row footer-link-item">
        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 col-12 text-left mb-4 mb-md-0">
            <div class="footer-logo">
                <a href="javascript:void(0);">
                    <img src="{{ getRestaurantDetail()->footer_logo }}" class="web-logo">
                </a>
            </div>
        </div>
        <div class="col-xxl-9 col-xl-9 col-lg-9 col-md-9 col-sm-12 col-12">
            <div class="row">
                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-6 col-6 mb-4 mb-md-0">
                    <div class="footer-link">
                        <ul>
                            <li class="mb-2"><a href="{{ route('user.dashboard') }}" class="nav-link auth-link-check">Dashboard</a></li>
                            <li class="mb-2"><a href="{{ route('user.settings') }}" class="nav-link auth-link-check">Profile</a></li>
                            <li class="mb-2"><a href="{{ route('user.coupons') }}" class="nav-link auth-link-check">My Coupon</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-6 col-6 mb-4 mb-md-0">
                    <div class="footer-link">
                        <ul>
                            <li class="mb-2"><a href="{{ route('user.chat') }}" class="nav-link auth-link-check">Chat Support</a></li>
                            <li class="mb-2"><a href="{{ route('terms') }}">Terms & Condition</a></li>
                            <li class="mb-2"><a href="{{ route('privacy-policy') }}">Privacy Policy</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-6 col-6">
                    <div class="footer-link">
                        <ul>
                            <li class="mb-2">
                                <a href="tel:+31{{ getRestaurantDetail()->phone_no }}" class="d-flex align-items-start">
                                    <img src="{{ asset('images/phone-icon.svg') }}" class="img-fluid mt-1" width="16" height="16">
                                    <span class="d-inline-block ps-2">+31 {{ getRestaurantDetail()->phone_no }}</span>
                                </a>
                            </li>
                            <li class="mb-2">
                                <a href="mailto:{{ getRestaurantDetail()->user->email }}" class="d-flex align-items-start">
                                    <img src="{{ asset('images/mail-icon.svg') }}" class="img-fluid mt-2"  width="18" height="13">
                                    <span class="d-inline-block ps-2">{{ getRestaurantDetail()->user->email }}</span>
                                </a>
                            </li>
                            <li class="mb-2">
                                <a href="javascript:void(0);" class="d-flex align-items-start">
                                    <img src="{{ asset('images/address-icon.svg') }}" class="img-fluid mt-1" width="13" height="17">
                                    <span class="d-inline-block ps-2">{{ getRestaurantDetail()->rest_address }}</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-6 col-6">
                    <div class="footer-link">
                        <ul>
                            <li class="mb-2"><a>Opening Hours</a></li>
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
                                         echo '<li  class="mb-2"><a>'.$days[0].' - '.$days[count($days)-1]." : $formattedTimes</a></li>";
                                    }
                                    else
                                    {
                                         echo '<li  class="mb-2"><a>'.implode(' - ', $days) . " : $formattedTimes</a></li>";
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
        <p class="mb-0 footer-copyright-text">Gomeal &copy; 2024 Gomeal - ALL Rights Reserved</p>
    </div>
</footer>
