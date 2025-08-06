@extends('main')
@section('title', 'View Exam Result')
@section('content')
    <div class="container mt-5">
        <div class="card shadow-lg rounded-4 border-0">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center rounded-top">
                <h5 class="mb-0">
                    <i class="fas fa-eye me-2"></i>Exam Result Details
                </h5>
                <a href="{{ route('exam.result') }}" class="btn btn-light btn-sm">
                    <i class="fas fa-arrow-left me-1"></i>Back
                </a>
            </div>

            <div class="card-body p-4">
                {{-- Student Info --}}
                <div class="mb-4">
                    <h6 class="text-muted text-uppercase mb-2">Student Information</h6>
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-light d-flex justify-content-center align-items-center me-3"
                            style="width: 60px; height: 60px;">
                            <i class="fas fa-user-graduate fa-2x text-primary"></i>
                        </div>
                        <div>
                            <h5 class="mb-1">{{ $result->student->studentName ?? 'N/A' }}</h5>
                            <p class="mb-0 text-secondary">Grade: {{ $result->exam->grade->gradeName ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>

                <hr>

                {{-- Exam Info --}}
                <div class="mb-4">
                    <h6 class="text-muted text-uppercase mb-2">Exam Information</h6>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item px-0 d-flex justify-content-between">
                            <span>Exam Name:</span>
                            <span class="fw-semibold">{{ $result->exam->exam_name ?? 'N/A' }}</span>
                        </li>
                        <li class="list-group-item px-0 d-flex justify-content-between">
                            <span>Subject:</span>
                            <span class="fw-semibold">{{ $result->exam->subject->sub_name ?? 'N/A' }}</span>
                        </li>
                        <li class="list-group-item px-0 d-flex justify-content-between">
                            <span>Total Marks:</span>
                            <span class="fw-semibold">{{ $result->total_marks ?? 100 }}</span>
                        </li>
                        <li class="list-group-item px-0 d-flex justify-content-between">
                            <span>Passing Marks:</span>
                            <span class="fw-semibold">{{ $result->exam->passing_marks ?? 40 }}</span>
                        </li>
                    </ul>
                </div>

                <hr>

                {{-- Result Info --}}
                <div class="mb-4">
                    <h6 class="text-muted text-uppercase mb-2">Result</h6>
                    <div class="d-flex align-items-center">
                        <span class="fs-3 fw-bold me-3 {{ $result->status === 'pass' ? 'text-success' : 'text-danger' }}">
                            {{ ucfirst($result->status) }}
                        </span>
                        <span class="badge bg-dark px-3 py-2">
                            Marks Obtained: {{ $result->marks_obtained ?? 0 }} / {{ $result->total_marks ?? 100 }}
                        </span>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="text-end d-flex justify-content-end gap-2">
                    {{-- Edit Button --}}
                    <a href="{{ route('exam.result.edit', $result->id) }}" class="btn btn-sm btn-warning d-flex align-items-center">
                        <i class="fas fa-edit me-1"></i> Edit
                    </a>

                    {{-- Delete Button --}}
                    <button type="button" class="btn btn-sm btn-danger d-flex align-items-center"
                            onclick="confirmDelete('{{ $result->id }}')"
                            data-bs-toggle="tooltip" title="Delete result">
                        <i class="fas fa-trash me-1"></i> Delete
                    </button>

                    {{-- Hidden Delete Form --}}
                    <form id="deleteForm{{ $result->id }}"
                          action="{{ route('exam.result.destroy', $result->id) }}"
                          method="POST" class="d-none">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection
