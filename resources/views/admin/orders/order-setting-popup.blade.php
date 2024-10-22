<?php
$params = json_decode(getRestaurantDetail()->params, true);
$payment_settings = $params['order_settings'];
?>

<div class="modal fade custom-modal order-setting-popup" id="orderSettingModal" tabindex="-1"
    aria-labelledby="orderSettingModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">



<ul class="order-setting-tab mb-0">
    <li><a href="javascript:void(0)" class="active">Time</a></li>
    <li><a href="javascript:void(0)">Sort</a></li>
    <li><a href="javascript:void(0)">Display</a></li>
</ul>

<div class="modal-body p-0">
 <div class="order-setting-tab-content">
<div class="setting-panel-tab" id="tab-time">
<h3 class="mb-2 text-uppercase">{{ trans('rest.order_screen_settings.show_orders') }}</h3>

<div class="radio-tabs">
    <label class="status-option specific-timezone active">
        <input id="order-setting-timezone" type="radio" name="orderSetting" 
            {{ $payment_settings['order_setting_type'] == '1' ? 'checked' : '' }} checked />
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
                <label class="radio-option date_type">
                    <input type="radio" name="date_type" value="1" {{ $payment_settings['expiry_date'] == '1' ? 'checked':'' }}>
                    <span>{{ trans('rest.order_screen_settings.today') }}</span>
                </label>
                <label class="radio-option date_type">
                    <input type="radio" name="date_type" value="-2" {{ $payment_settings['expiry_date'] == '-2' ? 'checked':'' }}>
                    <span>{{ trans('rest.order_screen_settings.today_yesterday') }}</span>
                </label>
                <label class="radio-option date_type">
                    <input type="radio" name="date_type" value="-1" {{ $payment_settings['expiry_date'] == '-1' ? 'checked':'' }}>
                    <span>{{ trans('rest.order_screen_settings.yesterday') }}</span>
                </label>
                <label class="radio-option date_type">
                    <input type="radio" name="date_type" value="-7" {{ $payment_settings['expiry_date'] == '-7' ? 'checked':'' }}>
                    <span>{{ trans('rest.order_screen_settings.last_7_days') }}</span>
                </label>
                <label class="radio-option date_type">
                    <input type="radio" name="date_type" value="-14" {{ $payment_settings['expiry_date'] == '-14' ? 'checked':'' }}>
                    <span>{{ trans('rest.order_screen_settings.last_14_days') }}</span>
                </label>
                <label class="radio-option date_type">
                    <input type="radio" name="date_type" value="-30" {{ $payment_settings['expiry_date'] == '-30' ? 'checked':'' }}>
                    <span>{{ trans('rest.order_screen_settings.last_30_days') }}</span>
                </label>
                <label class="radio-option custom_time_order_setting">
                    <input type="radio" name="date_type" value="custom_date" {{ $payment_settings['expiry_date'] == 'custom_date' ? 'checked':'' }}>
                    <span>{{ trans('rest.order_screen_settings.custom') }}</span>
                </label>
            </div>

        </div>
        <div class="row g-2 time-date-controls custom-date-selector {{ $payment_settings['expiry_date'] == 'custom_date' ? '':'d-none' }}">
            <h3 class="mb-2 text-uppercase">{{ trans('rest.order_screen_settings.custom_date') }}</h3>
            <div class="col-md-6 mt-0">
                <div class="input-group start-date-input">
                    <input type="text" placeholder="Select Start Date" class="form-control datepicker"
                           id="start-date" aria-label="start_date" name="start_date" readonly value="" required>
                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                </div>
            </div>
            <div class="col-md-6 mt-0">
                <div class="input-group end-date-input">
                    <input type="text" placeholder="Select End Date" class="form-control datepicker"
                           id="end-date" aria-label="end_date" name="end_date" readonly value="" required>
                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                </div>
            </div>
        </div>
    </div>

    <p class="note py-3 pb-1"> NOTE: {{ trans('rest.order_screen_settings.note') }}</p>

    <div class="d-flex gap-2 justify-content-end">
        <button type="button" aria-label="Close"
            class="btn btn-site-theme text-uppercase px-5 saveReset">
            {{ trans('rest.order_screen_settings.reset_save') }}
        </button>

        <button type="submit" aria-label="Close"
            class="btn btn-site-theme text-uppercase px-5">{{ trans('rest.order_screen_settings.save_changes') }}</button>

    </div>
</form>

</div>

<div class="setting-panel-tab d-none" id="sort-time">
<h3 class="mb-2 text-uppercase">Sort</h3>
</div>

<div class="setting-panel-tab d-none" id="display-time">
<h3 class="mb-2 text-uppercase">Sort</h3>

<div class="order-display-checking">
        <div class="form-check form-switch">
            <label class="form-check-label" for="flexSwitchCheckDefault1">Time orders on top</label>
            <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault1" checked>
        </div>
        
        <div class="form-check form-switch">
            <label class="form-check-label" for="flexSwitchCheckDefault2">Display red color on orders that are late.</label>
            <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault2">
        </div>
        
        <div class="form-check form-switch">
            <label class="form-check-label" for="flexSwitchCheckDefault3">Show older open orders always</label>
            <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault3">
        </div>
    </div>
</div>

</div>
 </div>

            <!-- <div class="modal-header pb-1">
                {{ trans('rest.order_screen_settings.title') }}
            </div> -->

        </div>
    </div>
</div>
