@extends('main')
@section('title', 'Edit Exam')
@section('content')
<div class="container mt-4">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header bg-primary text-white rounded-top-4">
            <h3 class="mb-0">Edit Exam</h3>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('admin.exam.update', $exam->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="examName" class="form-label">Exam Name</label>
                        <input type="text" name="exam_name" id="examName" class="form-control"
                            value="{{ old('exam_name', $exam->exam_name) }}" required>
                    </div>

                    <div class="col-md-3">
                        <label for="examDate" class="form-label">Exam Date</label>
                        <input type="date" name="exam_date" id="examDate" class="form-control"
                            value="{{ old('exam_date', $exam->exam_date->format('Y-m-d')) }}" required>
                    </div>

                    <div class="col-md-3">
                        <label for="examTime" class="form-label">Exam Time</label>
                        <input type="time" name="exam_time" id="examTime" class="form-control"
                            value="{{ old('exam_time', $exam->exam_time->format('H:i')) }}" required>
                    </div>

                    <div class="col-md-4">
                        <label for="duration" class="form-label">Duration (minutes)</label>
                        <input type="number" name="duration" id="duration" class="form-control"
                            value="{{ old('duration', $exam->duration) }}" required>
                    </div>

                    <div class="col-md-4">
                        <label for="totalMarks" class="form-label">Total Marks</label>
                        <input type="number" name="total_marks" id="totalMarks" class="form-control"
                            value="{{ old('total_marks', $exam->total_marks) }}" required>
                    </div>

                    <div class="col-md-4">
                        <label for="passingMarks" class="form-label">Passing Marks</label>
                        <input type="number" name="passing_marks" id="passingMarks" class="form-control"
                            value="{{ old('passing_marks', $exam->passing_marks) }}" required>
                    </div>

                    <div class="col-md-6">
                        <label for="grade" class="form-label">Grade</label>
                        <select name="grade_id" id="grade" class="form-select" required>
                            @foreach ($grades as $grade)
                                <option value="{{ $grade->gradeId }}"
                                    {{ old('grade_id', $exam->grade_id) == $grade->gradeId ? 'selected' : '' }}>
                                    {{ $grade->gradeName }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="subject" class="form-label">Subject</label>
                        <select name="subject_id" id="subject" class="form-select" required>
                            @foreach ($subjects as $subject)
                                <option value="{{ $subject->id }}"
                                    {{ old('subject_id', $exam->subject_id) == $subject->id ? 'selected' : '' }}>
                                    {{ $subject->sub_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-12">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-select">
                            <option value="scheduled" {{ old('status', $exam->status) == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                            <option value="completed" {{ old('status', $exam->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ old('status', $exam->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('admin.exam.index') }}" class="btn btn-secondary px-4 me-2">Cancel</a>
                    <button type="submit" class="btn btn-primary px-4">Update Exam</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
