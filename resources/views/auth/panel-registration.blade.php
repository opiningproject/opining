@extends('layouts.app')

@section('content')
<div class="main" style="min-height: 100vh;">
    <div class="main-view signin-view">
        <div class="container-fluid bd-gutter bd-layout signin-layout py-3">
            <main class="w-100">
                <div class="main-content">
                    <div class="card signin-card">
                        <div class="card-header">
                            <div class="logo-text text-dark-1 mb-0">
                                <a href="javascript:void(0);">
                                    <div>
                                        <img src="{{ asset('images/logo-admin.png') }}" class="web-logo">
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="card-body signin-form">
                            <form method="POST" action="{{ route('storePanelRegistration') }}">
                                @csrf           
                                <div class="row mb-3">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Name">
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="row mb-3">
                                    <input id="email" type="email" class="form-control @error('user_email') is-invalid @enderror" name="user_email" value="{{ old('user_email') }}" required autocomplete="email" placeholder="Email">
                                    @error('user_email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                
                                <div class="row mb-3">
                                    <input id="restaurant_name" type="text" class="form-control @error('restaurant_name') is-invalid @enderror" name="restaurant_name" value="{{ old('restaurant_name') }}" required autocomplete="off" placeholder="Restaurant Name">
                                    @error('restaurant_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="row mb-3">
                                    <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Password">
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>

                                <div class="row mb-3">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password">
                                </div>
                                <button type="submit" class="btn btn-site-theme fw-400 text-uppercase font-sebibold w-100 signin-btn">Register</button>
                            </form>

                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

</div>
@endsection

@section('script')

@endsection