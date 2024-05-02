<div class="modal fade custom-modal" id="changeStatusModal" tabindex="-1" aria-labelledby="changeStatusModal" aria-hidden="true">
    <div class="modal-dialog custom-w-441px modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <h4 class="alert-text-1 mb-40px text-unset">{{ trans('rest.modal.order_status.alert_message') }} <span id="order_status_name"></span>?</h4>
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <button type="button" class="btn btn-outline-secondary fw-400 text-uppercase font-sebibold w-160px" data-bs-dismiss="modal">{{ trans('rest.button.no') }}</button>
                    <button type="button" class="btn btn-custom-yellow fw-400 text-uppercase font-sebibold w-160px" id="change-order-status-btn">{{ trans('rest.button.yes') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>