@extends('main')
@section('title', 'Edit Student - ' . $editStudent->studentName)
@section('content')

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <!-- Edit Student Form Card -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-edit me-2"></i>Edit Student Information</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('student.update', $editStudent->studentId) }}" method="POST" enctype="multipart/form-data" autocomplete="off">
                        @csrf
                        @method('PUT') {{-- This is essential for update routes --}}

                        <h6 class="text-muted mb-3">Personal Information</h6>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    {{-- CORRECTED: Using old() helper with the model's current value as a fallback --}}
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $editStudent->studentName) }}" placeholder="Full Name" required>
                                    <label for="name">Full Name</label>
                                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    {{-- CORRECTED: Input name is "dob" and value is dynamic --}}
                                    <input type="date" class="form-control @error('dob') is-invalid @enderror" id="dob" name="dob" value="{{ old('dob', $editStudent->dateOfBirth) }}" placeholder="Date of Birth" required>
                                    <label for="dob">Date of Birth</label>
                                    @error('dob')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Gender</label>
                            <div>
                                <div class="form-check form-check-inline">
                                    {{-- CORRECTED: The 'checked' attribute is now dynamic --}}
                                    <input class="form-check-input" type="radio" name="gender" id="Male" value="Male" {{ old('gender', $editStudent->gender) == 'Male' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="Male">Male</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="gender" id="Female" value="Female" {{ old('gender', $editStudent->gender) == 'Female' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="Female">Female</label>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="photo" class="form-label">Update Student Photo</label>
                            <input class="form-control @error('photo') is-invalid @enderror" type="file" id="photo" name="photo" onchange="previewImage(event)">
                            <div class="mt-3">
                                <p class="text-muted small mb-1">Current Photo:</p>
                                {{-- CORRECTED: Dynamically shows the current photo if it exists --}}
                                <img id="imagePreview" src="{{ $editStudent->photo ? asset('storage/' . $editStudent->photo) : '#' }}"
                                     alt="Image Preview" class="img-thumbnail" style="max-width: 150px; {{ !$editStudent->photo ? 'display:none;' : '' }}"/>
                            </div>
                             <small class="form-text text-muted">Leave blank to keep the current photo.</small>
                            @error('photo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <hr class="my-4">
                        <h6 class="text-muted mb-3">Academic & Contact Information</h6>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <select class="form-select @error('grade') is-invalid @enderror" id="grade" name="grade" required>
                                        <option value="" disabled>Select a Grade</option>
                                        @foreach ($grades as $grade)
                                            {{-- CORRECTED: The 'selected' attribute is now dynamic --}}
                                            <option value="{{ $grade->gradeId }}" {{ old('grade', $editStudent->gradeId) == $grade->gradeId ? 'selected' : '' }}>
                                                {{ $grade->gradeName }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <label for="grade">Grade</label>
                                    @error('grade')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                             <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="date" class="form-control @error('enrollmentDate') is-invalid @enderror" id="enrollmentDate" name="enrollmentDate" value="{{ old('enrollmentDate', $editStudent->enrollmentDate) }}" placeholder="Enrollment Date" required>
                                    <label for="enrollmentDate">Enrollment Date</label>
                                    @error('enrollmentDate')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $editStudent->email) }}" placeholder="Email Address" required>
                                    <label for="email">Email Address</label>
                                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="tel" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $editStudent->phone) }}" placeholder="Phone Number" required>
                                    <label for="phone">Phone Number</label>
                                    @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="{{ old('address', $editStudent->address) }}" placeholder="Full Address" required>
                            <label for="address">Address</label>
                            @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <hr class="my-4">
                        <h6 class="text-muted mb-3">Parent/Guardian Information</h6>
                         <div class="row">
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('parentName') is-invalid @enderror" id="parentName" name="parentName" value="{{ old('parentName', $editStudent->parentName) }}" placeholder="Parent Name" required>
                                    <label for="parentName">Parent/Guardian Name</label>
                                    @error('parentName')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-floating">
                                    <input type="tel" class="form-control @error('parentPhone') is-invalid @enderror" id="parentPhone" name="parentPhone" value="{{ old('parentPhone', $editStudent->parentPhone) }}" placeholder="Parent Phone" required>
                                    <label for="parentPhone">Parent/Guardian Phone</label>
                                    @error('parentPhone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('student.show', $editStudent->studentId) }}" class="btn btn-outline-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                               <i class="fas fa-save me-2"></i> Update Student Record
                            </button>
                        </div>
                    </form>
                </div>
            </div>

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