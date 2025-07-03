@extends('main')
@section('content')
<div class="vh-100">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 col-md-8 col-lg-6">
                <div class="card bg-white shadow-lg" style="border-radius: 1rem;">
                    <div class="card-body p-5">
                        <!-- Logo -->
                        <div class="text-center mb-4">
                            <i class="fas fa-graduation-cap fa-3x text-primary"></i>
                            <h3 class="mb-3 text-primary">Create Account</h3>
                        </div>

                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <!-- Name -->
                            <div class="form-floating mb-4">
                                <input id="name" type="text"
                                    class="form-control form-control-lg bg-light @error('name') is-invalid @enderror"
                                    name="name" value="{{ old('name') }}"
                                    required autocomplete="name" autofocus placeholder="Your name">
                                <label for="name">Full Name</label>
                                @error('name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="form-floating mb-4">
                                <input id="email" type="email"
                                    class="form-control form-control-lg bg-light @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}"
                                    required autocomplete="email" placeholder="name@example.com">
                                <label for="email">Email Address</label>
                                @error('email')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="form-floating mb-4">
                                <input id="password" type="password"
                                    class="form-control form-control-lg bg-light @error('password') is-invalid @enderror"
                                    name="password" required autocomplete="new-password"
                                    placeholder="Password">
                                <label for="password">Password</label>
                                @error('password')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="form-floating mb-4">
                                <input id="password-confirm" type="password"
                                    class="form-control form-control-lg bg-light"
                                    name="password_confirmation" required autocomplete="new-password"
                                    placeholder="Confirm Password">
                                <label for="password-confirm">Confirm Password</label>
                            </div>

                            <!-- Register Button -->
                            <button type="submit" class="btn btn-primary btn-lg w-100 mb-4"
                                style="background: linear-gradient(45deg, #4158d0, #c850c0); border: none;">
                                Register
                            </button>

                            <!-- Login Link -->
                            <div class="text-center">
                                <p class="mb-0">Already have an account?
                                    <a href="{{ route('login') }}" class="text-primary fw-bold">Login</a>
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