@extends('layouts.app')

@section('content')
    <div class="main" style="min-height: 100vh;">
        <div class="main-view signin-view">
            <div class="container-fluid bd-gutter bd-layout signin-layout py-3">
                @if(Session::has('message'))
                    <p class="alert {{ Session::get('alert-class', 'alert-success') }}">{{ Session::get('status') }}</p>
                @endif
                <main class="w-100">
                    <div class="main-content">
                        <div class="card signin-card">
                            <div class="card-header pb-0">
                                <img src="{{ getRestaurantDetail()->restaurant_logo }}" class="web-logo">
                            </div>
                            <div class="card-body signin-form">
                                <form method="POST" action="{{ route('password.update') }}">
                                    @csrf
                                    <h3 class="authenticationform-title text-center">{{ __('Forgot Password') }}</h3>

                                    <input type="hidden" name="token" value="{{ $token }}">

                                    <input id="email" type="hidden"
                                           class="form-control text-indent-initial ps-5 is-invalid"
                                           name="email" value="{{ $email ?? old('email') }}" required
                                           autocomplete="email" autofocus>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <div class="form-group">
                                        <label for="newpassword" class="form-label">{{ __('New Password') }}</label>
                                        <input id="password" type="password"
                                               class="form-control text-indent-initial ps-5 @error('password') is-invalid @enderror"
                                               name="password"
                                               autocomplete="new-password" value="{{ old('password') }}">
                                        @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-0">
                                        <label for="newpassword"
                                               class="form-label">{{ __('Confirm New Password') }}</label>
                                        <input id="password-confirm" type="password" class="form-control text-indent-initial ps-5 @error('password_confirmation') is-invalid @enderror"
                                               name="password_confirmation" autocomplete="new-password" value="{{ old('password_confirmation') }}">
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
