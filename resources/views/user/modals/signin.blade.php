<div class="modal fade custom-modal" id="signInModal" tabindex="-1" aria-labelledby="signInModal" aria-hidden="true">
  <div class="modal-dialog custom-w-441px modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header border-0 justify-content-center">
        <h1 class="logo-text text-dark-1">
          <img src="{{ getRestaurantDetail()->restaurant_logo }}" class="web-logo">
        </h1>
      </div>
      <div class="modal-body signin-form">
        <form id="sign-in-form" method="POST">
          <div class="form-group prev-input-group custom-icon-input-group">
            <span class="input-group-icon">
              <img src="{{ asset('images/mail-icon2.svg') }}" alt="" width="18" height="12"  class="svg">
            </span>
            <input type="email" class="form-control custom-control-with-icon ps-5" placeholder="Email" name="email" id="email" required>
            <label id="email-error" class="error" for="email" style="display: none"></label>
          </div>
          <div class="form-group prev-input-group custom-icon-input-group password-input-icon mb-3">
            <span class="input-group-icon">
               <img src="{{ asset('images/password.svg') }}" alt="" width="15" height="20"  class="svg">
            </span>
            <input type="password" class="form-control login-pwd-icon custom-control-with-icon ps-5 pe-5" placeholder="Password" id="password" name="password" required>
            <label id="password-error" class="error" for="password" style="display: none"></label>
            <span class="input-group-icon passwordeye-icon login-signup-pwd-icon">
                 <img src="{{ asset('images/passwordeye-icon.svg') }}" id="toggleSignInPassword" class="svg" width="21" height="19" />
            </span>
          </div>
          <div class="form-group d-flex justify-content-between align-items-center">
            <div class="form-check">
              <input class="form-check-input check-input-secondary me-3" type="checkbox" id="remembermecheck">
              <label class="form-check-label text-capitalize align-middle" for="remembermecheck"> Remember Me </label>
            </div>
            <div class="text-end">
              <a href="#" data-bs-toggle="modal" data-bs-target="#resendPasswordModal" class="text-capitalize lead-2 font-regularcustom">forgot password</a>
            </div>
          </div>
          <div class="form-group">
            <!-- <a href="#" class="btn btn-custom-yellow fw-400 text-uppercase font-sebibold w-100">Sign In</a> -->
            <button type="submit" class="btn btn-custom-yellow fw-400 text-uppercase font-sebibold w-100 mt-30px" id="sign-in-btn">Sign In</button>
          </div>
          <div class="form-group">
            <p class="mb-0 singleline-text text-center text-custom-muted">Don’t you have an account? <a href="#" data-bs-toggle="modal" data-bs-target="#signUpModal" class="text-yellow-2">Sign Up</a>
              <br />
              <br /> Or
            </p>
          </div>
          <a class="btn btn-outline-secondary btn-default w-100 text-capitalize font-sebiregular font-18" href="{{ url('google/auth') }}">
            <img src="{{ asset('images/google.svg') }}" alt="" height="19" width="19" class="svg">
            <span class="align-middle ms-3">Sign in with Google</span>
          </a>
        </form>
      </div>
    </div>
  </div>
</div>
