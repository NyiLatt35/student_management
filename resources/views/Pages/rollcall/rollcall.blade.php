@extends('main')
@section('title', 'Roll Call')
@section('content')
    <div class="container py-4">
        <div class="d-flex align-items-center mb-4">
            <div class="bg-primary bg-opacity-10 px-3 py-2 rounded-circle me-3">
                <i class="fas fa-clipboard-check text-primary fa-2x"></i>
            </div>
            <div>
                <h1 class="h3 mb-0">Roll Call</h1>
                <p class="text-muted mb-0 d-none d-md-block">Manage student attendance</p>
            </div>
        </div>

        <!-- Search Form -->
        <div class="card shadow-sm rounded-4 border-0 mb-4">
            <div class="card-body p-4">
                <form action="{{ route('admin.rollcall.create') }}" method="GET">
                    <div class="row g-3 align-items-end">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold small text-muted">
                                <i class="far fa-calendar me-1"></i>Date
                            </label>
                            <input type="date"
                                   class="form-control rounded-3 shadow-sm"
                                   name="date"
                                   value="{{ Request::get('date') }}"
                                   required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold small text-muted">
                                <i class="fas fa-graduation-cap me-1"></i>Grade
                            </label>
                            <select class="form-select rounded-3 shadow-sm"
                                    name="grade"
                                    required>
                                <option value="" disabled selected>Select grade</option>
                                @foreach ($grades as $grade)
                                    <option value="{{ $grade->gradeId }}"
                                        {{ Request::get('gradeId') == $grade->gradeId ? 'selected' : '' }}>
                                        {{ $grade->gradeName }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 d-flex gap-2">
                            <button type="submit" class="btn btn-primary px-4 py-2 rounded-3 shadow-sm flex-grow-1">
                                <i class="fas fa-search me-2"></i>Search
                            </button>
                            <a href="{{ route('admin.rollcall.index') }}"
                               class="btn btn-outline-secondary px-3 py-2 rounded-3 shadow-sm">
                                <i class="fas fa-redo"></i>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @if (isset($students) && !empty($students->count()))

            <!-- Table -->
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="d-flex align-items-center gap-3">
                            <i class="fas fa-list-check text-primary fa-lg"></i>
                            <h5 class="mb-0">Student Record List</h5>
                        </div>
                        <div class="text-muted">
                            <i class="fas fa-users me-2"></i>
                            {{ $students->count() }} Students
                        </div>
                    </div>
                    <!-- Responsive Design -->
                    <div class="d-none d-md-block">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-primary">
                                    <tr class="text-center">
                                        <th class="py-3">ID</th>
                                        <th class="py-3">Name</th>
                                        <th class="py-3">Grade</th>
                                        <th class="py-3">Date</th>
                                        <th class="py-3">Attandance</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($students as $student)
                                        @php
                                            // Initialize variables
                                            $attendanceTypeId = null;
                                            $attendance = null;

                                            $getAttendance = $student->getAttendance(
                                                $student->studentId,
                                                $grade->gradeId,
                                                Request::get('date'),
                                            );

                                            // Safely check for attendance type
                                            if (!is_null($getAttendance)) {
                                                $attendanceTypeId = $getAttendance->attendanceTypeId;
                                                $attendance = $getAttendance->attendanceTypeId;
                                            }

                                        @endphp

                                        <tr>
                                            <td class="py-3 px-4">
                                                <span class="fw-semibold text-primary"
                                                    id="studentId">{{ $student->studentId }}</span>
                                            </td>
                                            <td class="py-3 px-4 fw-semibold" id="studentName">{{ $student->studentName }}
                                            </td>
                                            <td class="py-3 px-4">
                                                <input type="hidden" id="gradeId" value="{{ $grade->gradeId }}">
                                                <span class="badge bg-info bg-opacity-10 text-info px-2 py-1"
                                                    id="gradeName">
                                                    {{ $student->grade->gradeName }}
                                                </span>
                                            </td>
                                            <td class="fw-semibold" id="">
                                                <input type="hidden" id="attendanceDate"
                                                    value="{{ Request::get('date') }}">
                                                {{ Request::get('date') }}
                                            </td>
                                            <td>
                                                <div class="d-flex flex-wrap gap-2">
                                                    {{-- Attendance Options --}}
                                                    <div class="form-check">
                                                        <input type="radio" class="form-check-input SaveAttendance"
                                                            name="attendance{{ $student->studentId }}"
                                                            id="attendance_{{ $student->studentId }}"
                                                            {{ !is_null($attendanceTypeId) && $attendanceTypeId == 1 ? 'checked' : '' }}
                                                            data-student-id="{{ $student->studentId }}"
                                                            data-grade-id="{{ $student->gradeId }}" value="1">
                                                        <label class="form-check-label"
                                                            for="attendance_{{ $student->studentId }}">
                                                            <span class="badge bg-success">Present</span>
                                                        </label>
                                                    </div>

                                                    <div class="form-check">
                                                        <input type="radio" class="form-check-input SaveAttendance"
                                                            name="attendance{{ $student->studentId }}"
                                                            id="attendance_{{ $student->studentId }}"
                                                            {{ !is_null($attendanceTypeId) && $attendanceTypeId == 2 ? 'checked' : '' }}
                                                            data-student-id="{{ $student->studentId }}"
                                                            data-grade-id="{{ $student->gradeId }}" value="2">
                                                        <label class="form-check-label"
                                                            for="attendance_{{ $student->studentId }}">
                                                            <span class="badge bg-warning">Absent with leave</span>
                                                        </label>
                                                    </div>

                                                    <div class="form-check">
                                                        <input type="radio" class="form-check-input SaveAttendance"
                                                            name="attendance{{ $student->studentId }}"
                                                            id="attendance_{{ $student->studentId }}"
                                                            {{ !is_null($attendanceTypeId) && $attendanceTypeId == 3 ? 'checked' : '' }}
                                                            data-student-id="{{ $student->studentId }}"
                                                            data-grade-id="{{ $student->gradeId }}" value="3">
                                                        <label class="form-check-label"
                                                            for="attendance_{{ $student->studentId }}">
                                                            <span class="badge bg-danger">Absent without leave</span>
                                                        </label>
                                                    </div>

                                                    <div class="form-check">
                                                        <input type="radio" class="form-check-input SaveAttendance"
                                                            name="attendance{{ $student->studentId }}"
                                                            id="attendance_{{ $student->studentId }}"
                                                            {{ !is_null($attendanceTypeId) && $attendanceTypeId == 4 ? 'checked' : '' }}
                                                            data-student-id="{{ $student->studentId }}"
                                                            data-grade-id="{{ $student->gradeId }}" value="4">
                                                        <label class="form-check-label"
                                                            for="attendance_{{ $student->studentId }}">
                                                            <span class="badge bg-info">Weather</span>
                                                        </label>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Mobile Design -->

                    <div class="d-block d-md-none">
                        @foreach ($students as $student)
                            <div class="card mb-3 shadow-sm">
                                <!-- Student Header -->
                                <div class="card-header bg-light border-0 py-3">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="fw-bold text-primary mb-1">
                                                {{ $student->studentName }}
                                            </h6>
                                            <small class="text-muted d-block">
                                                ID: {{ $student->studentId }}
                                            </small>
                                        </div>
                                        <span class="badge bg-info bg-opacity-10 text-info px-3 py-2">
                                            {{ $grade->gradeName }}
                                        </span>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <!-- Date Display -->
                                    <div class="text-muted small mb-3">
                                        Attendance Date: {{ Request::get('date') }}
                                    </div>

                                    <!-- Attendance Options -->
                                    <div class="d-flex flex-wrap gap-2">
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input SaveAttendance"
                                                name="attendance{{ $student->studentId }}" value="1"
                                                id="{{ $student->studentId }}"
                                                {{ !is_null($attendanceTypeId) && $attendanceTypeId == 1 ? 'checked' : '' }}
                                                data-grade-id="{{ $student->gradeId }}"
                                                data-student-id="{{ $student->studentId }}">

                                            <label class="form-check-label" for="{{ $student->studentId }}">
                                                <span class="badge bg-success text-white">Present</span>
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input SaveAttendance"
                                                name="attendance{{ $student->studentId }}" value="2"
                                                id="{{ $student->studentId }}"
                                                {{ !is_null($attendanceTypeId) && $attendanceTypeId == 2 ? 'checked' : '' }}
                                                data-grade-id="{{ $student->gradeId }}"
                                                data-student-id="{{ $student->studentId }}">

                                            <label class="form-check-label" for="{{ $student->studentId }}">
                                                <span class="badge bg-warning  text-dark">Absent with leave</span>
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input SaveAttendance"
                                                name="attendance{{ $student->studentId }}" value="3"
                                                id="{{ $student->studentId }}"
                                                {{ !is_null($attendanceTypeId) && $attendanceTypeId == 3 ? 'checked' : '' }}
                                                data-grade-id="{{ $student->gradeId }}"
                                                data-student-id="{{ $student->studentId }}">

                                            <label class="form-check-label" for="{{ $student->studentId }}">
                                                <span class="badge bg-danger text-white">Absent without leave</span>
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input SaveAttendance"
                                                name="attendance{{ $student->studentId }}" value="4"
                                                id="{{ $student->studentId }}"
                                                {{ !is_null($attendanceTypeId) && $attendanceTypeId == 4 ? 'checked' : '' }}
                                                data-grade-id="{{ $student->gradeId }}"
                                                data-student-id="{{ $student->studentId }}">

                                            <label class="form-check-label" for="{{ $student->studentId }}">
                                                <span class="badge bg-info text-white">Weather</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <!-- No students message -->
                    @if (request()->has('grade'))
                        <div class="alert alert-info">
                            No students found for the selected grade.
                        </div>
                    @endif
        @endif
    </div>
    </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.SaveAttendance').change(function() {
                let $radio = $(this);
                let studentId = $radio.data('student-id');
                let attendanceTypeId = $radio.val(); // Changed from attendance to attendanceTypeId
                let gradeId = $radio.data('grade-id');
                let date = $('#attendanceDate').val(); // Make sure this matches your date input ID


                // Validate required data
                if (!date) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Please select a date first'
                    });
                    $radio.prop('checked', false);
                    return;
                }
                console.log('Saving attendance for:', {
                    studentId: studentId,
                    attendanceTypeId: attendanceTypeId,
                    gradeId: gradeId,
                    date: date
                });

                $.ajax({
                    url: "{{ route('admin.rollcall.store') }}",
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        studentId: studentId,
                        attendanceTypeId: attendanceTypeId,
                        gradeId: gradeId,
                        attendanceDate: date
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: response.message,
                                timer: 1500,
                                showConfirmButton: false
                            });
                        }
                    },
                    error: function(xhr) {
                        console.error('Error:', xhr);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: xhr.responseJSON?.message ||
                                'Failed to save attendance'
                        });
                        $radio.prop('checked', false);
                    }
                });
            });
        });
    </script>
@endpush
