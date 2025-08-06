@extends('main')
@section('title', 'Edit Exam Result')

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg rounded-4 border-0">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center rounded-top">
            <h5 class="mb-0">
                <i class="fas fa-edit me-2"></i>Edit Exam Result
            </h5>
            <a href="{{ route('exam.result') }}" class="btn btn-light btn-sm">
                <i class="fas fa-arrow-left me-1"></i>Back
            </a>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('exam.result.update', $result->id) }}" method="POST">
                @csrf
                @method('PUT')

                {{-- Exam Selection --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Exam</label>
                    <select name="exam_id" id="exam_id" class="form-select" required>
                        @foreach($exams as $exam)
                            <option value="{{ $exam->id }}" data-grade-id="{{ $exam->grade_id }}"
                                {{ $result->exam_id == $exam->id ? 'selected' : '' }}>
                                {{ $exam->exam_name }} - {{ $exam->subject_name }} ({{ $exam->grade_name }})
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Student Selection --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Student</label>
                    <select name="student_id" id="student_id" class="form-select" required>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}" data-grade-id="{{ $student->gradeId }}"
                                {{ $result->student_id == $student->id ? 'selected' : '' }}>
                                {{ $student->studentName }} (Grade: {{ $student->gradeId }})
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Marks Input --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Marks</label>
                    <input type="number" name="marks_obtained" class="form-control"
                           value="{{ $result->marks_obtained }}" required>
                </div>

                {{-- Status Selection --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Status</label>
                    <select name="status" class="form-select">
                        <option value="pass" {{ $result->status === 'pass' ? 'selected' : '' }}>Pass</option>
                        <option value="fail" {{ $result->status === 'fail' ? 'selected' : '' }}>Fail</option>
                    </select>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas fa-save me-2"></i>Update Result
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Script to filter students based on exam grade --}}
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
