<div class="modal fade" id="redeemConfirmedModal" tabindex="-1" role="dialog" aria-labelledby="redeemConfirmedModal"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ trans('modal.redeem.title') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="coupon-code-text">{{ trans('modal.redeem.confirmed') }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-custom-yellow"   data-target="/user/coupons"
                    id="redeem-confirmed-btn">{{ trans('modal.button.see_my_coupons') }}</button>
            </div>
        </div>
    </div>
</div>
