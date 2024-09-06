@php
    $params = json_decode(getRestaurantDetail()->params,true);
    $payment_settings = $params['payment_settings'];
    $firstSelected = false;
    $selectedPaymentType = null;
@endphp
<div class="tab-pane fade" id="checkoutSetting-tab-pane" role="tabpanel" aria-labelledby="checkoutSetting-tab"
     tabindex="0">
    <div class="card-body">
        <div class="paymentHistory-card-body  py-3 pt-0">
            <p> {{ trans('rest.settings.checkout_setting.title') }} </p>
            <div class="border-custom-1"></div>
            <div class="paymentHistory-table custom-table mt-5">
                <div class="row">
                    <div
                        class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-check form-switch custom-switch d-flex align-items-center gap-3 ps-0">
                        <label
                            class="form-check-label form-label mb-0">{{ trans('rest.settings.checkout_setting.ideal_payment') }}</label>
                        <input class="form-check-input" type="checkbox" name="ideal"
                               role="switch" {{ $payment_settings['ideal'] == 1 ? 'checked':'' }} onchange="changePaymentSetting('ideal')">
                    </div>
                    <div
                        class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-check form-switch custom-switch d-flex align-items-center gap-3 ps-0">
                        <label
                            class="form-check-label form-label mb-0">{{ trans('rest.settings.checkout_setting.card_payment') }}</label>
                        <input class="form-check-input" type="checkbox" name="card"
                               role="switch" {{ $payment_settings['card'] == 1 ? 'checked':'' }} onchange="changePaymentSetting('card')">
                    </div>
                    <div
                        class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12 col-12 form-check form-switch custom-switch d-flex align-items-center gap-3 ps-0">
                        <label
                            class="form-check-label form-label mb-0">{{ trans('rest.settings.checkout_setting.cod_payment') }}</label>
                        <!-- switch online order Acceptance -->
                        <input class="form-check-input" type="checkbox" name="cod"
                               role="switch" {{ $payment_settings['cod'] ? 'checked':'' }} onchange="changePaymentSetting('cod')">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
