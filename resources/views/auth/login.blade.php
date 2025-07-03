@extends('main')
@section('content')
<div class="vh-100">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                <div class="card bg-white shadow-lg" style="border-radius: 1rem;">
                    <div class="card-body p-5 text-center">
                        <!-- Logo -->
                        <div class="mb-4">
                            <i class="fas fa-graduation-cap fa-3x text-primary"></i>
                            <h3 class="mb-3 text-primary">SMS Education</h3>
                        </div>

                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <!-- Email -->
                            <div class="form-floating mb-4">
                                <input type="email" id="email" name="email"
                                    class="form-control form-control-lg bg-light @error('email') is-invalid @enderror"
                                    value="{{ old('email') }}" required placeholder="name@example.com">
                                <label for="email">Email address</label>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="form-floating mb-4">
                                <input type="password" id="password" name="password"
                                    class="form-control form-control-lg bg-light @error('password') is-invalid @enderror"
                                    required placeholder="Password">
                                <label for="password">Password</label>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Remember Me -->
                            <div class="d-flex justify-content-between mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember"
                                        id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="remember">Remember me</label>
                                </div>
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="text-primary">Forgot password?</a>
                                @endif
                            </div>

                            <!-- Login Button -->
                            <button class="btn btn-primary btn-lg w-100 mb-4" type="submit"
                                style="background: linear-gradient(45deg, #4158d0, #c850c0); border: none;">
                                Sign in
                            </button>

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
        </div>
    </div>
</div>
@endsection