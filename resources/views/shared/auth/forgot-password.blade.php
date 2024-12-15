@extends('layouts.layout')
@section('title', __('forgot_password.title'))
@section('content')
    <div class="container d-flex justify-content-center mt-5">
        <div class="card p-4 shadow" style="max-width: 500px;">
            <h1 class="text-center mb-4">{{ __('forgot_password.heading') }}</h1>
            <form method="post" action="{{ Route::is('admin.password.request') ? route('admin.password.email') : route('password.email') }}">
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">{{ __('forgot_password.email_label') }}</label>
                    <input
                        type="email"
                        class="form-control @error('email') is-invalid @enderror"
                        id="email"
                        name="email"
                        placeholder="{{ __('forgot_password.email_placeholder') }}"
                        value="{{ old('email') }}"
                    >
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary w-100">{{ __('forgot_password.submit_button') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection
