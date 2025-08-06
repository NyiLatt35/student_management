@extends('main')
@section('title', 'Teacher Dashboard')

@section('content')
<div class="container-fluid py-4" style="background-color: #f8f9fc; min-height: 100vh;">

    {{-- Summary Cards --}}
    <div class="row g-4 mb-4">
        @foreach ($cards as $card)
            <div class="col-md-4">
                <div class="card shadow-sm border-0 rounded-4 p-3" style="background-color: white;">
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle d-flex align-items-center justify-content-center me-3"
                             style="width: 55px; height: 55px; background-color: {{ $card['color'] }}20;">
                            <i class="fas {{ $card['icon'] }} fa-lg" style="color: {{ $card['color'] }};"></i>
                        </div>
                        <div>
                            <h6 class="text-muted text-uppercase fw-semibold mb-1">{{ $card['title'] }}</h6>
                            <h2 class="fw-bold mb-0" style="color: {{ $card['color'] }};">{{ $card['value'] }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Teacher Info Card --}}
    <div class="card shadow-sm border-0 rounded-4 mb-4">
        <div class="card-header bg-white border-0">
            <h5 class="fw-bold text-primary mb-0">
                <i class="fas fa-user-tie me-2"></i> Teacher Information
            </h5>
        </div>
        <div class="card-body">
            {{-- {{ $teacher }} --}}
            <p><strong>Name:</strong> {{ Auth::user()->name ?? 'N/A' }}</p>
            <p><strong>Email:</strong> {{ Auth::user()->email ?? 'N/A' }}</p>
            <p><strong>Phone:</strong> {{ $teacher->teacher_phone ?? '0123456789' }}</p>
            <p><strong>Address:</strong> {{ $teacher->teacher_address ?? 'N/A' }}</p>
        </div>
    </div>

    {{-- Classes Table --}}
    <div class="card shadow-sm border-0 rounded-4 mb-4">
        <div class="card-header bg-white d-flex justify-content-between align-items-center border-0">
            <h5 class="fw-bold mb-0 text-primary">
                <i class="fas fa-chalkboard-teacher me-2"></i> Your Classes
            </h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead style="background-color: #f8f9fc;">
                        <tr>
                            <th>#</th>
                            <th>Class Name</th>
                            <th>Students</th>
                            <th>Subject</th>
                            <th>Schedule</th>
                        </tr>
                    </thead>
                    <tbody>

                        @forelse ($classes as $class)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>Grade-{{ $class->name ?? 'N/A' }}</td>
                                <td>{{ $totalStudents }}</td>
                                <td>{{ $teacher->subject->sub_name ?? 'N/A' }}</td>
                                <td>{{ $class->schedule ?? 'active' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted py-4">No classes found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Performance Bar Chart --}}
    <div class="card shadow-sm border-0 rounded-4 p-4">
        <div class="d-flex align-items-center mb-3">
            <i class="fas fa-chart-bar me-2 text-primary"></i>
            <h5 class="fw-bold text-primary mb-0">Student Performance</h5>
        </div>
        <canvas id="performanceChart" height="120"></canvas>
    </div>
</div>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('performanceChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($performanceLabels ?? ['Class A', 'Class B']) !!},
            datasets: [{
                label: 'Average Score',
                data: {!! json_encode($performanceData ?? [75, 80]) !!},
                backgroundColor: '#4e73df',
                borderRadius: 6,
                barThickness: 30
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true, max: 100 } }
        }
    });
</script>
@endsection
