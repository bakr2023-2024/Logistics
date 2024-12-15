@extends('layouts.layout')
@section('title', __('login.title'))
@section('content')
    <div class="container d-flex justify-content-center mt-5">
        <div class="card p-4 shadow" style="max-width: 500px;">
            <!-- Dynamically set the heading based on the route -->

            <h1 class="text-center mb-4">{{ __('login.heading',['type'=>Route::is('admin.login')?'Admin':'Customer']) }}</h1>

            <!-- Dynamically set the form action based on the route -->

            <form method="post" action="{{ Route::is('admin.login') ? route('admin.login') : route('login') }}">
                @csrf
                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label">{{ __('login.email_label') }}</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                        name="email" placeholder="{{ __('login.email_placeholder') }}" value="{{ old('email') }}">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label">{{ __('login.password_label') }}</label>
                    <div class="input-group">
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                               id="password" name="password"
                               placeholder="{{ __('login.password_placeholder') }}"
                               autocomplete="off">
                               <button class="btn btn-primary" type="button" onclick="togglePassword(event)">
                                <i class="bi bi-eye-slash"></i>
                            </button>
                    </div>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Remember me -->
                <div class="mb-4 form-check">
                    <input type="checkbox" class="form-check-input" id="remember" name="remember">
                    <label class="form-check-label" for="remember">{{ __('login.remember_me') }}</label>
                </div>
                <!-- Submit button -->
                <div class="text-center">
                    <button type="submit" class="btn btn-primary w-100">{{ __('login.submit_button') }}</button>
                </div>
            </form>
            <!-- Forgot Password -->
            <div class="text-center mt-3">
                <a href="{{ Route::is('admin.login') ? route('admin.password.request') : route('password.request') }}"
                    class="text-decoration-none">{{ __('login.forgot_password') }}</a>
            </div>
            <!-- Register Link -->
            <div class="text-center mt-3">
                <a href="{{ Route::is('admin.login') ? route('admin.register') : route('register') }}"
                    class="text-decoration-none">{{ __('login.no_account') }}</a>
            </div>
        </div>
    </div>
@endsection
