<div class="modal fade custom-modal order-setting-popup" id="orderSettingModal" tabindex="-1"
    aria-labelledby="orderSettingModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header pb-1">
                Order screen settings
                <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
            </div>
            <div class="modal-body">
                <h3 class="mb-2 text-uppercase">SHOW ORDERS</h3>

                <div class="radio-tabs">
                    <label class="status-option active">
                        <input id="test1" type="radio" name="orderStatus" checked />
                        <span for="test1"></span>
                        <label class="text-uppercase">SPECIFIC TIMEZONE</label>
                    </label>

                    <label class="status-option">
                        <input id="test2" type="radio" name="orderStatus" />
                        <span for="test2"></span>
                        <label class="text-uppercase">SPECIFIC DAY</label>
                    </label>
                </div>

                <div class="order-setting-content pt-4 pb-4" id="timezone-setting">
                    <form>
                        <select class="form-control">
                            <option>Past 6 Hours</option>
                            <option>Past 7 Hours</option>
                            <option>Past 8 Hours</option>
                            <option>Past 9 Hours</option>
                            <option>Past 10 Hours</option>
                            <option>Past 11 Hours</option>
                            <option>Past 12 Hours</option>
                            <option>Past 13 Hours</option>
                            <option>Past 14 Hours</option>
                            <option>Past 15 Hours</option>
                            <option>Past 16 Hours</option>
                            <option>Past 17 Hours</option>
                            <option>Past 18 Hours</option>
                            <option>Past 19 Hours</option>
                            <option>Past 20 Hours</option>
                            <option>Past 21 Hours</option>
                            <option>Past 22 Hours</option>
                            <option>Past 23 Hours</option>
                            <option>Past 24 Hours</option>
                        </select>
                    </form>
                </div>

                <div class="date-range-section" id="date-range">
                    <h3 class="mb-2 text-uppercase">CUSTOM DATE</h3>
                    <div class="row justify-content-center">
                        <div class="col-sm-6">
                            <input id="startDate" class="form-control" type="date" />
                            <span id="startDateSelected"></span>
                        </div>
                        <div class="col-sm-6">
                            <input id="endDate" class="form-control" type="date" />
                            <span id="endDateSelected"></span>
                        </div>
                    </div>
                </div>

                <p class="note py-3 pb-1">NOTE: Open orders will be shown allways, even if it is older then the choosen
                    timezone.</p>

                <div class="d-flex justify-content-end">
                    <button type="submit" data-bs-dismiss="modal" aria-label="Close"
                        class="btn btn-site-theme text-uppercase px-5">SAVE CHANGES</button>
                </div>

            </div>
        </div>
    </div>
</div>