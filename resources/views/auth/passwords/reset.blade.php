@extends('layouts.app')

@section('content')
    <!--    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Reset Password') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf

    <input type="hidden" name="token" value="{{ $token }}">

                            <div class="row mb-3">
                                <label for="email"
                                       class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                           class="form-control @error('email') is-invalid @enderror" name="email"
                                           value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
    </div>
</div>

<div class="row mb-3">
    <label for="password"
           class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                           class="form-control @error('password') is-invalid @enderror" name="password"
                                           required autocomplete="new-password">

                                    @error('password')
    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
    </div>
</div>

<div class="row mb-3">
    <label for="password-confirm"
           class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control"
                                           name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Reset Password') }}
    </button>
</div>
</div>
</form>
</div>
</div>
</div>
</div>
</div>-->

    <div class="main">
        <div class="main-view signin-view">
            <div class="container-fluid bd-gutter bd-layout signin-layout">
                <main class="w-100">
                    <div class="main-content">
                        <div class="card signin-card">
                            <div class="card-header">
                                <h1 class="logo-text text-dark-1"><a href="javascript:void(0);">
                                        Gomeal<span class="text-yellow-1">.</span>
                                    </a></h1>
                            </div>
                            <div class="card-body signin-form">
                                <form method="POST" action="{{ route('password.update') }}">
                                    @csrf
                                    <input type="hidden" name="token" value="{{ $token }}">

                                    <input id="email" type="hidden"
                                           class="form-control @error('email') is-invalid @enderror"
                                           name="email" value="{{ $email ?? old('email') }}" required
                                           autocomplete="email" autofocus>

                                    <h3 class="authenticationform-title">{{ __('Forgot Password') }}</h3>
                                    <div class="form-group">
                                        <label for="newpassword" class="form-label">{{ __('New Password') }}</label>
                                        <input id="password" type="password"
                                               class="form-control @error('password') is-invalid @enderror"
                                               name="password"
                                               required autocomplete="new-password">
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-0">
                                        <label for="newpassword"
                                               class="form-label">{{ __('Confirm New Password') }}</label>
                                        <input id="password-confirm" type="password" class="form-control"
                                               name="password_confirmation" required autocomplete="new-password">
                                        @error('password_confirmation')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <button type="submit"
                                            class="btn btn-custom-yellow fw-400 text-uppercase font-sebibold w-100 mt-30px">
                                        Save
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>

        <!-- start footer -->
        <script src="{{ asset('js/footer.js')}}"></script>
        <!-- end footer -->
    </div>
@endsection
