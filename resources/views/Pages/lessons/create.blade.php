@extends('main')
@section('title', 'Create Lesson')
@section('content')
    <div class="container-fluid px-4">
        <div class="row">
            <div class="col-12">
                <!-- Page Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h1 class="h3 mb-0">Create Lesson</h1>
                        <p class="text-muted">Add a new lesson for Subject</p>
                    </div>
                </div>

                <!-- Create Form Card -->
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="card shadow rounded-4 border-0">
                            <div class="card-body p-4">
                                <form action="{{ route('lesson.store') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf

                                    <!-- Subject Selection -->
                                    <div class="mb-4">
                                        {{-- <div> --}}
                                            {{-- <input type="text" value="{{  }}"> --}}
                                        {{-- </div> --}}
                                        <label for="subject_id" class="form-label fw-semibold">
                                            <i class="fas fa-book me-2 text-primary"></i>Subject
                                        </label>
                                        <select
                                            class="form-select form-select-lg rounded-3 @error('subject_id') is-invalid @enderror"
                                            id="subject_id" name="subject_id" required>
                                            <option value="">Select Subject</option>
                                            @foreach ($subjects as $subject)
                                                <option value="{{ $subject->id  }}"
                                                    {{ old('subject_id') == $subject->id ? 'selected' : '' }}>
                                                    {{ $subject->sub_name }}
                                                </option>

                                            @endforeach
                                        </select>
                                        @error('subject_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <!-- Lesson Name Input -->
                                    <div class="mb-4">
                                        <label for="lesson_name" class="form-label fw-semibold">
                                            <i class="fas fa-graduation-cap me-2 text-primary"></i>Module Code
                                        </label>
                                        <input type="text"
                                            class="form-control form-control-lg rounded-3 @error('lesson_name') is-invalid @enderror"
                                            id="lesson_name" name="lesson_name" value="{{ old('lesson_name') }}"
                                            placeholder="Enter module code" required>
                                        @error('lesson_name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="d-flex gap-3 justify-content-end">
                                        {{-- <a href="{{ route('lesson.index') }}"
                                           class="btn btn-outline-secondary px-4 py-2 rounded-3">
                                            <i class="fas fa-times me-2"></i>Cancel
                                        </a> --}}
                                        <button type="submit" class="btn btn-primary px-4 py-2 rounded-3 shadow-sm">
                                            <i class="fas fa-plus me-2"></i>Save
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
