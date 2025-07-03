@extends('main')
@section('title', 'Add Student')
@section('content')
    <div class="container py-4">
        <div class="row">
            <!-- Form Column -->
            <div class="col-md-6 mb-4">
                <div class="card border-0 shadow-lg" style="border-radius: 15px;">
                    <div class="card-header bg-primary bg-gradient text-white p-4" style="border-radius: 15px 15px 0 0;">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-user-plus fa-2x me-3"></i>
                            <h5 class="mb-0">Add New Student</h5>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        @if (session('error'))
                            <div class="alert alert-danger d-flex align-items-center">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                {{ session('error') }}
                            </div>
                        @endif
                        <form action="{{ route('admin.student.store') }}" method="POST" enctype="multipart/form-data"
                            autocomplete="false" novalidate="novalidate">
                            @csrf
                            <input type="text" name="studentId" value="" hidden>

                            <!-- Name Input -->
                            <div class="form-floating mb-4">
                                <input type="text" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}"
                                    id="name" name="name" value="{{ old('name') }}" placeholder="Enter name">
                                <label for="name">
                                    <i class="fas fa-user me-2"></i>Name
                                </label>
                                @if ($errors->has('name'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('name') }}
                                    </div>
                                @endif
                            </div>

                            <!-- Date of Birth Input -->
                            <div class="form-floating mb-4">
                                <input type="date" class="form-control @error('dob') is-invalid @enderror" id="dob"
                                    name="dob" value="{{ old('dob') }}" placeholder="Select date of birth">
                                <label for="dob"><i class="fas fa-calendar-alt me-2"></i>Date of Birth</label>
                                @error('dob')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Grade Select -->
                            <div class="form-floating mb-4">
                                <select class="form-select custom-select @error('grade') is-invalid @enderror"
                                    id="grade" name="grade">
                                    <option value="" disabled selected>Select Grade</option>
                                    @foreach ($grades as $grade)
                                        <option value="{{ $grade->gradeId }}"
                                            {{ old('grade') == $grade->gradeId ? 'selected' : '' }}>
                                            {{ $grade->gradeName }}
                                        </option>
                                    @endforeach
                                </select>
                                <label for="grade">
                                    <i class="fas fa-graduation-cap me-2"></i>Grade
                                </label>
                                @error('grade')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Phone Input -->
                            <div class="form-floating mb-4">
                                <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                    id="phone" name="phone" value="{{ old('phone') }}" placeholder="Enter phone">
                                <label for="phone"><i class="fas fa-phone me-2"></i>Phone</label>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email Input -->
                            <div class="form-floating mb-4">
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email') }}" placeholder="Enter email">
                                <label for="email"><i class="fas fa-envelope me-2"></i>Email</label>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Address Input -->
                            <div class="form-floating mb-4">
                                <input type="text" class="form-control @error('address') is-invalid @enderror"
                                    id="address" name="address" value="{{ old('address') }}" placeholder="Enter address">
                                <label for="address"><i class="fas fa-map-marker-alt me-2"></i>Address</label>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-primary btn-lg w-100 rounded-pill">
                                <i class="fas fa-save me-2"></i>Create Student
                            </button>
                        </form>
                    </div>
                </div>
            </div>


            <!-- Add this after the form card, in the second column -->
            @if (session('success') && session()->has('student'))
                @php
                    $student = session('student');
                @endphp
                @if ($student)
                    <div class="col-md-6">
                        <div class="card border-0 shadow-lg"
                            style="border-radius: 15px; background: linear-gradient(to right bottom, #ffffff, #f8f9fa);">
                            <div class="card-header bg-success bg-gradient text-white p-4"
                                style="border-radius: 15px 15px 0 0;">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-white bg-opacity-25 p-2 me-3">
                                        <i class="fas fa-check-circle fa-2x text-white"></i>
                                    </div>
                                    <h5 class="mb-0 fw-bold">Student Details</h5>
                                </div>
                            </div>
                            <div class="card-body p-4">
                                <div class="table-responsive">
                                    <table class="table table-borderless mb-0">
                                        <tbody>
                                            <tr class="border-bottom hover-row">
                                                <th class="text-muted py-3" style="width: 35%;">
                                                    <div class="d-flex align-items-center">
                                                        <span
                                                            class="icon-circle bg-primary bg-opacity-10 text-primary me-2">
                                                            <i class="fas fa-id-card"></i>
                                                        </span>
                                                        <span>Student ID</span>
                                                    </div>
                                                </th>
                                                <td class="text-end fw-bold text-primary py-3">{{ $student->studentId }}
                                                </td>
                                            </tr>
                                            <tr class="border-bottom hover-row">
                                                <th class="text-muted py-3">
                                                    <div class="d-flex align-items-center">
                                                        <span
                                                            class="icon-circle bg-success bg-opacity-10 text-success me-2">
                                                            <i class="fas fa-user"></i>
                                                        </span>
                                                        <span>Name</span>
                                                    </div>
                                                </th>
                                                <td class="text-end py-3">{{ $student->studentName }}</td>
                                            </tr>
                                            <tr class="border-bottom hover-row">
                                                <th class="text-muted py-3">
                                                    <div class="d-flex align-items-center">
                                                        <span class="icon-circle bg-info bg-opacity-10 text-info me-2">
                                                            <i class="fas fa-graduation-cap"></i>
                                                        </span>
                                                        <span>Grade</span>
                                                    </div>
                                                </th>
                                                <td class="text-end py-3">{{ $student->gradeId }}</td>
                                            </tr>
                                            <tr class="border-bottom hover-row">
                                                <th class="text-muted py-3">
                                                    <div class="d-flex align-items-center">
                                                        <span
                                                            class="icon-circle bg-warning bg-opacity-10 text-warning me-2">
                                                            <i class="fas fa-phone"></i>
                                                        </span>
                                                        <span>Phone</span>
                                                    </div>
                                                </th>
                                                <td class="text-end py-3">{{ $student->phone }}</td>
                                            </tr>
                                            <tr class="border-bottom hover-row">
                                                <th class="text-muted py-3">
                                                    <div class="d-flex align-items-center">
                                                        <span class="icon-circle bg-danger bg-opacity-10 text-danger me-2">
                                                            <i class="fas fa-envelope"></i>
                                                        </span>
                                                        <span>Email</span>
                                                    </div>
                                                </th>
                                                <td class="text-end py-3">{{ $student->email }}</td>
                                            </tr>
                                            <tr class="hover-row">
                                                <th class="text-muted py-3">
                                                    <div class="d-flex align-items-center">
                                                        <span
                                                            class="icon-circle bg-secondary bg-opacity-10 text-secondary me-2">
                                                            <i class="fas fa-map-marker-alt"></i>
                                                        </span>
                                                        <span>Address</span>
                                                    </div>
                                                </th>
                                                <td class="text-end py-3">{{ $student->address }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div class="d-flex justify-content-end gap-2 mt-4">
                                    <a href="{{ route('admin.student.index') }}" class="btn btn-light hover-lift">
                                        <i class="fas fa-list me-2"></i>Back to List
                                    </a>
                                    <a href="{{ route('admin.student.show', $student->studentId) }}" class="btn btn-primary hover-lift">
                                        <i class="fas fa-eye me-2"></i>View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </div>
@endsection
