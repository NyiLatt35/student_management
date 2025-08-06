@extends('main')
@section('title', 'Dashboard')

@section('content')
<div class="container-fluid py-4" style="background-color: #f8f9fc; min-height: 100vh;">

    {{-- Top Summary Cards --}}
    <div class="row g-4 mb-4">
        @php
            $cards = [
                ['title' => 'Total Students', 'value' => $totalStudents ?? 0, 'icon' => 'fa-user-graduate', 'bg' => 'bg-primary'],
                ['title' => 'Total Teachers', 'value' => $totalTeachers ?? 0, 'icon' => 'fa-chalkboard-teacher', 'bg' => 'bg-info'],
                ['title' => 'Total Results', 'value' => $totalResults ?? 0, 'icon' => 'fa-chart-line', 'bg' => 'bg-success'],
            ];
        @endphp
        @foreach($cards as $card)
        <div class="col-md-4">
            <div class="card shadow-sm border-0 rounded-4 p-3 text-white {{ $card['bg'] }}">
                <div class="d-flex align-items-center">
                    <div class="rounded-circle bg-white d-flex align-items-center justify-content-center me-3"
                         style="width: 55px; height: 55px;">
                        <i class="fas {{ $card['icon'] }} fa-lg {{ $card['bg'] === 'bg-primary' ? 'text-primary' : ($card['bg'] === 'bg-info' ? 'text-info' : 'text-success') }}"></i>
                    </div>
                    <div>
                        <h6 class="text-uppercase fw-semibold mb-1">{{ $card['title'] }}</h6>
                        <h2 class="fw-bold mb-0">{{ $card['value'] }}</h2>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Charts Section --}}
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 rounded-4 p-4">
                <div class="d-flex align-items-center mb-3">
                    <i class="fas fa-chart-area text-primary me-2"></i>
                    <h5 class="fw-bold text-primary mb-0">Performance Overview</h5>
                </div>
                <canvas id="lineChart" height="200"></canvas>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 rounded-4 p-4">
                <div class="d-flex align-items-center mb-3">
                    <i class="fas fa-chart-pie text-primary me-2"></i>
                    <h5 class="fw-bold text-primary mb-0">Pass vs Fail</h5>
                </div>
                <canvas id="pieChart" height="200"></canvas>
            </div>
        </div>
    </div>

    {{-- Tasks and Top Students --}}
    <div class="row g-4 mt-4">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 rounded-4 p-4">
                <div class="d-flex align-items-center mb-3">
                    <i class="fas fa-tasks text-primary me-2"></i>
                    <h5 class="fw-bold text-primary mb-0">Student Tasks</h5>
                </div>
                @forelse ($tasks as $task)
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="fw-medium">{{ $task['title'] }}</span>
                            <small class="text-muted">{{ $task['progress'] }}%</small>
                        </div>
                        <div class="progress rounded-pill" style="height: 8px;">
                            <div class="progress-bar bg-primary" role="progressbar"
                                 style="width: {{ $task['progress'] }}%"></div>
                        </div>
                    </div>
                @empty
                    <p class="text-muted">No tasks available.</p>
                @endforelse
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 rounded-4 p-4">
                <div class="d-flex align-items-center mb-3">
                    <i class="fas fa-award text-primary me-2"></i>
                    <h5 class="fw-bold text-primary mb-0">Top Students</h5>
                </div>
                <ul class="list-group list-group-flush">
                    @forelse ($topStudents as $student)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-light d-flex justify-content-center align-items-center me-3"
                                     style="width: 42px; height: 42px;">
                                    <i class="fas fa-user text-primary"></i>
                                </div>
                                <span class="fw-semibold">{{ $student['name'] }}</span>
                            </div>
                            <span class="badge bg-success rounded-pill px-3">{{ $student['score'] }}</span>
                        </li>
                    @empty
                        <li class="list-group-item text-muted">No top students found.</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>

{{-- Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const lineCtx = document.getElementById('lineChart').getContext('2d');
    new Chart(lineCtx, {
        type: 'line',
        data: {
            labels: @json($chartLabels),
            datasets: [{
                label: 'Performance',
                data: @json($chartData),
                borderColor: '#3b82f6',
                backgroundColor: 'rgba(59, 130, 246, 0.15)',
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#3b82f6'
            }]
        },
        options: { responsive: true, plugins: { legend: { display: false } } }
    });

    const pieCtx = document.getElementById('pieChart').getContext('2d');
    new Chart(pieCtx, {
        type: 'doughnut',
        data: {
            labels: ['Pass', 'Fail'],
            datasets: [{
                data: [{{ $passCount }}, {{ $failCount }}],
                backgroundColor: ['#22c55e', '#ef4444'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'bottom' } }
        }
    });
</script>
@endsection
