{{-- @extends('main')
@section('title', 'Student Details')
@section('content')
<div class="container py-4">
    <div class="d-flex align-items-center mb-4">
        <div class="bg-primary bg-opacity-10 p-3 rounded-circle me-3">
            <i class="fas fa-user-graduate text-primary fa-2x"></i>
        </div>
        <h2 class="mb-0 fw-bold">Student Details</h2>
    </div>

    <div class="card border-0 shadow-lg" style="border-radius: 15px; background: linear-gradient(to right bottom, #ffffff, #f8f9fa);">
        <div class="card-body p-4">

            <div class="container-fluid p-0">
                <!-- Details Grid -->
                <div class="row g-4">
                    <!-- Student ID -->
                    <div class="col-md-6">
                        <div class="p-3 rounded-3 hover-card bg-white border">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <span class="icon-circle bg-primary bg-opacity-10 text-primary me-3">
                                        <i class="fas fa-id-card"></i>
                                    </span>
                                    <div>
                                        <div class="text-muted small">Student ID</div>
                                        <div class="fw-bold">{{ $details->studentId }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Name -->
                    <div class="col-md-6">
                        <div class="p-3 rounded-3 hover-card bg-white border">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <span class="icon-circle bg-primary bg-opacity-10 text-primary me-3">
                                        <i class="fas fa-user"></i>
                                    </span>
                                    <div>
                                        <div class="text-muted small">Student Name</div>
                                        <div class="fw-bold">{{ $details->studentName }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Grade -->
                    <div class="col-md-6">
                        <div class="p-3 rounded-3 hover-card bg-white border">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <span class="icon-circle bg-primary bg-opacity-10 text-primary me-3">
                                        <i class="fas fa-graduation-cap"></i>
                                    </span>
                                    <div>
                                        <div class="text-muted small">Grade</div>
                                        <div class="fw-bold">Grade-{{ $details->gradeId }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="col-md-6">
                        <div class="p-3 rounded-3 hover-card bg-white border">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <span class="icon-circle bg-danger bg-opacity-10 text-danger me-3">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                    <div>
                                        <div class="text-muted small">Email</div>
                                        <div class="fw-bold">{{ $details->email }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Phone -->
                    <div class="col-md-6">
                        <div class="p-3 rounded-3 hover-card bg-white border">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <span class="icon-circle bg-warning bg-opacity-10 text-warning me-3">
                                        <i class="fas fa-phone"></i>
                                    </span>
                                    <div>
                                        <div class="text-muted small">Phone</div>
                                        <div class="fw-bold">{{ $details->phone }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Address -->
                    <div class="col-md-6">
                        <div class="p-3 rounded-3 hover-card bg-white border">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <span class="icon-circle bg-success bg-opacity-10 text-success me-3">
                                        <i class="fas fa-map-marker-alt"></i>
                                    </span>
                                    <div>
                                        <div class="text-muted small">Address</div>
                                        <div class="fw-bold">{{ $details->address }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Date of Birth -->
                    <div class="col-md-6">
                        <div class="p-3 rounded-3 hover-card bg-white border">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <span class="icon-circle bg-info bg-opacity-10 text-info me-3">
                                        <i class="fas fa-calendar-alt"></i>
                                    </span>
                                    <div>
                                        <div class="text-muted small">Date of Birth</div>
                                        <div class="fw-bold">{{ $details->dateOfBirth }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Back Button -->
                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('student.index') }}"
                       class="btn btn-light hover-lift px-4"
                       style="border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                        <i class="fas fa-arrow-left me-2"></i>Back to List
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection --}}


@extends('main')
@section('title', 'Student Profile - ' . $details->studentName)
@section('content')

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <!-- Header and Action Buttons -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="h4 mb-0">Student Profile</h2>
                <div>
                    <a href="{{ route('student.edit', $details->studentId) }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-edit me-1"></i> Edit
                    </a>
                    <a href="{{ route('student.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-arrow-left me-1"></i> Back to List
                    </a>
                </div>
            </div>

            <!-- Profile Summary Card -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        @if($details->photo)
                            <img src="{{ asset('storage/' . $details->photo) }}" alt="Photo of {{ $details->studentName }}"
                                 class="rounded-circle me-3" style="width: 80px; height: 80px; object-fit: cover;">
                        @else
                             <div class="d-flex justify-content-center align-items-center bg-light rounded-circle me-3"
                                 style="width: 80px; height: 80px;">
                                <i class="fas fa-user fa-2x text-secondary"></i>
                            </div>
                        @endif
                        <div>
                            <h4 class="card-title mb-0">{{ $details->studentName }}</h4>
                            <p class="text-muted mb-0">ID: {{ $details->studentId }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact & Personal Information Card -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0">Contact & Personal Information</h5>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span class="text-muted">Email Address</span>
                        <strong>{{ $details->email }}</strong>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span class="text-muted">Phone Number</span>
                        <strong>{{ $details->phone }}</strong>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span class="text-muted">Date of Birth</span>
                        <strong>{{ \Carbon\Carbon::parse($details->dateOfBirth)->format('F d, Y') }}</strong>
                    </li>
                     <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span class="text-muted">Gender</span>
                        <strong>{{ $details->gender }}</strong>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span class="text-muted">Address</span>
                        <strong class="text-end">{{ $details->address }}</strong>
                    </li>
                </ul>
            </div>

            <!-- Academic Information Card -->
            <div class="card shadow-sm border-0 mb-4">
                 <div class="card-header bg-white border-0">
                    <h5 class="mb-0">Academic Information</h5>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span class="text-muted">Grade</span>
                        <strong>Grade-{{ $details->grade->gradeName ?? $details->gradeId }}</strong>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span class="text-muted">Enrollment Date</span>
                        <strong>{{ \Carbon\Carbon::parse($details->enrollmentDate)->format('F d, Y') }}</strong>
                    </li>
                </ul>
            </div>

            <!-- Parent/Guardian Information Card -->
            <div class="card shadow-sm border-0 mb-4">
                 <div class="card-header bg-white border-0">
                    <h5 class="mb-0">Parent/Guardian Information</h5>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span class="text-muted">Name</span>
                        <strong>{{ $details->parentName }}</strong>
                    </li>
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span class="text-muted">Phone Number</span>
                        <strong>{{ $details->parentPhone }}</strong>
                    </li>
                </ul>
            </div>

            <!-- Delete Action -->
            <div class="text-center">
                 <form action="{{ route('student.destroy', $details->studentId) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this student? This action cannot be undone.');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-link text-danger">
                        <i class="fas fa-trash-alt me-1"></i>Delete Student Record
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection