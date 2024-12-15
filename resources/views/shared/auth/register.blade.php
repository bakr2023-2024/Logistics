@extends('layouts.layout')
@section('title', __('register.title'))

@section('content')
    <div class="container d-flex justify-content-center mt-5">
        <div class="card p-4 shadow" style="max-width: 500px; width: 100%;">
            <!-- Dynamically set the heading based on the route -->

            <h1 class="text-center mb-4 text-primary">
                {{ __('register.heading', ['type' => Route::is('admin.register') ? 'Admin' : 'Customer']) }}</h1>

            <!-- Dynamically set the form action based on the route -->
            <form method="post" action="{{ Route::is('admin.register') ? route('admin.register') : route('register') }}">
                @csrf

                <!-- Name -->
                <div class="mb-3">
                    <label for="name" class="form-label">{{ __('register.name_label') }}</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                        name="name" placeholder="{{ __('register.name_placeholder') }}" value="{{ old('name') }}">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label">{{ __('register.email_label') }}</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                        name="email" placeholder="{{ __('register.email_placeholder') }}" value="{{ old('email') }}">
                    <small class="form-text text-muted">{{ __('register.email_hint') }}</small>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <!-- Address -->
                @if (Route::is('register'))
                    <div class="mb-3">
                        <label for="address" class="form-label">{{ __('register.address_label') }}</label>
                        <input type="text" class="form-control @error('address') is-invalid @enderror" id="address"
                            name="address" placeholder="{{ __('register.address_placeholder') }}"
                            value="{{ old('address') }}">
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                @endif
                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label">{{ __('register.password_label') }}</label>
                    <div class="input-group">
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                            name="password" placeholder="{{ __('register.password_placeholder') }}">
                        <button class="btn btn-primary" type="button" onclick="togglePassword(event)">
                            <i class="bi bi-eye-slash"></i>
                        </button>
                    </div>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="mb-3">
                    <label for="password_confirmation"
                        class="form-label">{{ __('register.confirm_password_label') }}</label>
                    <div class="input-group">
                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                            id="password_confirmation" name="password_confirmation"
                            placeholder="{{ __('register.confirm_password_placeholder') }}">
                        <button class="btn btn-primary" type="button" onclick="togglePassword(event)">
                            <i class="bi bi-eye-slash"></i>
                        </button>
                    </div>
                    @error('password_confirmation')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>


                <!-- Submit Button -->
                <div class="text-center">
                    <button type="submit" class="btn btn-primary w-100">{{ __('register.submit_button') }}</button>
                </div>
            </form>

            <!-- Login Link -->
            <div class="text-center mt-3">
                <a href="{{ Route::is('admin.login') ? route('admin.login') : route('login') }}"
                    class="text-decoration-none">{{ __('register.login_link') }}</a>
            </div>
        </div>
    </div>
@endsection
