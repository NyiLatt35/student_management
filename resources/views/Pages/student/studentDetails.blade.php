@extends('main')
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
                    <a href="{{ route('admin.student.index') }}"
                       class="btn btn-light hover-lift px-4"
                       style="border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                        <i class="fas fa-arrow-left me-2"></i>Back to List
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection