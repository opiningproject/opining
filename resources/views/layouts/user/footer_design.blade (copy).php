<footer>
    <div class="footer-link-item-grid">
    </div>
    <div class="row footer-link-item">
        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-4 col-sm-12 col-12 text-lg-center text-left mb-4 mb-md-0">
            <div class="footer-logo">
                <a href="javascript:void(0);">
                    <img src="{{ getRestaurantDetail()->restaurant_logo }}" style="max-width: 100%;">
                </a>
            </div>
        </div>
        <div class="col-xxl-8 col-xl-8 col-lg-8 col-md-8 col-sm-12 col-12">
            <div class="row">
                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-6 col-6 mb-4 mb-md-0">
                    <div class="footer-link">
                        <ul>
                            <li><a href="{{ route('user.dashboard') }}" class="nav-link">Dashboard</a></li>
                            <li><a href="{{ route('user.settings') }}" class="nav-link">Profile</a></li>
                            <li><a href="{{ route('user.coupons') }}" class="nav-link">My Coupon</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-6 col-6 mb-4 mb-md-0">
                    <div class="footer-link">
                        <ul>
                            <li><a href="{{ route('user.chat') }}" class="nav-link">Chat Support</a></li>
                            <li><a href="{{ route('terms') }}">Terms & Condition</a></li>
                            <li><a href="{{ route('privacy-policy') }}">Privacy Policy</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-6 col-6">
                    <div class="footer-link">
                        <ul>
                            <li>
                                <a href="javascript:void(0);">
                                    <img src="{{ asset('images/phone-icon.svg') }}" class="img-fluid" width="16" height="16">
                                    +31 {{ getRestaurantDetail()->phone_no }}
                                </a>
                            </li>
                            <li><a href="javascript:void(0);">
                                    <img src="{{ asset('images/mail-icon.svg') }}" class="img-fluid"  width="18" height="13">
                                    {{ getRestaurantDetail()->user->email }}
                                </a></li>
                            <li><a href="javascript:void(0);">
                                    <img src="{{ asset('images/address-icon.svg') }}" class="img-fluid" width="13" height="17">
                                    {{ getRestaurantDetail()->rest_address }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-6 col-6">
                    <div class="footer-link">
                        <ul>
                            <li><a>Opening Hours</a></li>
                            <?php 

                            $days = App\Models\OperatingHour::all();

                            $sameTimeDays = array();
                            $differentTimeDays = array();

                            foreach($days as $key => $day)
                            {
                                if($days[0]->start_time == $day->start_time && $days[0]->end_time == $day->end_time)
                                {
                                    $sameTimeDays[] = $day->day;
                                }
                                else 
                                {
                                    $differentTimeDays[] = $day->day;
                                }
                            }

                            print_r($sameTimeDays);
                            print_r($differentTimeDays);
                            exit;

                            ?>

                            <!-- <li><a>Mon - Fri : 08:00 - 16:00</a></li>
                            <li><a>Sat - Sun : 08:00 - 16:00</a></li> -->
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom text-center">
        <p class="mb-0 footer-copyright-text">Gomeal &copy; 2024 Gomeal - ALL Rights Reserved</p>
    </div>
</footer>
