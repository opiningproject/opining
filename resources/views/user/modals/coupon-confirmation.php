<div class="modal fade" id="couponConfirmationModal" tabindex="-1" role="dialog" aria-labelledby="couponConfirmationModal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Coupon confirmation</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <h5 id="coupon-code-text">Are you sure you want to buy this coupon code ?</h5>
        <div class="text-center">
          <div class="coupon-code-box d-none">
           Coupon : <span id="coupon-code-name"></span>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-custom-yellow" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-custom-yellow" onclick="couponCodeConfirmation();" id="submit-btn">Yes! I want a Coupon!</button>
      </div>
    </div>
  </div>
</div>
