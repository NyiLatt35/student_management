@extends('main')
@section('title', 'Attendance List')
@section('content')

    <div class="container">
        <!-- Search and Filter Card -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form action="#" method="GET" class="row g-3 align-items-end">
                    <div class="col-md-2">
                        <label for="student_name" class="form-label fw-semibold">Student Name</label>
                        <input type="text" id="student_name" name="student_name" class="form-control" placeholder="Student Name...">
                    </div>
                    <div class="col-md-2">
                        <label for="attendance_date" class="form-label fw-semibold">Date</label>
                        <input type="date" id="attendance_date" name="attendance_date" class="form-control">
                    </div>
                    <div class="col-md-2">
                        <label for="grade" class="form-label fw-semibold">Grade</label>
                        <select id="grade" name="grade" class="form-select">
                            <option value="" disabled selected>Select a grade</option>
                            @foreach ($grades as $grade)
                                <option value="{{ $grade->gradeId }}"
                                    {{ Request::get('gradeId') == $grade->gradeId ? 'selected' : '' }}>
                                    {{ $grade->gradeName }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 form-group">
                        <label for="attendance_type" class="form-label fw-semibold">Attendance Type</label>
                        <select class="form-control" name="attendance_type">
                            <option value="" selected disabled>Selected</option>
                            @foreach ($attendances as $attendance)
                                <option value="{{ $attendance->attendanceTypeId }}"
                                    {{ Request::get('attendanceTypeId') == $attendance->attendanceTypeId ? 'selected' : '' }}>
                                    {{ $attendance->attendanceType }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-2 d-flex gap-2">
                        <button type="submit" class="btn btn-primary flex-grow-1">
                            <i class="fas fa-search me-2"></i>Search
                        </button>
                        <a href="{{ route('admin.rollcall.studentAttendanceReport') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-redo"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>


        <!-- Modern Student Attendance Table -->
        <div class="card shadow rounded-4 border-0">
            <div class="card-header border-0 py-4 px-4 d-flex justify-content-between align-items-center bg-light">
                <h5 class="mb-0 fw-bold text-primary">
                    <i class="fas fa-clipboard-list me-2"></i>Student Attendance Record
                </h5>
            </div>

            <div class="card-body px-4 py-4">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 table-bordered rounded-3 overflow-hidden">
                        <thead class="table-primary">
                            <tr class="text-center">
                                <th class="py-3">Student ID</th>
                                <th class="py-3">Student Name</th>
                                <th class="py-3">Grade</th>
                                <th class="py-3">Attendance Type</th>
                                <th class="py-3">Attendance Date</th>
                                <th class="py-3">Created By</th>

                            </tr>
                        </thead>
                        <tbody>

                            @forelse ($getRecord as $record)
                                <tr>
                                    <td class="fw-semibold text-center text-primary py-3">{{ $record->studentId }}</td>
                                    <td class="py-3 fw-semibold">{{ $record->studentName }}</td>
                                    <td class="py-3 text-center">
                                        <span class="badge bg-info bg-opacity-10 text-info px-2 py-1">
                                            Grade-{{ $record->gradeId }}
                                        </span>
                                    </td>
                                    <td class="py-3 text-center">
                                        @if ($record->attendanceTypeId == 1)
                                            <span class="badge bg-success rounded-pill px-3 py-2 shadow-sm">Present</span>
                                        @elseif ($record->attendanceTypeId == 2)
                                            <span class="badge bg-warning text-dark rounded-pill px-3 py-2 shadow-sm">Absent
                                                with leave</span>
                                        @elseif ($record->attendanceTypeId == 3)
                                            <span class="badge bg-danger rounded-pill px-3 py-2 shadow-sm">Absent without
                                                leave</span>
                                        @else
                                            <span class="badge bg-info rounded-pill px-3 py-2 shadow-sm">Weather</span>
                                        @endif
                                    </td>
                                    <td class="py-3 text-center">
                                        <small
                                            class="text-muted">{{ Date('d-m-Y', strtotime($record->attendanceDate)) }}</small>
                                    </td>
                                    <td class="py-3 text-center">
                                        {{ $record->createdBy ? 'Admin' : 'Teacher' }}
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted fw-semibold">
                                        <i class="fas fa-info-circle me-2"></i>No attendance records found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Pagination -->
        @if (isset($getRecord) && $getRecord->hasPages())
            <div class="d-flex flex-column align-items-end gap-3 my-4">
                <!-- Page Info -->
                <div class="text-muted small">
                    Showing {{ $getRecord->firstItem() }} to {{ $getRecord->lastItem() }}
                    of {{ $getRecord->total() }} entries
                </div>

                <!-- Pagination -->
                <nav aria-label="Page navigation">
                    <ul class="pagination pagination-sm m-0">
                        <!-- Previous Page -->
                        <li class="page-item {{ $getRecord->onFirstPage() ? 'disabled' : '' }}">
                            <a class="page-link rounded-start-2" href="{{ $getRecord->previousPageUrl() }}"
                                aria-label="Previous">
                                <i class="fas fa-chevron-left"></i>
                            </a>
                        </li>

                        <!-- Page Numbers -->
                        @foreach ($getRecord->getUrlRange(1, $getRecord->lastPage()) as $page => $url)
                            <li class="page-item {{ $page == $getRecord->currentPage() ? 'active' : '' }}">
                                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endforeach

                        <!-- Next Page -->
                        <li class="page-item {{ !$getRecord->hasMorePages() ? 'disabled' : '' }}">
                            <a class="page-link rounded-end-2" href="{{ $getRecord->nextPageUrl() }}" aria-label="Next">
                                <i class="fas fa-chevron-right"></i>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>

        @endif

    @endsection
