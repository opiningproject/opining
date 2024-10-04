<?php
$params = json_decode(getRestaurantDetail()->params, true);
$payment_settings = $params['order_settings'];
?>

<div class="modal fade custom-modal order-setting-popup" id="orderSettingModal" tabindex="-1"
    aria-labelledby="orderSettingModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header pb-1">
                {{ trans('rest.order_screen_settings.title') }}
            </div>
            <div class="modal-body">
                <h3 class="mb-2 text-uppercase">{{ trans('rest.order_screen_settings.show_orders') }}</h3>

                <div class="radio-tabs">
                    <label class="status-option specific-timezone active">
                        <input id="order-setting-timezone" type="radio" name="orderSetting" checked
                            {{ $payment_settings['order_setting_type'] == '1' ? 'checked' : '' }} />
                        <span for="order-setting-timezone"></span>
                        <label
                            class="text-uppercase">{{ trans('rest.order_screen_settings.specific_timezone') }}</label>
                    </label>
                    <label class="status-option specific-day">
                        <input id="order-setting-date" type="radio" name="orderSetting"
                            {{ $payment_settings['order_setting_type'] == '2' ? 'checked' : '' }} />
                        <span for="order-setting-date"></span>
                        <label class="text-uppercase">{{ trans('rest.order_screen_settings.specific_day') }}</label>
                    </label>
                </div>
                <form class="order-setting-form" id="order-setting-form">
                    <input type="hidden" name="order_setting_type" class="order_setting_type" value="1">
                    <div class="order-setting-content pt-4 pb-4" id="timezone-setting">
                        <select class="form-control timezone-setting" name="timezone_setting">
                            <option disabled {{ !isset($payment_settings['timezone_setting']) ? 'selected' : '' }}>
                                {{ trans('rest.order_screen_settings.select_time') }}
                            </option>
                            @for ($i = 6; $i <= 24; $i++)
                                <option value="{{ $i }}"
                                    {{ isset($payment_settings['timezone_setting']) && $payment_settings['timezone_setting'] == $i ? 'selected' : '' }}>
                                    {{ trans('rest.order_screen_settings.past_' . $i . '_hours') }}
                                </option>
                            @endfor
                        </select>
                    </div>

                    <div class="date-range-section pt-4 pb-4 d-none" id="date-range">
                        <h3 class="mb-2 text-uppercase">{{ trans('rest.order_screen_settings.custom_date') }}</h3>

                        <div class="ml-content">

                            <div class="radio-group date-options-row mb-3">
                                <label class="radio-option">
                                    <input type="radio" name="date-type" checked="">
                                    <span>TODAY</span>
                                </label>
                                <label class="radio-option">
                                    <input type="radio" name="date-type">
                                    <span>TODAY AND YESTERDAY</span>
                                </label>
                                <label class="radio-option">
                                    <input type="radio" name="date-type">
                                    <span>YESTERDAY</span>
                                </label>
                                <label class="radio-option">
                                    <input type="radio" name="date-type">
                                    <span>LAST 7 DAYS</span>
                                </label>
                                <label class="radio-option">
                                    <input type="radio" name="date-type">
                                    <span>LAST 14 DAYS</span>
                                </label>
                                <label class="radio-option">
                                    <input type="radio" name="date-type">
                                    <span>LAST 30 DAYS</span>
                                </label>
                                <label class="radio-option">
                                    <input type="radio" name="date-type">
                                    <span>Custom</span>
                                </label>
                            </div>

                        </div>

                        <div class="row g-2 time-date-controls"> 
                            <h3 class="mb-2 text-uppercase">CUSTOM DATE</h3>
                            <div class="col-md-6 mt-0">
                                <div class="input-group">
                                    <input type="text" id="start-date" class="form-control"
                                        placeholder="Select start date">
                                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                </div>
                            </div>
                            <div class="col-md-6 mt-0">
                                <div class="input-group">
                                    <input type="text" id="end-date" class="form-control"
                                        placeholder="Select end date">
                                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                </div>
                            </div>
                        </div>

                        {{-- <div class="row justify-content-center">
                            <div class="col-sm-12">
                                <input type="hidden" class="order-setting-custom-time"
                                    value="{{ $payment_settings['expiry_date'] }}">
                                <input type="text" placeholder="Select Date For Filter" class="form-control"
                                    id="order-setting-custom-time" aria-label="expiry_date" name="expiry_date"
                                    value="{{ $payment_settings['expiry_date'] }}" required>
                                <span id="startDateSelected"></span>
                            </div>
                        </div> --}}

                    </div>

                    <p class="note py-3 pb-1"> NOTE: {{ trans('rest.order_screen_settings.note') }}</p>

                    <div class="d-flex gap-2 justify-content-end">
                        <button type="button" aria-label="Close"
                            class="btn btn-site-theme text-uppercase px-5 saveReset"
                            onclick="saveReset()">{{ trans('rest.order_screen_settings.reset_save') }}</button>

                        <button type="submit" aria-label="Close"
                            class="btn btn-site-theme text-uppercase px-5">{{ trans('rest.order_screen_settings.save_changes') }}</button>

                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
