<div class="tab-pane fade active show" id="unused-tab-pane" role="tabpanel" aria-labelledby="unused-coupons-tab"
    tabindex="0">
    <section class="">
        <div class="card custom-card">

            <div class="card-body coupon-card-row w-100 pb-0">

                @if (count($unexpiredCoupons) == 0)
                <p>No available coupons. Redeem points to get coupons at my points page.</p>
                @else
                <div class="coupon-row-grid">
                    @foreach ($unexpiredCoupons as $key => $unexpiredCoupon)
                    <?php  $coupon = $unexpiredCoupon->coupon ?>
                        <div class="coupon-col">
                            <div class="coupon-inn shadow-mobile">
                                <div class="coupon-flex">
                                    <div class="left-cp">
                                        <h2>{{ $coupon->percentage_off }}% {{ trans('user.coupons.off') }}</h2>
                                        <p class="mb-0">{{ trans('user.coupons.min_order') }}  €{{ $coupon->price }}</p>
                                    </div>
                                    <div class="right-cp text-center">
                                        <p class="mb-1">{{ trans('user.coupons.valid_till') }} {{ $coupon->end_expiry_date }}</p>
                                        <a href="#" class="get-code-btn" data-code="{{ $coupon->promo_code }}" onclick="revealCode(event, this)">GET CODE</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @endif
                <div class="coupon-row-grid">

                    {{-- <div class="coupon-col">
                        <div class="coupon-inn">
                            <div class="coupon-flex">
                                <div class="left-cp">
                                    <h2>50% OFF</h2>
                                    <p class="mb-0">Minimum order $20</p>
                                </div>
                                <div class="right-cp text-center">
                                    <p class="mb-1">Valid until 10-6-2024</p>
                                    <a href="#" class="get-code-btn">GET CODE</a>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="coupon-col">
                        <div class="coupon-inn">
                            <div class="coupon-flex">
                                <div class="left-cp">
                                    <h2>50% OFF</h2>
                                    <p class="mb-0">Minimum order $20</p>
                                </div>
                                <div class="right-cp text-center">
                                    <p class="mb-1">Valid until 10-6-2024</p>
                                    <a href="#" class="get-code-btn">GET CODE</a>
                                </div>
                            </div>
                        </div>
                    </div> --}}

                    {{-- <div class="coupon-col">
                        <div class="coupon-inn">
                            <div class="coupon-flex">
                                <div class="left-cp">
                                    <h2>50% OFF</h2>
                                    <p class="mb-0">Minimum order $20</p>
                                </div>
                                <div class="right-cp text-center">
                                    <p class="mb-1">Valid until 10-6-2024</p>
                                    <a href="#" class="get-code-btn">
                                        <svg width="14" height="16" viewBox="0 0 14 16" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <rect x="0.5" y="0.5" width="10" height="12" rx="1.5"
                                                stroke="#F8B602" />
                                            <rect x="3.5" y="3.5" width="10" height="12" rx="1.5"
                                                fill="white" stroke="#F8B602" />
                                        </svg>
                                        GNUSNZK</a>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="coupon-col">
                        <div class="coupon-inn">
                            <div class="coupon-flex">
                                <div class="left-cp">
                                    <h2>50% OFF</h2>
                                    <p class="mb-0">Minimum order $20</p>
                                </div>
                                <div class="right-cp text-center">
                                    <p class="mb-1">Valid until 10-6-2024</p>
                                    <a href="#" class="get-code-btn">GET CODE</a>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="coupon-col">
                        <div class="coupon-inn">
                            <div class="coupon-flex">
                                <div class="left-cp">
                                    <h2>50% OFF</h2>
                                    <p class="mb-0">Minimum order $20</p>
                                </div>
                                <div class="right-cp text-center">
                                    <p class="mb-1">Valid until 10-6-2024</p>
                                    <a href="#" class="get-code-btn">GET CODE</a>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="coupon-col">
                        <div class="coupon-inn">
                            <div class="coupon-flex">
                                <div class="left-cp">
                                    <h2>50% OFF</h2>
                                    <p class="mb-0">Minimum order $20</p>
                                </div>
                                <div class="right-cp text-center">
                                    <p class="mb-1">Valid until 10-6-2024</p>
                                    <a href="#" class="get-code-btn">GET CODE</a>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="coupon-col">
                        <div class="coupon-inn">
                            <div class="coupon-flex">
                                <div class="left-cp">
                                    <h2>50% OFF</h2>
                                    <p class="mb-0">Minimum order $20</p>
                                </div>
                                <div class="right-cp text-center">
                                    <p class="mb-1">Valid until 10-6-2024</p>
                                    <a href="#" class="get-code-btn">GET CODE</a>
                                </div>
                            </div>
                        </div>

                    </div> --}}

                    {{-- @if (count($coupons) == 0)
                    <p>No available coupons. Redeem points to get coupons at my points page.</p>
                @else
                    @foreach ($coupons as $key => $coupon)
                        <div class="card custom-card coupons-card p-0">
                            <?php $lockedCoupon = ''; ?>
                            @if (!empty($coupon->points) && $coupon->points >= $user->collected_points && $coupon->couponTransaction->is_redeemed == '1')
                                <?php $lockedCoupon = 'locked-coupon'; ?>
                            @elseif(isset($coupon->couponTransaction) && $coupon->couponTransaction->is_redeemed == '1')
                                <?php $lockedCoupon = 'locked-coupon'; ?>
                            @endif
                            <div class="card-body p-0 {{ $lockedCoupon }} ">
                                <div class="inner-card">
                                    <div class="inner-card-body">
                                        <h3>{{ $coupon->percentage_off }}<sup>%</sup>
                                            <sub>{{ trans('user.coupons.off') }}</sub>
                                        </h3>
                                        <h6>{{ trans('user.coupons.min_order') }} €{{ $coupon->price }}</h6>
                                        <div class="dotted-divider"></div>
                                        <p class="valid-date mb-0">{{ trans('user.coupons.valid_till') }}
                                            {{ $coupon->end_expiry_date }}</p>
                                    </div>
                                    <div class="promocode-box">
                                        @if ($coupon->couponTransaction || is_null($coupon->points))
                                            <p class="mb-0 d-inline-block">{{ trans('user.coupons.promo_code') }}</p>
                                            <a href="javascript:void(0);"
                                                class="badge text-bg-white d-inline-block">{{ $coupon->promo_code }}</a>
                                        @elseif($user->collected_points >= $coupon->points)
                                            <p class="mb-0 d-inline-block">{{ trans('user.coupons.promo_code') }}</p>
                                            <a href="javascript:void(0);" class="badge text-bg-white d-inline-block"
                                                id="coupon-code-{{ $coupon->id }}"
                                                data-code="{{ $coupon->promo_code }}"
                                                onclick='showCouponPopup({{ $coupon->id }})'>
                                                {{ trans('user.coupons.get_code') }}</a>
                                        @else
                                            <p class="mb-0 d-inline-block">
                                                {{ trans('user.coupons.earn_points', ['points' => $coupon->points]) }}
                                            </p>
                                        @endif
                                    </div>
                                    <div class="circle1"></div>
                                    <div class="circle2"></div>
                                    <div class="checkcircle d-block">
                                        <i class="fas fa-check text-light align-middle"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    <input type="hidden" id="coupon-code">
                    <input type="hidden" id="coupon-id">
                @endif --}}

                </div>
            </div>
    </section>
</div>
