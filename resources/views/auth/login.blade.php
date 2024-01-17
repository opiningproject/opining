@extends('layouts.app')

@section('content')
<div class="main" style="min-height: 100vh;">
    <div class="main-view signin-view">
        <div class="container-fluid bd-gutter bd-layout signin-layout py-3">
            <main class="w-100">
                <div class="main-content">
                    <div class="card signin-card">
                        <div class="card-header">
                            <h1 class="logo-text text-dark-1">
                                <a href="javascript:void(0);">
                                    <div class="d-flex">
                                        <img src="{{ getRestaurantDetail()->restaurant_logo }}" style="max-width: 100%;">
                                    </div>
                                </a>
                            </h1>
                        </div>
                        <div class="card-body signin-form">
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="mb-3">
                                    <div
                                        class="form-group prev-input-group mb-0 @error('email') is-invalid @enderror">
                                    <span class="input-group-icon">
                                        <img src="{{ asset('images/mail-icon2.svg') }}" class="svg" width="18" height="12">

                                    </span>
                                        <input type="text" class="form-control" autocomplete="off" name="email" placeholder="Email" value="{{ old('email') }}">
                                    </div>
                                    @error('email')
                                    <div class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <div class="form-group mb-0 prev-input-group @error('password') is-invalid @enderror">
                                    <span class="input-group-icon">
                                        <img src="{{ asset('images/Password-icon.svg') }}" class="svg" width="15" height="20">
                                    </span>

                                        <input type="password"
                                               class="form-control"
                                               name="password"
                                               placeholder="Password"
                                               id="password"  value="{{ old('password') }}" autocomplete="off">
                                        <span class="input-group-icon passwordeye-icon view-pwd-icon">
                                            <img src="{{ asset('images/passwordeye-icon.svg') }}" class="svg" width="21" height="19">
                                        </span>

                                    </div>
                                    @error('password')
                                    <div class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                    @enderror
                                </div>
                                <div class="input-group justify-content-end text-end">
                                    @if (Route::has('password.request'))
                                        <a href="#" data-bs-toggle="modal"
                                           data-bs-target="#resendPasswordModal"
                                           class="text-capitalize lead-2 font-regularcustom">{{ __('Forgot Your Password?') }}</a>
                                    @endif
                                </div>

                                <button type="submit"
                                        class="btn btn-custom-yellow fw-400 text-uppercase font-sebibold w-100 signin-btn">
                                    {{ __('Login') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <div class="modal fade loginscreen-modal custom-modal" id="resendPasswordModal" tabindex="-1"
         aria-labelledby="resendPasswordModal" aria-hidden="true">
        <div class="modal-dialog custom-w-441px resendpwdmodal">
            <div class="modal-content">
                <div class="modal-header border-0 justify-content-center">
                    <img src="{{ getRestaurantDetail()->restaurant_logo }}" style="max-width: 100%;">
                </div>
                <div class="modal-body signin-form">
                    <form method="POST" id="reset-pwd-form" action="javascript:void(0)">
                        @csrf
                        <h3 class="authenticationform-title">{{ __('Reset Password') }}</h3>
                        <div class="form-group prev-input-group mb-0">
                        <span class="input-group-icon">
                            <img src="{{ asset('images/mail-icon2.svg') }}" class="svg" width="18" height="12">

                        </span>
                            <input type="text" name="forgot-pwd-email" id="forgot-pwd-email"
                                   class="form-control" placeholder="Email"
                                   value="" autocomplete="email" autofocus>
                        </div>

                        <span class="invalid-feedback" role="alert" style="display:block">
                            <strong id="forgot-pwd-error-msg"></strong>
                        </span>

                        <span class="invalid-feedback" role="alert" style="display:block; color: #0f5132">
                            <strong id="forgot-pwd-success-msg"></strong>
                        </span>

                        <button type="submit" id="forgot-pwd--submit-btn"
                                class="btn btn-custom-yellow fw-400 text-uppercase font-sebibold w-100 mt-30px">{{ __('Send Password Reset Link') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script type="text/javascript">
        $(function () {
            $(document).on('click', '#forgot-pwd--submit-btn', function () {
                var email = $('#forgot-pwd-email').val()
                $.ajax({
                    url: '{{ route('password.email') }}',
                    type: 'post',
                    data: {
                        email
                    },
                    success: function (response) {
                        $('#forgot-pwd-email').removeClass('is-invalid')
                        $('#forgot-pwd-error-msg').text('')
                        $('#forgot-pwd-success-msg').text(response.message)
                    },
                    error: function (response) {
                        var errorMessage = JSON.parse(response.responseText).message
                        $('#forgot-pwd-error-msg').text(errorMessage)
                        $('#forgot-pwd-email').addClass('is-invalid').val(email)
                    }
                })
            })

            $(document).on('click', '.view-pwd-icon', function () {
                if ($('#password').attr('type') == 'text') {
                    $('#password').attr('type', 'password')
                } else {
                    $('#password').attr('type', 'text')
                }
            })

            $('#resendPasswordModal').on('hidden.bs.modal', function () {
                var alertas = $('#reset-pwd-form');
                alertas.trigger("reset");
                $('#forgot-pwd-error-msg').text('')
                $('#forgot-pwd-success-msg').text('')
                $('#forgot-pwd-email').removeClass('is-invalid')
            });
        })
    </script>
@endsection
