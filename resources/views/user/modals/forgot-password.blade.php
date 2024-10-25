<div class="modal fade custom-modal" id="resendPasswordModal" tabindex="-1" aria-labelledby="resendPasswordModal" aria-hidden="true">
  <div class="modal-dialog custom-w-441px modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header border-0 justify-content-center">
        <h1 class="logo-text text-dark-1 mb-0">
          <a href="javascript:void(0);">
              <div class="d-flex">
                  <img src="{{ getRestaurantDetail()->restaurant_logo }}" class="web-logo">
              </div>
          </a>
        </h1>
      </div>
      <div class="modal-body signin-form">
        <form id="forgot-pwd-form" method="POST">
          <h3 class="authenticationform-title mb-2">{{ trans('modal.auth.forgot_password') }}</h3>
          <div class="form-group prev-input-group custom-icon-input-group mb-2">
            <span class="input-group-icon">
              <img src="{{ asset('images/mail-icon2-up.svg') }}" alt="" width="18" height="12"  class="svg" />
            </span>
            <input type="email" class="form-control custom-control-with-icon ps-5" placeholder="{{ trans('modal.auth.email') }}" id="email" name="email" required>
            <label id="email-error" class="error" for="email" style="display: none"></label>
            <label id="success-msg" for="email" style="display: none;color: green;"></label>
          </div>
          <button type="submit" class="btn btn-site-theme fw-400 text-uppercase font-sebibold w-100 mt-xxl-2" id="forgot-pwd-btn">{{ trans('modal.button.send_password_link') }}</button>
        </form>
      </div>
    </div>
  </div>
</div>
