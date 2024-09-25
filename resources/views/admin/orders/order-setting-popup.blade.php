<div class="modal fade custom-modal order-setting-popup" id="orderSettingModal" tabindex="-1"
    aria-labelledby="orderSettingModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header pb-1">
                {{ trans('rest.order_screen_settings.title') }}
                <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
            </div>
            <div class="modal-body">
                <h3 class="mb-2 text-uppercase">{{ trans('rest.order_screen_settings.show_orders') }}</h3>

                <div class="radio-tabs">
                    <label class="status-option specific-timezone active">
                        <input id="order-setting-timezone" type="radio" name="orderSetting" checked />
                        <span for="order-setting-timezone"></span>
                        <label class="text-uppercase">{{ trans('rest.order_screen_settings.specific_timezone') }}</label>
                    </label>

                    <label class="status-option specific-day">
                        <input id="order-setting-date" type="radio" name="orderSetting" />
                        <span for="order-setting-date"></span>
                        <label class="text-uppercase">{{ trans('rest.order_screen_settings.specific_day') }}</label>
                    </label>
                </div>
                <form class="order-setting-form" id="order-setting-form">
                    <input type="hidden" name="order_setting_type" class="order_setting_type" value="1">
                    <div class="order-setting-content pt-4 pb-4" id="timezone-setting">

                            <select class="form-control timezone-setting" name="timezone_setting">
                                <option disabled selected>{{ trans('rest.order_screen_settings.select_date') }}</option>
                                <option value="6">{{ trans('rest.order_screen_settings.past_6_hours') }}</option>
                                <option value="7">{{ trans('rest.order_screen_settings.past_7_hours') }}</option>
                                <option value="8">{{ trans('rest.order_screen_settings.past_8_hours') }}</option>
                                <option value="9">{{ trans('rest.order_screen_settings.past_9_hours') }}</option>
                                <option value="10">{{ trans('rest.order_screen_settings.past_10_hours') }}</option>
                                <option value="11">{{ trans('rest.order_screen_settings.past_11_hours') }}</option>
                                <option value="12">{{ trans('rest.order_screen_settings.past_12_hours') }}</option>
                                <option value="13">{{ trans('rest.order_screen_settings.past_13_hours') }}</option>
                                <option value="14">{{ trans('rest.order_screen_settings.past_14_hours') }}</option>
                                <option value="15">{{ trans('rest.order_screen_settings.past_15_hours') }}</option>
                                <option value="16">{{ trans('rest.order_screen_settings.past_16_hours') }}</option>
                                <option value="17">{{ trans('rest.order_screen_settings.past_17_hours') }}</option>
                                <option value="18">{{ trans('rest.order_screen_settings.past_18_hours') }}</option>
                                <option value="19">{{ trans('rest.order_screen_settings.past_19_hours') }}</option>
                                <option value="20">{{ trans('rest.order_screen_settings.past_20_hours') }}</option>
                                <option value="21">{{ trans('rest.order_screen_settings.past_21_hours') }}</option>
                                <option value="22">{{ trans('rest.order_screen_settings.past_22_hours') }}</option>
                                <option value="23">{{ trans('rest.order_screen_settings.past_23_hours') }}</option>
                                <option value="24">{{ trans('rest.order_screen_settings.past_24_hours') }}</option>
                            </select>

                    </div>

                    <div class="date-range-section pt-4 pb-4 d-none" id="date-range">
                        <h3 class="mb-2 text-uppercase">{{ trans('rest.order_screen_settings.custom_date') }}</h3>
                        <div class="row justify-content-center">
                            <div class="col-sm-12">
                                <input type="text" placeholder="Select Date For Filter" class="form-control"
                                       id="order-setting-custom-time" aria-label="expiry_date" name="expiry_date" required>
                                <span id="startDateSelected"></span>
                            </div>
                        </div>
                    </div>

                    <p class="note py-3 pb-1"> NOTE: {{ trans('rest.order_screen_settings.note') }}</p>

                    <div class="d-flex justify-content-end">
                        <button type="submit" aria-label="Close"
                            class="btn btn-site-theme text-uppercase px-5">{{ trans('rest.order_screen_settings.save_changes') }}</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
