@extends('main')
@section('title', 'Add Student')
@section('content')

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <!-- Add Student Form Card -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-user-plus me-2"></i>Register New Student</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('student.store') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
                        @csrf

                        <h6 class="text-muted mb-3">Personal Information</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="Full Name" required>
                                    <label for="name">Full Name</label>
                                    @error('name')<div class="invalid-feedback text-red">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="date" class="form-control @error('dob') is-invalid @enderror" id="dob" name="dob" value="{{ old('dob') }}" placeholder="Date of Birth" required>
                                    <label for="dob">Date of Birth</label>
                                    @error('dob')<div class="invalid-feedback text-red">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="gender" class="form-label">Gender</label>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="Male" value="Male" {{ old('gender') == 'Male' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="Male">Male</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="Female" value="Female" {{ old('gender') == 'Female' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="Female">Female</label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="photo" class="form-label">Student Photo</label>
                            <input class="form-control @error('photo') is-invalid @enderror" type="file" id="photo" name="photo" onchange="previewImage(event)">
                            <img id="imagePreview" src="#" alt="Image Preview" class="mt-3 img-thumbnail" style="display:none; max-width: 150px;"/>
                            @error('photo')<div class="invalid-feedback text-red">{{ $message }}</div>@enderror
                        </div>

                        <hr class="my-4">
                        <h6 class="text-muted mb-3">Academic & Contact Information</h6>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <select class="form-select @error('grade') is-invalid @enderror" id="grade" name="grade" required>
                                        <option value="" disabled selected>Select a Grade</option>
                                        @foreach ($grades as $grade)
                                            <option value="{{ $grade->gradeId }}" {{ old('grade') == $grade->gradeId ? 'selected' : '' }}>
                                                {{ $grade->gradeName }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="grade">Grade</label>
                                    @error('grade')<div class="invalid-feedback text-red">{{ $message }}</div>@enderror
                                </div>
                            </div>
                             <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="date" class="form-control @error('enrollmentDate') is-invalid @enderror" id="enrollmentDate" name="enrollmentDate" value="{{ old('enrollmentDate', date('Y-m-d')) }}" placeholder="Enrollment Date" required>
                                    <label for="enrollmentDate">Enrollment Date</label>
                                    @error('enrollmentDate')<div class="invalid-feedback text-red">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="Email Address" required>
                                    <label for="email">Email Address</label>
                                    @error('email')<div class="invalid-feedback text-red">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}" placeholder="Phone Number" required>
                                    <label for="phone">Phone Number</label>
                                    @error('phone')<div class="invalid-feedback text-red">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="{{ old('address') }}" placeholder="Full Address" required>
                            <label for="address">Address</label>
                            @error('address')<div class="invalid-feedback text-red">{{ $message }}</div>@enderror
                        </div>

                        <hr class="my-4">
                        <h6 class="text-muted mb-3">Parent/Guardian Information</h6>
                         <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('parentName') is-invalid @enderror" id="parentName" name="parentName" value="{{ old('parentName') }}" placeholder="Parent Name" required>
                                    <label for="parentName">Parent/Guardian Name</label>
                                    @error('parentName')<div class="invalid-feedback text-red">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="tel" class="form-control @error('parentPhone') is-invalid @enderror" id="parentPhone" name="parentPhone" value="{{ old('parentPhone') }}" placeholder="Parent Phone" required>
                                    <label for="parentPhone">Parent/Guardian Phone</label>
                                    @error('parentPhone')<div class="invalid-feedback text-red">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-primary btn-lg">
                               <i class="fas fa-save me-2"></i> Create Student Record
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Success Details Card (appears after submission) -->
            @if (session('success') && session()->has('student'))
                @php $student = session('student'); @endphp
                <div class="card shadow-sm border-success mt-5">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="fas fa-check-circle me-2"></i>Student Created Successfully</h5>
                    </div>
                    <div class="card-body p-4">
                        <h6 class="card-title">Details for {{ $student->studentName }} (ID: {{ $student->studentId }})</h6>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between"><strong>Name:</strong> <span>{{ $student->studentName }}</span></li>
                            <li class="list-group-item d-flex justify-content-between"><strong>Grade:</strong> <span>Grade-{{ $student->gradeId }}</span></li>
                            <li class="list-group-item d-flex justify-content-between"><strong>Email:</strong> <span>{{ $student->email }}</span></li>
                            <li class="list-group-item d-flex justify-content-between"><strong>Phone:</strong> <span>{{ $student->phone }}</span></li>
                            <li class="list-group-item d-flex justify-content-between"><strong>Address:</strong> <span>{{ $student->address }}</span></li>
                        </ul>
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('student.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-list me-1"></i> Back to List
                            </a>
                            <a href="{{ route('student.show', $student->studentId) }}" class="btn btn-primary">
                                <i class="fas fa-eye me-1"></i> View Full Profile
                            </a>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function(){
            const output = document.getElementById('imagePreview');
            output.src = reader.result;
            output.style.display = 'block';
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endpush