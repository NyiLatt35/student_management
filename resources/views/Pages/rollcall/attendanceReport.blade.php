@extends('main')
@section('title', 'Attendance List')
@section('content')

    <div class="container my-5">
        <!-- Search and Filter Section -->
        <div class="card shadow rounded-4 border-0 mb-4">
            <div class="card-body p-4">
                <form action="#" method="GET" class="row g-3 align-items-end">
                    <div class="col-md-2">
                        <label for="student_name" class="form-label fw-semibold small text-muted">Student Name</label>
                        <input type="text" id="student_name" name="student_name" class="form-control rounded-3 shadow-sm"
                            placeholder="Enter name...">
                    </div>
                    <div class="col-md-2">
                        <label for="attendance_date" class="form-label fw-semibold small text-muted">Date</label>
                        <input type="date" id="attendance_date" name="attendance_date"
                            class="form-control rounded-3 shadow-sm">
                    </div>
                    <div class="col-md-2">
                        <label for="grade" class="form-label fw-semibold small text-muted">Grade</label>
                        <select id="grade" name="grade" class="form-select rounded-3 shadow-sm">
                            <option value="" disabled selected>Select grade</option>
                            @foreach ($grades as $grade)
                                <option value="{{ $grade->gradeId }}"
                                    {{ Request::get('gradeId') == $grade->gradeId ? 'selected' : '' }}>
                                    {{ $grade->gradeName }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="attendance_type" class="form-label fw-semibold small text-muted">Status</label>
                        <select class="form-select rounded-3 shadow-sm" name="attendance_type">
                            <option value="" selected disabled>Select status</option>
                            @foreach ($attendances as $attendance)
                                <option value="{{ $attendance->attendanceTypeId }}"
                                    {{ Request::get('attendanceTypeId') == $attendance->attendanceTypeId ? 'selected' : '' }}>
                                    {{ $attendance->attendanceType }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 d-flex gap-2">
                        <button type="submit" class="btn btn-primary px-4 py-2 rounded-3 shadow-sm flex-grow-1">
                            <i class="fas fa-search me-2"></i>Search
                        </button>
                        <a href="{{ route('admin.rollcall.studentAttendanceReport') }}"
                            class="btn btn-outline-secondary px-3 py-2 rounded-3 shadow-sm">
                            <i class="fas fa-redo"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Attendance Records Table -->
        <div class="card shadow rounded-4 border-0">
            <div class="card-header bg-light py-4 px-4">
                <h5 class="mb-0 fw-bold text-primary">
                    <i class="fas fa-clipboard-list me-2"></i>Attendance Records
                </h5>
            </div>

            <div class="card-body p-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th class="py-3">ID</th>
                                <th class="py-3">Name</th>
                                <th class="py-3 text-center">Grade</th>
                                <th class="py-3 text-center">Status</th>
                                <th class="py-3 text-center">Date</th>
                                <th class="py-3 text-center">Created By</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($getRecord as $record)
                                <tr>
                                    <td class="fw-semibold text-primary">{{ $record->studentId }}</td>
                                    <td class="fw-semibold">{{ $record->studentName }}</td>
                                    <td class="text-center">
                                        <span class="badge bg-info text-white px-3 py-2">
                                            Grade-{{ $record->gradeId }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        @if ($record->attendanceTypeId == 1)
                                            <span class="badge bg-success-subtle text-success px-3 py-2">Present</span>
                                        @elseif ($record->attendanceTypeId == 2)
                                            <span class="badge bg-warning-subtle text-warning px-3 py-2">Absent with leave</span>
                                        @elseif ($record->attendanceTypeId == 3)
                                            <span class="badge bg-danger-subtle text-danger px-3 py-2">Absent without leave</span>
                                        @else
                                            <span class="badge bg-info-subtle text-info px-3 py-2">Weather</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <span
                                            class="text-muted small">{{ Date('d-m-Y', strtotime($record->attendanceDate)) }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span
                                            class="badge bg-success text-white px-3 py-2">{{ $record->createdBy ? 'Admin' : 'Teacher' }}</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">
                                        <i class="fas fa-info-circle me-2"></i>No records found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if (isset($getRecord) && $getRecord->hasPages())
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <small class="text-muted">
                            Showing {{ $getRecord->firstItem() }} to {{ $getRecord->lastItem() }}
                            of {{ $getRecord->total() }} entries
                        </small>
                        <nav>
                            <ul class="pagination pagination-sm mb-0">
                                <li class="page-item {{ $getRecord->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $getRecord->previousPageUrl() }}">
                                        <i class="fas fa-chevron-left"></i>
                                    </a>
                                </li>
                                @foreach ($getRecord->getUrlRange(1, $getRecord->lastPage()) as $page => $url)
                                    <li class="page-item {{ $page == $getRecord->currentPage() ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach
                                <li class="page-item {{ !$getRecord->hasMorePages() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $getRecord->nextPageUrl() }}">
                                        <i class="fas fa-chevron-right"></i>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
