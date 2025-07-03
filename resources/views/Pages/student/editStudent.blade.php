<!-- editStudent.blade.php -->
@extends('main')
@section('title', 'Edit Student')
@section('content')

    <style>
        .toast {
            background: white;
            border-radius: 10px;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        .alert-danger {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0.5rem 1rem rgba(220, 53, 69, 0.15);
        }
    </style>


    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card border-0 shadow-lg" style="border-radius: 15px;">
                    <div class="card-header bg-primary text-white p-4" style="border-radius: 15px 15px 0 0;">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-user-edit fa-2x me-3"></i>
                            <h5 class="mb-0">Edit Student</h5>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('admin.student.update', $editStudent->studentId) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Name Input -->
                            <div class="form-floating mb-4">
                                <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                    id="name" name="name" value="{{ old('name', $editStudent->studentName) }}"
                                    placeholder="Enter name">
                                <label for="name">
                                    <i class="fas fa-user me-2"></i>Name
                                </label>
                                @if ($errors->has('name'))
                                    <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                                @endif
                            </div>

                            <!-- Grade Select -->
                            <div class="form-floating mb-4">
                                <select class="form-select {{ $errors->has('grade') ? 'is-invalid' : '' }}" id="grade"
                                    name="grade">
                                    {{-- <option value="">Select Grade</option> --}}
                                    @foreach ($grades as $grade)
                                        <option value="{{ $grade->gradeId }}"
                                            {{ old('grade', $editStudent->gradeId) == $grade->gradeId ? 'selected' : '' }}>
                                            {{ $grade->gradeName }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="grade">
                                    <i class="fas fa-graduation-cap me-2"></i>Grade
                                </label>
                                @if ($errors->has('grade'))
                                    <div class="invalid-feedback">{{ $errors->first('grade') }}</div>
                                @endif
                            </div>

                            <!-- Phone Input -->
                            <div class="form-floating mb-4">
                                <input type="text" class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}"
                                    id="phone" name="phone" value="{{ old('phone', $editStudent->phone) }}"
                                    placeholder="Enter phone">
                                <label for="phone">
                                    <i class="fas fa-phone me-2"></i>Phone
                                </label>
                                @if ($errors->has('phone'))
                                    <div class="invalid-feedback">{{ $errors->first('phone') }}</div>
                                @endif
                            </div>

                            <!-- Email Input -->
                            <div class="form-floating mb-4">
                                <input type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}"
                                    id="email" name="email" value="{{ old('email', $editStudent->email) }}"
                                    placeholder="Enter email">
                                <label for="email">
                                    <i class="fas fa-envelope me-2"></i>Email
                                </label>
                                @if ($errors->has('email'))
                                    <div class="invalid-feedback">{{ $errors->first('email') }}</div>
                                @endif
                            </div>

                            <!-- Address Input -->
                            <div class="form-floating mb-4">
                                <input type="text"
                                    class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}" id="address"
                                    name="address" value="{{ old('address', $editStudent->address) }}"
                                    placeholder="Enter address">
                                <label for="address">
                                    <i class="fas fa-map-marker-alt me-2"></i>Address
                                </label>
                                @if ($errors->has('address'))
                                    <div class="invalid-feedback">{{ $errors->first('address') }}</div>
                                @endif
                            </div>

                            <!-- Date of Birth Input -->
                            <div class="form-floating mb-4">
                                <input type="date" class="form-control {{ $errors->has('dob') ? 'is-invalid' : '' }}"
                                    id="dob" name="dob" value="{{ old('dob', $editStudent->dateOfBirth) }}"
                                    placeholder="Select date of birth">
                                <label for="dob">
                                    <i class="fas fa-calendar-alt me-2"></i>Date of Birth
                                </label>
                                @if ($errors->has('dob'))
                                    <div class="invalid-feedback">{{ $errors->first('dob') }}</div>
                                @endif
                            </div>

                            <!-- Submit Button -->
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg rounded-pill">
                                    <i class="fas fa-save me-2"></i>Update Student
                                </button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (document.getElementById('successToast')) {
                var toast = new bootstrap.Toast(document.getElementById('successToast'), {
                    animation: true,
                    autohide: true,
                    delay: 3000
                });
                toast.show();
            }
        });
    </script>
@endsection
{{-- <!-- Add JavaScript -->
@push('scripts')

@endpush --}}
