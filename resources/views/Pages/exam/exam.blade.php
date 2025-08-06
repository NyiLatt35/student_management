@extends('main')
@section('title', 'Exams')

@section('content')
    <div class="container my-5">

        <div class="card shadow rounded-4 border-0 mb-4">
            <div class="card-body p-4">
                <form action="" method="GET" class="row g-3 align-items-end">
                    <div class="col-md-8">
                        <label for="query" class="form-label fw-semibold small text-muted">Search Exams</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" name="query" id="query" class="form-control border-start-0 ps-0"
                                placeholder="Search by exam name, grade or subject..." value="{{ request('query') }}">
                        </div>
                    </div>
                    <div class="col-md-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary px-4 py-2 rounded-3 shadow-sm">
                            <i class="fas fa-search me-2"></i>Search
                        </button>
                        <a href="{{ route('exam.index') }}"
                            class="btn btn-outline-secondary px-3 py-2 rounded-3 shadow-sm">
                            <i class="fas fa-redo"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>


        <div class="card shadow border-0 rounded-3">
            <div class="card-header bg-gradient d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-primary bg-opacity-10 p-3 rounded-circle">
                        <i class="fas fa-clipboard-list fa-lg text-primary"></i>
                    </div>
                    <h2 class="fw-bold mb-0">Exams List</h2>
                </div>

                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#examModal">
                    + New Exam
                </button>
            </div>
            @if ($exams->isEmpty())
                <div class="alert alert-info text-center">No exams available yet.</div>
            @else
                <div class="card-body m-2">
                    <div class="card shadow-sm rounded-4 border-0">
                        <div class="card-body p-0">
                            <table class="table table-hover table-borderless align-middle mb-0">
                                <thead class="bg-light table-primary text-secondary">
                                    <tr>
                                        <th class="px-4 py-3">Exam Name</th>
                                        <th class="py-3">Grade</th>
                                        <th class="py-3">Date</th>
                                        <th class="py-3">Time</th>
                                        <th class="py-3">Duration</th>
                                        <th class="py-3 text-center">Total Marks</th>
                                        <th class="py-3">Status</th>
                                        <th class="py-3 text-center">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($exams as $exam)
                                        <tr class="hover-shadow-sm">
                                            <!-- Exam Name -->
                                            <td class="fw-semibold text-dark px-4">{{ $exam->exam_name }}</td>

                                            <!-- Grade -->
                                            <td>
                                                @if (optional($exam->grade)->gradeName)
                                                    <span class="badge rounded-pill bg-primary-subtle text-primary px-3 py-2">
                                                        {{ $exam->grade->gradeName }}
                                                    </span>
                                                @else
                                                    <span class="badge rounded-pill bg-danger-subtle text-danger px-3 py-2">
                                                        Grade not found
                                                    </span>
                                                @endif
                                            </td>

                                            <!-- Date & Time -->
                                            <td class="text-muted">{{ $exam->exam_date->format('d M Y') }}</td>
                                            <td class="text-muted">{{ $exam->exam_time->format('H:i') }}</td>

                                            <!-- Duration -->
                                            <td><span class="text-dark">{{ $exam->duration }} min</span></td>

                                            <!-- Marks -->
                                            <td class="text-center fw-bold">{{ $exam->total_marks }}</td>

                                            <!-- Status -->
                                            <td>
                                                <span class="badge rounded-pill px-3 py-2
                                                    {{ $exam->status === 'completed' ? 'bg-success-subtle text-success' :
                                                       ($exam->status === 'cancelled' ? 'bg-danger-subtle text-danger' :
                                                       'bg-warning-subtle text-dark') }}">
                                                    {{ ucfirst($exam->status) }}
                                                </span>
                                            </td>

                                            <!-- Actions -->
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center gap-2">
                                                    <a href="{{ route('exam.edit', $exam->id) }}"
                                                        class="btn btn-sm btn-outline-primary rounded-pill px-3"
                                                        data-bs-toggle="tooltip" title="Edit Exam">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="{{ route('exam.detail', $exam->id) }}"
                                                        class="btn btn-sm btn-outline-info rounded-pill px-3"
                                                        data-bs-toggle="tooltip" title="View Details">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <button type="button" class="btn btn-sm btn-outline-danger rounded-pill px-3"
                                                        onclick="confirmDelete('{{ $exam->id }}')" data-bs-toggle="tooltip"
                                                        title="Delete Exam">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                                <form id="deleteForm{{ $exam->id }}"
                                                    action="{{ route('exam.destroy', $exam->id) }}" method="POST"
                                                    class="d-none">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center text-muted py-4">
                                                No exams found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Pagination -->
                    @if (isset($exams) && $exams->hasPages())
                        <div class="d-flex flex-column align-items-end gap-3 pt-3">
                            <!-- Page Info -->
                            <div class="text-muted small">
                                Showing {{ $exams->firstItem() }} to {{ $exams->lastItem() }}
                                of {{ $exams->total() }} entries
                            </div>

                            <!-- Pagination -->
                            <nav aria-label="Page navigation">
                                <ul class="pagination pagination-sm m-0">
                                    <!-- Previous Page -->
                                    <li class="page-item {{ $exams->onFirstPage() ? 'disabled' : '' }}">
                                        <a class="page-link rounded-start-2" href="{{ $exams->previousPageUrl() }}"
                                            aria-label="Previous">
                                            <i class="fas fa-chevron-left"></i>
                                        </a>
                                    </li>

                                    <!-- Page Numbers -->
                                    @foreach ($exams->getUrlRange(1, $exams->lastPage()) as $page => $url)
                                        <li class="page-item {{ $page == $exams->currentPage() ? 'active' : '' }}">
                                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                        </li>
                                    @endforeach

                                    <!-- Next Page -->
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
                </div>
        </div>

        @endif
    </div>

    <!-- Create Exam Modal -->
    <div class="modal fade" id="examModal" tabindex="-1" aria-labelledby="examModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-primary text-white py-3">
                    <h5 class="modal-title" id="examModalLabel">Create New Exam</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('exam.store') }}" method="POST">
                    @csrf
                    <div class="modal-body p-4">
                        @if ($errors->any())
                            <div class="alert alert-danger rounded-3">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small text-muted mb-1">Exam Name</label>
                                <input type="text" name="exam_name" class="form-control rounded-3 shadow-sm"
                                    value="{{ old('exam_name') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Grade</label>
                                <select name="grade_id" class="form-select" required>
                                    <option value="">Select Grade</option>
                                    @foreach ($grades as $grade)
                                        <option value="{{ $grade->gradeId }}">{{ $grade->gradeName }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Exam Date</label>
                                <input type="date" name="exam_date" class="form-control"
                                    value="{{ old('exam_date') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Exam Time</label>
                                <input type="time" name="exam_time" class="form-control"
                                    value="{{ old('exam_time') }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Duration (minutes)</label>
                                <input type="number" name="duration" class="form-control"
                                    value="{{ old('duration') }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Total Marks</label>
                                <input type="number" name="total_marks" class="form-control"
                                    value="{{ old('total_marks') }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Passing Marks</label>
                                <input type="number" name="passing_marks" class="form-control"
                                    value="{{ old('passing_marks') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Subject</label>
                                <select name="subject_id" class="form-select" required>
                                    <option value="">Select Subject</option>
                                    @foreach ($subjects as $subject)
                                        <option value="{{ $subject->id }}"
                                            {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
                                            {{ $subject->sub_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="scheduled" {{ old('status') == 'scheduled' ? 'selected' : '' }}>
                                        Scheduled</option>
                                    <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>
                                        Completed</option>
                                    <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>
                                        Cancelled</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Create Exam</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
