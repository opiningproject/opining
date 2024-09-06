<div class="modal fade" id="redeemConfirmationModal" tabindex="-1" role="dialog" aria-labelledby="redeemConfirmationModal"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ trans('modal.redeem.title') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="coupon-code-text">{{ trans('modal.redeem.content') }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-site-theme"
                    data-bs-dismiss="modal">{{ trans('modal.button.close') }}</button>
                <button type="button" class="btn btn-site-theme" onclick="couponCodeConfirmation();"
                    id="submit-btn">{{ trans('modal.button.want_coupon') }}</button>
            </div>
        </div>
    </div>
</div>
