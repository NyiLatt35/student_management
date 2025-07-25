@extends('main')
@section('title', 'Edit Teacher')
@section('content')
    <div class="container-fluid py-2">
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-11">
                <!-- Form Card -->
                <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                    <div class="card-body p-0">
                        <!-- Progress Header -->
                        <div class="bg-primary p-4">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h5 class="text-white mb-0 fw-semibold">
                                        <i class="fas fa-user-plus"></i>
                                        Update Teacher Information
                                    </h5>
                                    <small class="text-white-50">Fill in all required fields marked with *</small>
                                </div>
                            </div>
                        </div>

                        <!-- Form Content -->
                        <div class="py-2 px-3">
                            <form action="{{ route('admin.teacher.update', $teachers->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="role" value="teacher">

                                <!-- Personal Information Section -->
                                <div class="mb-4">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="bg-info rounded-circle p-2 me-3">
                                            <i class="fas fa-user text-white"></i>
                                        </div>
                                        <h6 class="mb-0 fw-bold text-dark">Personal Information</h6>
                                    </div>

                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <label for="teacher_name" class="form-label fw-medium text-dark">
                                                Full Name <span class="text-danger">*</span>
                                            </label>
                                            <input type="text" name="teacher_name" class="form-control form-control-lg"
                                                value="{{ old('teacher_name', $teachers->teacher_name) }}" required>
                                            @error('teacher_name')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="teacher_email" class="form-label fw-medium text-dark">
                                                Email <span class="text-danger">*</span>
                                            </label>
                                            <input type="email" name="teacher_email" class="form-control form-control-lg"
                                                value="{{ old('teacher_email', $teachers->teacher_email) }}" required>
                                            @error('teacher_email')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="teacher_phone" class="form-label fw-medium text-dark">
                                                Phone Number
                                            </label>
                                            <input type="tel" name="teacher_phone" class="form-control form-control-lg"
                                                value="{{ old('teacher_phone', $teachers->teacher_phone) }}">
                                            @error('teacher_phone')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="teacher_address" class="form-label fw-medium text-dark">
                                                Address
                                            </label>
                                            <input type="text" name="teacher_address" class="form-control form-control-lg"
                                                value="{{ old('teacher_address', $teachers->teacher_address) }}">
                                            @error('teacher_address')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Academic Information Section -->
                                <div class="mb-4">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="bg-success rounded-circle p-2 me-3">
                                            <i class="fas fa-graduation-cap text-white"></i>
                                        </div>
                                        <h6 class="mb-0 fw-bold text-dark">Academic Information</h6>
                                    </div>

                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <label for="subject_name" class="form-label fw-medium text-dark">
                                                Subject <span class="text-danger">*</span>
                                            </label>
                                            <select name="teacher_subject" class="form-select form-select-lg" required>
                                                <option value="">Choose a subject</option>
                                                @foreach ($subjects as $subject)
                                                    <option value="{{ $subject->id }}"
                                                        {{ old('teacher_subject', $teachers->teacher_subject) == $subject->id ? 'selected' : '' }}>
                                                        {{ $subject->sub_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('teacher_subject')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="grade_name" class="form-label fw-medium text-dark">
                                                Grade <span class="text-danger">*</span>
                                            </label>
                                            <select name="grade" class="form-select form-select-lg" required>
                                                <option value="">Select grade level</option>
                                                @foreach ($grades as $grade)
                                                    <option value="{{ $grade->gradeId }}"
                                                        {{ old('grade', $teachers->grade) == $grade->gradeId ? 'selected' : '' }}>
                                                        {{ $grade->gradeName }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('grade')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Security Section -->
                                <div class="mb-4">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="bg-warning rounded-circle p-2 me-3">
                                            <i class="fas fa-shield-alt text-white"></i>
                                        </div>
                                        <h6 class="mb-0 fw-bold text-dark">Security (Optional)</h6>
                                    </div>

                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <label for="password" class="form-label fw-medium text-dark">
                                                New Password
                                            </label>
                                            <div class="input-group">
                                                <input type="password" name="teacher_password" id="password"
                                                    class="form-control form-control-lg">
                                                <button class="btn btn-outline-secondary" type="button"
                                                    id="togglePassword">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                            <div class="form-text">
                                                <small class="text-muted">Leave blank to keep current password. Must be at least 8 characters if changing.</small>
                                            </div>
                                            @error('teacher_password')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label for="teacher_password_confirmation"
                                                class="form-label fw-medium text-dark">
                                                Confirm New Password
                                            </label>
                                            <input type="password" name="teacher_password_confirmation"
                                                class="form-control form-control-lg" placeholder="Re-enter new password">
                                            @error('teacher_password_confirmation')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="border-top pt-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <a href="{{ route('admin.teacher.index') }}" class="btn btn-light btn-lg px-4">
                                            <i class="fas fa-arrow-left me-2"></i>Back to List
                                        </a>
                                        <div class="d-flex gap-3">
                                            <button type="reset" class="btn btn-outline-secondary btn-lg px-4">
                                                <i class="fas fa-undo me-2"></i>Reset Changes
                                            </button>
                                            <button type="submit" class="btn btn-success btn-lg px-4">
                                                <i class="fas fa-save me-2"></i>Update Teacher
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add JavaScript for password toggle -->
    <script>
        document.getElementById('togglePassword').addEventListener('click', function() {
            const passwordField = document.getElementById('password');
            const icon = this.querySelector('i');

            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    </script>
@endsection
