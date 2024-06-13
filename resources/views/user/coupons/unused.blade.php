<div class="tab-pane fade" id="unused-tab-pane" role="tabpanel" aria-labelledby="unused-coupons-tab" tabindex="0">
  <section class="">
    <div class="card custom-card">
      <div class="card-body coupon-card-grid">
        @if(count($coupons) == 0)
        <p>No available coupons. Redeem points to get coupons at my points page.</p>
        @else 
        @foreach($coupons as $key => $coupon)
        <div class="card custom-card coupons-card p-0">
         <?php $lockedCoupon = ''; ?>
         @if(!empty($coupon->points) && $coupon->points >= $user->collected_points && $coupon->couponTransaction->is_redeemed == '1')
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
                <p class="valid-date mb-0">{{ trans('user.coupons.valid_till') }} {{ $coupon->end_expiry_date }}</p>
              </div>
              <div class="promocode-box">
                  @if($coupon->couponTransaction || is_null($coupon->points))
                  <p class="mb-0 d-inline-block">{{ trans('user.coupons.promo_code') }}</p>
                   <a href="javascript:void(0);" class="badge text-bg-white d-inline-block">{{ $coupon->promo_code }}</a>
                @elseif($user->collected_points >= $coupon->points)

                  <p class="mb-0 d-inline-block">{{ trans('user.coupons.promo_code') }}</p>
                  <a href="javascript:void(0);" class="badge text-bg-white d-inline-block" id="coupon-code-{{ $coupon->id }}" data-code="{{ $coupon->promo_code }}" onclick='showCouponPopup({{ $coupon->id }})'>
                  {{ trans('user.coupons.get_code') }}</a>
                @else
                  <p class="mb-0 d-inline-block">{{ trans('user.coupons.earn_points',['points' => $coupon->points]) }}</p>
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
        @endif
     
      </div>
    </div>
  </section>
</div>