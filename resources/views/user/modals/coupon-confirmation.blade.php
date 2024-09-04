<div class="modal fade" id="couponConfirmationModal" tabindex="-1" role="dialog" aria-labelledby="couponConfirmationModal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">{{ trans('modal.coupon.title') }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p id="coupon-code-text">{{ trans('modal.coupon.content') }}</p>
        <div class="text-center">
          <div class="coupon-code-box d-none">
           {{ trans('modal.coupon.coupon') }} : <span id="coupon-code-name"></span>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-custom-yellow" data-bs-dismiss="modal">{{ trans('modal.button.close') }}</button>
        <button type="button" class="btn btn-custom-yellow" onclick="couponCodeConfirmation();" id="submit-btn">{{ trans('modal.button.want_coupon') }}</button>
      </div>
    </div>
  </div>
</div>
