<div class="modal fade custom-modal" id="signUpModal" tabindex="-1" aria-labelledby="signUpModal" aria-hidden="true">
  <div class="modal-dialog custom-w-441px modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header border-0 justify-content-center">
        <h1 class="logo-text text-dark-1 mb-0">
          <img src="{{ getRestaurantDetail()->restaurant_logo }}" class="web-logo">
        </h1>
      </div>
      <div class="modal-body signin-form">
        <form id="sign-up-form" method="POST">
          <div class="form-group prev-input-group custom-icon-input-group">
            <span class="input-group-icon">
              <img src="{{ asset('images/user-icon.svg') }}" alt="" width="16" height="16" class="svg">
            </span>
            <input type="text" class="form-control form-control-icon ps-5" placeholder="{{ trans('modal.auth.first_name') }}" maxlength="25" name="first_name" id="first_name" required>
          </div>
          <div class="form-group prev-input-group custom-icon-input-group">
            <span class="input-group-icon">
              <img src="{{ asset('images/user-icon.svg') }}" alt="" width="16" height="16" class="svg">
            </span>
            <input type="text" class="form-control form-control-icon ps-5" placeholder="{{ trans('modal.auth.last_name') }}" name="last_name" id="last_name" maxlength="25" required>
          </div>
          <div class="form-group prev-input-group custom-icon-input-group">
            <span class="input-group-icon">
              <img src="{{ asset('images/mail-icon2-up.svg') }}" alt="" width="18" height="12" class="svg">
            </span>
            <input type="email" class="form-control custom-control-with-icon ps-5" placeholder="{{ trans('modal.auth.email') }}" name="email" id="email" required>
            <label id="email-error" class="error" for="email" style="display: none"></label>
          </div>
          <div class="form-group prev-input-group custom-icon-input-group password-input-icon mb-3">
            <span class="input-group-icon">
              <img src="{{ asset('images/password.svg') }}" alt="" width="15" height="20" class="svg">
            </span>
            <input type="password" class="form-control login-pwd-icon custom-control-with-icon ps-5 pe-5" placeholder="{{ trans('modal.auth.password') }}" id="password" name="password" minlength="8" required>
            <span class="input-group-icon passwordeye-icon login-signup-pwd-icon">
              <img src="{{ asset('images/passwordeye-open.svg') }}" id="toggleSignInPassword" class="svg hide-password"  width="21" height="19">
              <img src="{{ asset('images/passwordeye-icon.svg') }}" id="toggleSignInPassword" class="svg d-none show-password"  width="21" height="19">
            </span>
          </div>
          <div class="form-group prev-input-group custom-icon-input-group password-input-icon mb-3">
            <span class="input-group-icon">
              <img src="{{ asset('images/password.svg') }}" alt="" width="15" height="20" class="svg">
            </span>
            <input type="password" class="form-control custom-control-with-icon ps-5" placeholder="{{ trans('modal.auth.c_password') }}" id="c_password" name="c_password" required>
          </div>
          <div class="form-group">
            <button type="submit" class="btn btn-custom-yellow fw-400 text-uppercase font-sebibold w-100 mt-0" id="sign-up-btn">{{ trans('modal.button.sign_up') }}</button>
          </div>
          <div class="form-group">
            <p class="mb-0 singleline-text text-center text-custom-muted text-capitalize">{{ trans('modal.auth.account_exist') }}? 
              <a href="#" class="text-yellow-2" data-bs-toggle="modal" data-bs-target="#signInModal">{{ trans('modal.button.sign_in') }}</a>
              <br />
              <br /> {{ trans('modal.auth.or') }}
            </p>
          </div>
          <a class="btn btn-outline-secondary btn-default w-100 text-capitalize font-sebiregular" href="{{ url('google/auth') }}">
            <img src="{{ asset('images/google.svg') }}" alt="" height="19" width="19" class="svg">
            <span class="align-middle ms-3">{{ trans('modal.button.sign_in_google') }}</span>
          </a>
        </form>
      </div>
    </div>
  </div>
</div>