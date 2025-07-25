@extends('main')
@section('title', 'Exams')

@section('content')
<div class="container py-4">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-primary">
            <i class="fas fa-clipboard-list me-2"></i>Exams
        </h2>
        <button class="btn btn-primary rounded-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#examModal">
            <i class="fas fa-plus me-2"></i>New Exam
        </button>
    </div>

    <!-- Search Card -->
    <div class="card border-0 shadow-sm rounded-3 mb-4">
        <div class="card-body">
            <form action="" method="GET" class="row g-2">
                <div class="col-md-9">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="fas fa-search text-muted"></i>
                        </span>
                        <input type="text" name="query" id="query" class="form-control border-start-0"
                            placeholder="Search exams by name, grade, or subject..." value="{{ request('query') }}">
                    </div>
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-search me-1"></i> Search
                    </button>
                    <a href="{{ route('admin.exam.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-redo"></i>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Exams Table -->
    <div class="card border-0 shadow-sm rounded-3">
        @if ($exams->isEmpty())
            <div class="card-body text-center py-5">
                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                <p class="text-muted">No exams available yet.</p>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Exam Name</th>
                            <th>Grade</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Duration</th>
                            <th>Total Marks</th>
                            <th>Status</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($exams as $exam)
                        <tr>
                            <td class="fw-semibold text-primary">{{ $exam->exam_name }}</td>
                            <td>
                                @if ($exam->grade)
                                    <span class="badge bg-primary-subtle text-primary">{{ $exam->grade->gradeName }}</span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger">N/A</span>
                                @endif
                            </td>
                            <td>{{ $exam->exam_date->format('d M Y') }}</td>
                            <td>{{ $exam->exam_time->format('H:i') }}</td>
                            <td>{{ $exam->duration }} min</td>
                            <td>{{ $exam->total_marks }}</td>
                            <td>
                                <span class="badge {{ $exam->status === 'completed' ? 'bg-success' : ($exam->status === 'cancelled' ? 'bg-danger' : 'bg-warning text-dark') }}">
                                    {{ ucfirst($exam->status) }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('admin.exam.detail', $exam->id) }}" class="btn btn-sm btn-outline-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.exam.edit', $exam->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-outline-danger"
                                        onclick="confirmDelete('{{ $exam->id }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                                <form id="deleteForm{{ $exam->id }}" action="{{ route('admin.exam.destroy', $exam->id) }}" method="POST" class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if (isset($exams) && $exams->hasPages())
                    <div class="d-flex flex-column align-items-end gap-3 my-4">
                        <div class="text-muted small">
                            Showing {{ $exams->firstItem() }} to {{ $exams->lastItem() }} of
                            {{ $exams->total() }} entries
                        </div>
                        <nav aria-label="Page navigation">
                            <ul class="pagination pagination-sm m-0">
                                <li class="page-item {{ $exams->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link rounded-start-2" href="{{ $exams->previousPageUrl() }}"
                                        aria-label="Previous">
                                        <i class="fas fa-chevron-left"></i>
                                    </a>
                                </li>
                                @foreach ($exams->getUrlRange(1, $exams->lastPage()) as $page => $url)
                                    <li class="page-item {{ $page == $exams->currentPage() ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach
                                <li class="page-item {{ !$exams->hasMorePages() ? 'disabled' : '' }}">
                                    <a class="page-link rounded-end-2" href="{{ $exams->nextPageUrl() }}"
                                        aria-label="Next">
                                        <i class="fas fa-chevron-right"></i>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                @endif
        @endif
    </div>

</div>
@endsection
