<div class="modal fade custom-modal" id="signInModal" tabindex="-1" aria-labelledby="signInModal" aria-hidden="true">
  <div class="modal-dialog custom-w-441px modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header border-0 justify-content-center">
        <h1 class="logo-text text-dark-1 mb-0">
          <img src="{{ getRestaurantDetail()->restaurant_logo }}" class="web-logo">
        </h1>
      </div>
      <div class="modal-body signin-form">
        <form id="sign-in-form" method="POST">
          <div class="form-group prev-input-group custom-icon-input-group">
            <span class="input-group-icon">
              <img src="{{ asset('images/mail-icon2-up.svg') }}" alt="" width="18" height="12"  class="svg">
            </span>
            <input type="email" class="form-control custom-control-with-icon ps-5" placeholder="{{ trans('modal.auth.email') }}" name="email" id="email" required>
            <label id="email-error" class="error" for="email" style="display: none"></label>
          </div>
          <div class="form-group prev-input-group custom-icon-input-group password-input-icon mb-3">
            <span class="input-group-icon">
               <img src="{{ asset('images/password-up.svg') }}" alt="" width="15" height="20"  class="svg">
            </span>
            <input type="password" class="form-control login-pwd-icon custom-control-with-icon ps-5 pe-5" placeholder="{{ trans('modal.auth.password') }}" id="password" name="password" required>
            <label id="password-error" class="error" for="password" style="display: none"></label>
            <span class="input-group-icon passwordeye-icon login-signup-pwd-icon">
                 <img src="{{ asset('images/passwordeye-open.svg') }}" id="toggleSignInPassword" class="svg hide-password"  width="21" height="19"/>
                 <img src="{{ asset('images/passwordeye-icon.svg') }}" id="toggleSignInPassword" class="svg d-none show-password"  width="21" height="19"/>
            </span>
          </div>
          <div class="form-group d-flex justify-content-between align-items-center">
            <div class="form-check">
              <input class="form-check-input check-input-secondary me-2" type="checkbox" id="remembermecheck">
              <label class="form-check-label text-capitalize align-middle pt-1" for="remembermecheck">{{ trans('modal.auth.remember_me') }}</label>
            </div>
            <div class="text-end">
              <a href="#" data-bs-toggle="modal" data-bs-target="#resendPasswordModal" class="text-capitalize lead-2 font-regularcustom">{{ trans('modal.button.forgot_password') }}?</a>
            </div>
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-custom-yellow fw-400 text-uppercase font-sebibold w-100 mt-0" id="sign-in-btn">{{ trans('modal.button.sign_in') }}</button>
          </div>
          <div class="form-group">
            <p class="singleline-text text-center text-custom-muted">
              {{ trans('modal.auth.or') }}
            </p>
          </div>
            <a class="btn btn-outline-secondary btn-default w-100 text-capitalize font-sebiregular" href="{{ url('google/auth') }}">
                <img src="{{ asset('images/google.svg') }}" alt="" height="19" width="19" class="svg">
                <span class="align-middle ms-3">{{ trans('modal.button.sign_in_google') }}</span>
            </a>
            <br />
            <br />
            <div class="form-group">
            <p class="mb-0 singleline-text text-center text-custom-muted">{{ trans('modal.auth.no_account') }}
              <a href="#" data-bs-toggle="modal" data-bs-target="#signUpModal" class="text-yellow-2">{{ trans('modal.button.sign_up') }}</a>
            </p>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
