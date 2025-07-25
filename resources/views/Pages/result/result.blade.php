@extends('main')
@section('title', 'Exam List')
@section('content')
<div class="container mt-4">
    <h2 class="mb-3">Exam Results</h2>

    @if (auth()->user()->role === 'teacher')
        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
            <i class="fas fa-plus me-2"></i>Add Result
        </button>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Result</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="#" method="post">
                            @csrf
                            <div class="mb-3">
                                <label for="exam_id" class="form-label">Exam</label>
                                <select name="exam_id" id="exam_id" class="form-select">
                                    <option value="">Select Exam</option>
                                    @foreach ($exams as $exam)
                                        <option value="{{ $exam->id }}">{{ $exam->exam_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="student_id" class="form-label">Student</label>
                                <select name="student_id" id="student_id" class="form-select">
                                    <option value="">Select Student</option>
                                    @foreach ($students as $student)
                                        <option value="{{ $student->id }}">{{ $student->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="marks" class="form-label">Marks</label>
                                <input type="number" name="marks" id="marks" class="form-control">
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
    @else
        <table class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Student Name</th>
                    <th>Exam Name</th>
                    <th>Marks</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($results as $result)
                    <tr>
                        <td>{{ $result->student->name ?? 'N/A' }}</td>
                        <td>{{ $result->exam->exam_name ?? 'N/A' }}</td>
                        <td>{{ $result->marks ?? 'N/A' }}</td>
                        <td>
                            @if (auth()->user()->role === 'teacher')
                                <a href="#" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="#" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            @else
                                <span class="badge bg-secondary">View Only</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">No results found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    @endif

</div>
@endsection
