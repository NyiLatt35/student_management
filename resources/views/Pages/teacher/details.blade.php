@extends('main')
@section('title', 'Teacher Details')
@section('content')

    <div class="container-fluid py-4">
        <!-- Header Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="fw-bold text-dark mb-1">Teacher Information</h2>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            Actions
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('teacher.edit', $teacher->id) }}">
                                <i class="fas fa-pencil-square me-2"></i>Edit Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="#" onclick="confirmDelete('{{ $teacher->id }}')">
                                <i class="fas fa-trash me-2"></i>Delete</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Profile Section -->
        <div class="row g-4 mb-4">
            <!-- Profile Card -->
            <div class="col-lg-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center p-4">
                        <div class="mb-4">
                            <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center"
                                 style="width: 100px; height: 100px;">
                                <i class="fas fa-person text-primary" style="font-size: 3rem;"></i>
                            </div>
                        </div>
                        <h4 class="fw-bold mb-2">{{ $teacher->teacher_name }}</h4>
                        <p class="text-muted mb-3">{{ $teacher->subject->sub_name ?? 'Subject not assigned' }}</p>
                        <span class="badge bg-primary fs-6 px-3 py-2">{{ $teacher->teacher_id }}</span>
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-transparent border-0 pb-0">
                        <h5 class="fw-bold mb-0">Contact Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="border rounded p-3 h-100">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                                            <i class="fas fa-envelope text-primary"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted text-uppercase fw-semibold">Email Address</small>
                                            <div class="fw-medium">{{ $teacher->teacher_email }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="border rounded p-3 h-100">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="bg-success bg-opacity-10 rounded-circle p-2 me-3">
                                            <i class="fas fa-phone text-success"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted text-uppercase fw-semibold">Phone Number</small>
                                            <div class="fw-medium">{{ $teacher->teacher_phone ?? 'Not provided' }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="border rounded p-3 h-100">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="bg-warning bg-opacity-10 rounded-circle p-2 me-3">
                                            <i class="fas fa-book text-warning"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted text-uppercase fw-semibold">Teaching Subject</small>
                                            <div class="fw-medium">{{ $teacher->subject->sub_name ?? 'Not assigned' }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="border rounded p-3 h-100">
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="bg-info bg-opacity-10 rounded-circle p-2 me-3">
                                            <i class="fas fa-graduation-cap text-info"></i>
                                        </div>
                                        <div>
                                            <small class="text-muted text-uppercase fw-semibold">Grade</small>
                                            <div class="fw-medium">{{ $teacher->gradeLevel->gradeName ?? 'Not assigned' }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Information -->
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm text-center h-100">
                    <div class="card-body">
                        <div class="bg-secondary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                             style="width: 60px; height: 60px;">
                            <i class="fas fa-map-marker-alt text-secondary fs-4"></i>
                        </div>
                        <h6 class="fw-semibold mb-2">Address</h6>
                        <p class="text-muted mb-0 small">{{ $teacher->teacher_address ?? 'Not provided' }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm text-center h-100">
                    <div class="card-body">
                        <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                             style="width: 60px; height: 60px;">
                            <i class="fas fa-check-circle text-success fs-4"></i>
                        </div>
                        <h6 class="fw-semibold mb-2">Status</h6>
                        <span class="badge bg-success px-3 py-2">Active</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm text-center h-100">
                    <div class="card-body">
                        <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                             style="width: 60px; height: 60px;">
                            <i class="fas fa-clock text-primary fs-4"></i>
                        </div>
                        <h6 class="fw-semibold mb-2">Schedule</h6>
                        <p class="text-muted mb-0">Full Time</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="row">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex flex-wrap gap-2 justify-content-between align-items-center">
                            <h6 class="mb-0 fw-semibold">Quick Actions</h6>
                            <div class="btn-group" role="group">

                                <a href="{{ route('teacher.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-1"></i>Back to List
                                </a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Form -->
        <form id="deleteForm{{ $teacher->id }}" action="{{ route('teacher.destroy', $teacher->id) }}" method="POST" class="d-none">
            @csrf
            @method('DELETE')
        </form>
    </div>

@endsection
