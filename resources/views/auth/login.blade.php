@extends('main')
@section('content')
<div class="vh-100 d-flex justify-content-center align-items-center" style="background-color: #e9ecef;">
    <div class="card shadow-sm" style="width: 24rem; border-radius: 0.5rem;">
        <div class="card-body p-4">
            <!-- Logo -->
            <div class="text-center mb-3">
                <i class="fas fa-graduation-cap fa-2x text-primary"></i>
                <h4 class="mb-2 text-primary">SMS Education</h4>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <!-- Email -->
                <div class="form-group mb-3">
                    <input type="email" id="email" name="email"
                        class="form-control @error('email') is-invalid @enderror"
                        value="{{ old('email') }}" required placeholder="Email">
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="form-group mb-3">
                    <input type="password" id="password" name="password"
                        class="form-control @error('password') is-invalid @enderror"
                        required placeholder="Password">
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="remember"
                        id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">Remember me</label>
                </div>

                <!-- Login Button -->
                <button class="btn btn-primary btn-block w-100 mb-3" type="submit">
                    Sign in
                </button>

                <!-- Forgot Password -->
                @if (Route::has('password.request'))
                    <div class="text-center mb-2">
                        <a href="{{ route('password.request') }}" class="text-primary">Forgot password?</a>
                    </div>
                @endif

                <!-- Register Link -->
                <div class="text-center">
                    <p class="mb-0">Don't have an account?
                        <a href="{{ route('register') }}" class="text-primary fw-bold">Register</a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection