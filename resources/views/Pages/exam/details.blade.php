@extends('main')
@section('title', 'Exam Details')
@section('content')

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">

            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold mb-0 text-primary">
                        <i class="fas fa-file-alt me-2"></i>{{ $exam->exam_name }}
                    </h2>
                    <small class="text-muted">
                        <i class="fas fa-book-open me-1"></i>Subject: {{ $exam->subject->sub_name ?? 'N/A' }}
                    </small>
                </div>
                <div>
                    <a href="{{ route('admin.exam.edit', $exam->id) }}" class="btn btn-sm btn-primary me-2">
                        <i class="fas fa-edit me-1"></i>Edit
                    </a>
                    <a href="{{ route('admin.exam.index') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i>Back
                    </a>
                </div>
            </div>

            <!-- Exam Info -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <h5 class="card-title text-secondary mb-3">
                        <i class="fas fa-info-circle me-2"></i>Exam Information
                    </h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <p class="mb-1">
                                <i class="fas fa-graduation-cap text-info me-2"></i>
                                <strong>Grade:</strong>
                                <span class="badge bg-info">{{ $exam->grade->gradeName ?? 'N/A' }}</span>
                            </p>
                            <p class="mb-1">
                                <i class="far fa-calendar-alt text-primary me-2"></i>
                                <strong>Date:</strong> {{ $exam->exam_date->format('d M Y') }}
                            </p>
                            <p class="mb-1">
                                <i class="far fa-clock text-warning me-2"></i>
                                <strong>Time:</strong> {{ $exam->exam_time->format('H:i') }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1">
                                <i class="fas fa-hourglass-half text-secondary me-2"></i>
                                <strong>Duration:</strong> {{ $exam->duration }} min
                            </p>
                            <p class="mb-1">
                                <i class="fas fa-chart-bar text-success me-2"></i>
                                <strong>Total Marks:</strong> {{ $exam->total_marks }}
                            </p>
                            <p class="mb-1">
                                <i class="fas fa-check-circle text-success me-2"></i>
                                <strong>Passing Marks:</strong> {{ $exam->passing_marks }}
                            </p>
                        </div>
                        <div class="col-12 mt-2">
                            <strong>Status:</strong>
                            <span class="badge px-3 py-2
                                {{ $exam->status === 'completed' ? 'bg-success' : ($exam->status === 'cancelled' ? 'bg-danger' : 'bg-warning text-dark') }}">
                                {{ ucfirst($exam->status) }}
                            </span>
                        </div>
                        <div class="col-12 mt-2">
                            <small class="text-muted">
                                <i class="far fa-clock me-1"></i>
                                Created: {{ $exam->created_at->format('M d, Y') }} |
                                Updated: {{ $exam->updated_at->format('M d, Y') }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection
