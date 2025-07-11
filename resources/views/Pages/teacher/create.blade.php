@extends('main')
@section('ttitle', 'Create Teacher')
@section('content')
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-header bg-primary text-white p-4 rounded-top-4">
                        <h4 class="mb-0">
                            <i class="fas fa-user-plus me-2"></i>
                            Add New Teacher
                        </h4>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('admin.teacher.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" name="name" class="form-control" id="name"
                                            placeholder="Full Name" required>
                                        <label for="name"><i class="fas fa-user me-2"></i>Full Name</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="email" name="email" class="form-control" id="email"
                                            placeholder="Email" required>
                                        <label for="email"><i class="fas fa-envelope me-2"></i>Email</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">

                                        <select class="form-select form-control" name="subject_name" id="subject_name" required>
                                            <option value="">Select a subject</option>
                                            @foreach ($getSubjects as $subject)
                                                <option value="{{ $subject->sub_code }}">{{ $subject->sub_name }}</option>
                                            @endforeach
                                        </select>
                                        <label for="subject_name"><i class="fas fa-book me-2"></i>Subject</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="tel" name="phone" class="form-control" id="phone"
                                            placeholder="Phone Number">
                                        <label for="phone"><i class="fas fa-phone me-2"></i>Phone Number</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" name="subject_code" class="form-control" id="subject_code"
                                            placeholder="Subject Code" required>
                                        <label for="subject_code"><i class="fas fa-code me-2"></i>Subject Code</label>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-3 mt-4">
                                <a href="{{ route('admin.teacher.index') }}" class="btn btn-light">
                                    <i class="fas fa-times me-2"></i>Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Save Teacher
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
