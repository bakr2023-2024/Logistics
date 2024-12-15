@extends('layouts.layout')

@section('title', 'Edit Customer Profile')

@section('content')
<div class="container mt-4">
    <div class="card border-primary mx-auto" style="max-width: 800px;">
        <div class="card-header text-center">
            <h2>Edit Customer Profile: {{ $customer->name }}</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.customers.update', $customer->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ old('name', $customer->name) }}" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" value="{{ old('email', $customer->email) }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" id="address" value="{{ old('address', $customer->address) }}" required>
                    @error('address')
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
                <button type="submit" class="btn btn-primary mt-3 w-100">Update</button>
            </form>
            <div class="text-center mt-4">
                <a href="{{ route(Auth::guard('admin')->check() ? 'admin.customers.show' : 'customers.show',$customer->id) }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Back to Customer
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
