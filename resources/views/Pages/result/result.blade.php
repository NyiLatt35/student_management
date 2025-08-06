@extends('main')
@section('title', 'Exam Results')

@section('content')
    <div class="container mt-5">

        <h2 class="fw-bold text-primary mb-4">Exam Results</h2>
        {{-- Teachers: Add Result Button --}}
        @if (auth()->check() && auth()->user()->role === 'teacher')
            <div class="d-flex justify-content-end mb-3">
                <button class="btn btn-primary shadow-sm rounded-3" data-bs-toggle="modal" data-bs-target="#addResultModal">
                    <i class="fas fa-plus-circle me-2"></i>Add Result
                </button>
            </div>
        @endif

        {{-- Results Table --}}
        <div class="card shadow-lg rounded-4 border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-primary text-white">
                            <tr>
                                <th class="px-3 py-3">Student Name</th>
                                <th class="py-3">Exam Name</th>
                                <th class="py-3">Subject</th>
                                <th class="py-3">Grade</th>
                                <th class="text-center py-3">Marks</th>
                                <th class="text-center py-3">Status</th>
                                @if (auth()->check() && auth()->user()->role === 'teacher')
                                    <th class="text-center py-3">Actions</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>

                            @forelse($results as $result)
                                <tr>
                                    <td class="fw-semibold text-dark px-3">{{ $result->student->studentName ?? 'N/A' }}</td>
                                    <td><span
                                            class="badge bg-info text-dark px-3 py-2">{{ $result->exam->exam_name ?? 'N/A' }}</span>
                                    </td>
                                    <td class="text-secondary">{{ $result->exam->subject->sub_name ?? 'N/A' }}</td>
                                    <td><span
                                            class="badge bg-dark text-white px-3 py-2">{{ $result->exam->grade->gradeName ?? 'N/A' }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span
                                            class="fw-semibold px-1 py-1 rounded {{ ($result->marks_obtained ?? 0) < 40 ? 'bg-danger text-white' : 'bg-success text-white' }}">
                                            {{ $result->marks_obtained ?? 0 }}
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span
                                            class="badge rounded-pill px-3 py-2 {{ $result->status === 'pass' ? 'bg-success' : 'bg-danger' }}">
                                            {{ ucfirst($result->status) }}
                                        </span>
                                    </td>
                                    @if (auth()->check() && auth()->user()->role === 'teacher')
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                {{-- Edit Action for Result --}}
                                                <a href="{{ route('exam.result.edit', $result->id) }}"
                                                    class="btn btn-sm btn-light-primary" data-bs-toggle="tooltip"
                                                    title="Edit result">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                {{-- View Result Information Details --}}
                                                <a href="{{ route('exam.result.details', $result->id) }}"
                                                    class="btn btn-sm btn-info d-flex align-items-center"
                                                    data-bs-toggle="tooltip" title="View Details">
                                                    <i class="fas fa-eye text-white"></i>
                                                </a>
                                                {{-- Delete action --}}
                                                <button type="button" class="btn btn-sm btn-light-danger"
                                                    onclick="confirmDelete('{{ $result->id }}')"
                                                    data-bs-toggle="tooltip" title="Delete Result">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                            {{-- Delete form --}}
                                            <form id="deleteForm{{ $result->id }}"
                                                action="{{ route('exam.result.destroy', $result->id) }}" method="POST"
                                                class="d-none">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ auth()->check() && auth()->user()->role === 'teacher' ? '7' : '6' }}"
                                        class="text-center text-muted py-3">
                                        <i class="fas fa-info-circle me-2"></i>No results found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Add Result Modal (Teachers only) --}}
    @if (auth()->check() && auth()->user()->role === 'teacher')
        <div class="modal fade" id="addResultModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content rounded-4 shadow-lg">
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">Add New Exam Result</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        @if ($students->isEmpty() || $exams->isEmpty())
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-circle me-2"></i>No students or exams available.
                            </div>
                        @else
                            <form action="{{ route('exam.result.store') }}" method="POST">
                                @csrf
                                {{-- {{ $exams }} --}}
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Exam</label>
                                    <select name="exam_id" id="exam_id" class="form-select" required>
                                        <option value="">Select Exam</option>
                                        @foreach ($exams as $exam)
                                            <option value="{{ $exam->id }}" data-grade-id="{{ $exam->grade_id }}">
                                                {{ $exam->exam_name }} - {{ $exam->subject->sub_name }}
                                                ({{ $exam->grade_id }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Student</label>
                                    <select name="student_id" id="student_id" class="form-select" required>
                                        <option value="">Select Student</option>
                                        @foreach ($students as $student)
                                            <option value="{{ $student->id }}" data-grade-id="{{ $student->gradeId }}">
                                                {{ $student->studentName }} (Grade: {{ $student->gradeId }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Marks</label>
                                    <input type="number" name="marks" class="form-control" required>
                                </div>
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>Save Result
                                    </button>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif

    <script>
        document.getElementById('exam_id')?.addEventListener('change', function() {
            const gradeId = this.options[this.selectedIndex]?.getAttribute('data-grade-id');
            const studentSelect = document.getElementById('student_id');
            Array.from(studentSelect.options).forEach(option => {
                if (option.value === "") return;
                option.hidden = option.getAttribute('data-grade-id') !== gradeId;
            });
            studentSelect.value = "";
        });
    </script>
@endsection
