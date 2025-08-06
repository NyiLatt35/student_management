@extends('main')
@section('title', 'Dashboard')
@section('content')

<div class="container-fluid" style="margin-top: 100px;">

    @if ($student)
        <!-- Welcome Header -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <i class="fas fa-user-circle fa-3x text-primary me-3"></i>
                    <div>
                        <h4 class="card-title mb-0">Welcome, {{ $student->studentName }}</h4>
                        <p class="card-text text-muted mb-0">Your academic overview is ready.</p>
                    </div>
                    <!-- Go Back Home Button -->
                    <a href="{{ url('/') }}" class="btn btn-outline-secondary btn-sm ms-auto">
                        <i class="fas fa-arrow-left me-1"></i> Back to Home
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Main Content: Exam Results -->
            <div class="col-lg-8 mb-4">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="fas fa-poll me-2 text-primary"></i>Exam Results</h5>
                    </div>
                    <div class="card-body">
                        @if(count($results))
                            <div class="table-responsive">
                                <table class="table table-hover align-middle">
                                    <thead>
                                        <tr>
                                            <th>Exam</th>
                                            <th>Subject</th>
                                            <th class="text-center">Score</th>
                                            <th class="text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($results as $result)
                                            <tr>
                                                <td>
                                                    <strong>{{ $result->exam_name }}</strong><br>
                                                    <small class="text-muted">{{ \Carbon\Carbon::parse($result->exam_date)->format('d M Y') }}</small>
                                                </td>
                                                <td>{{ $result->sub_name }}</td>
                                                <td class="text-center">{{ $result->marks_obtained }} / {{ $result->total_marks }}</td>
                                                <td class="text-center">
                                                    @if($result->marks_obtained >= 40)
                                                        <span class="badge rounded-pill bg-success">Passed</span>
                                                    @else
                                                        <span class="badge rounded-pill bg-danger">Failed</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-file-excel fa-3x text-muted mb-3"></i>
                                <p class="mb-0">No exam results available.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar Content: Attendance -->
            <div class="col-lg-4 mb-4">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="fas fa-calendar-check me-2 text-info"></i>Attendance</h5>
                    </div>
                    <div class="card-body">
                        @if(count($attendances))
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <tbody>
                                        @foreach ($attendances as $att)
                                            <tr>
                                                <td>{{ \Carbon\Carbon::parse($att->attendanceDate)->format('F d, Y') }}</td>
                                                <td class="text-end">
                                                    @if($att->attendanceType == 'Present')
                                                        <span class="badge bg-info-subtle text-info-emphasis">{{ $att->attendanceType }}</span>
                                                    @else
                                                        <span class="badge bg-warning-subtle text-warning-emphasis">{{ $att->attendanceType }}</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                                <p class="mb-0">No attendance records found.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- No Data Fallback Message -->
        <div class="text-center py-5">
            <i class="fas fa-exclamation-triangle fa-3x text-warning mb-3"></i>
            <h4 class="h5">Student Data Not Found</h4>
            <p class="text-muted">We couldn't find any data for your account. Please contact support.</p>
            <a href="{{ url('/') }}" class="btn btn-primary mt-3">
                <i class="fas fa-home me-2"></i> Go to Home Page
            </a>
        </div>
    @endif
</div>

@endsection