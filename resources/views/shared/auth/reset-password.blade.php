@extends('layouts.layout')
@section('title', __('reset_password.title'))
@section('content')
    <div class="container d-flex justify-content-center mt-5">
        <div class="card p-4 shadow" style="max-width: 500px;">
            <h1 class="text-center mb-4">{{ __('reset_password.heading') }}</h1>
            <form method="post"
                action="{{ Route::is('admin.password.reset') ? route('admin.password.update') : route('password.update') }}">
                @csrf
                <input value="{{ $token }}" type="hidden" name="token" />
                <div class="mb-3">
                    <label for="email" class="form-label">{{ __('reset_password.email_label') }}</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                        name="email" placeholder="{{ __('reset_password.email_placeholder') }}"
                        value="{{ old('email') }}">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label">{{ __('reset_password.password_label') }}</label>
                    <div class="input-group">
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                            name="password" placeholder="{{ __('reset_password.password_placeholder') }}">
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
                        class="form-label">{{ __('reset_password.confirm_password_label') }}</label>
                    <div class="input-group">
                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                            id="password_confirmation" name="password_confirmation"
                            placeholder="{{ __('reset_password.confirm_password_placeholder') }}">
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
                    <button type="submit" class="btn btn-primary w-100">{{ __('reset_password.submit_button') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection
