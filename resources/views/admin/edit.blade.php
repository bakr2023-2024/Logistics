@extends('layouts.layout')

@section('content')
    <div class="container">
        <h1 class="my-4">Edit Admin</h1>
        <form method="POST" action="{{ route('admin.admins.update', $admin->id) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $admin->name) }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $admin->email) }}" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label">{{ __('reset_password.password_label') }} (optional)</label>
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

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
        <div class="text-center mt-4">
            <a href="{{ route(Auth::guard('admin')->check() ? 'admin.admins.show' : 'admins.show',$admin->id) }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Back to Admin
            </a>
            <a href="{{ route(Auth::guard('admin')->check() ? 'admin.admins.index' : 'admins.index') }}" class="btn btn-secondary">
                <i class="bi bi-list"></i> Back to List
            </a>
        </div>
    </div>
@endsection
