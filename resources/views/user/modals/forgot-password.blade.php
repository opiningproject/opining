<div class="modal fade custom-modal" id="resendPasswordModal" tabindex="-1" aria-labelledby="resendPasswordModal" aria-hidden="true">
  <div class="modal-dialog custom-w-441px modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header border-0 justify-content-center">
        <h1 class="logo-text text-dark-1">
          <a href="javascript:void(0);">
              <div class="d-flex">
                  <img src="{{ getRestaurantDetail()->restaurant_logo }}" class="web-logo">
              </div>
          </a>
        </h1>
      </div>
      <div class="modal-body signin-form">
        <form id="forgot-pwd-form" method="POST">
          <h3 class="authenticationform-title">Forgot Password</h3>
          <div class="form-group prev-input-group custom-icon-input-group mb-0">
            <img src="{{ asset('images/mail-icon2.svg') }}" alt="" width="18" height="12"  class="svg">
            <input type="email" class="form-control" placeholder="Email" id="email" name="email" required>
            <label id="email-error" class="error" for="email" style="display: none"></label>
          </div>
          <button type="submit" class="btn btn-custom-yellow fw-400 text-uppercase font-sebibold w-100 mt-30px" id="forgot-pwd-btn">Send Password Reset Link</button>
        </form>
      </div>
    </div>
  </div>
</div>
