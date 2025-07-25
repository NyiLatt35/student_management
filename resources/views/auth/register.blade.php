@extends('main')
@section('content')
<div class="vh-100 d-flex justify-content-center align-items-center bg-light">
    <div class="card shadow-sm" style="width: 28rem; border-radius: 0.5rem;">
        <div class="card-body p-4">
            <!-- Logo -->
            <div class="text-center mb-3">
                <i class="fas fa-graduation-cap fa-2x text-primary"></i>
                <h3 class="text-primary fw-semibold">SMS Education</h3>
                <h4 class="mt-2 text-muted">Sign Up</h4>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div class="mb-3">
                    <label for="name" class="form-label">Full Name</label>
                    <input id="name" type="text"
                        class="form-control @error('name') is-invalid @enderror"
                        name="name" value="{{ old('name') }}"
                        required autocomplete="name" autofocus>
                    @error('name')
                        <div class="invalid-feedback text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input id="email" type="email"
                        class="form-control @error('email') is-invalid @enderror"
                        name="email" value="{{ old('email') }}"
                        required autocomplete="email">
                    @error('email')
                        <div class="invalid-feedback text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input id="password" type="password"
                        class="form-control @error('password') is-invalid @enderror"
                        name="password" required autocomplete="new-password">
                    @error('password')
                        <div class="invalid-feedback text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="mb-3">
                    <label for="password-confirm" class="form-label">Confirm Password</label>
                    <input id="password-confirm" type="password"
                        class="form-control"
                        name="password_confirmation" required autocomplete="new-password">
                </div>

                <!-- Register Button -->
                <button type="submit" class="btn btn-primary w-100">Register</button>

                <!-- Login Link -->
                <div class="text-center mt-3">
                    <small>Already have an account?
                        <a href="{{ route('login') }}" class="text-primary">Login</a>
                    </small>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection