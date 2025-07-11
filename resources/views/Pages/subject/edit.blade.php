@extends('main')
@section('title', 'Edit Subject')
@section('content')

    <div class="container-fluid px-4">
        <div class="row">
            <div class="col-12">
                <!-- Page Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h1 class="h3 mb-0">Edit Subject</h1>
                        <p class="text-muted">Update subject information</p>
                    </div>
                    <a href="{{ route('admin.subject.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Subjects
                    </a>
                </div>

                <!-- Edit Form Card -->
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="card shadow rounded-4 border-0">

                            <div class="card-body p-4">
                                <form action="{{ route('admin.subject.update', $subject->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <!-- Subject Name Input -->
                                    <div class="mb-4">
                                        <label for="subject_name" class="form-label fw-semibold">
                                            <i class="fas fa-book me-2 text-primary"></i>Subject Name
                                        </label>
                                        <input type="text"
                                            class="form-control form-control-lg rounded-3 {{ $errors->has('subject_name') ? 'is-invalid' : '' }}"
                                            id="subject_name" name="subject_name"
                                            value="{{ old('subject_name', $subject->sub_name) }}"
                                            placeholder="Enter subject name" required>
                                        @if ($errors->has('subject_name'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('subject_name') }}
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Display Associated Modules -->
                                    <div class="mb-4">
                                        <label class="form-label fw-semibold">
                                            <i class="fas fa-layer-group me-2 text-primary"></i>Associated Modules
                                        </label>

                                        {{-- {{ $modules }} --}}

                                        {{-- <input type="text"
                                            class="form-control form-control-lg rounded-3 @error('lesson_name') is-invalid @enderror"
                                            id="lesson_name" name="lesson_name" value="{{ old('lesson_name') }}"
                                            placeholder="Enter module code" required>
                                        @error('lesson_name')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror --}}

                                        <div class="border rounded-3 p-3 bg-light">

                                            @if ($modules->count() > 0)
                                                @php $hasModules = false @endphp
                                                <div class="row g-2" id="modules-container">
                                                    @foreach ($modules as $module)
                                                        @if ($module->subject_id == $subject->id)
                                                            @php $hasModules = true @endphp
                                                            <div class="col-md-6" data-module-id="{{ $module->id }}">
                                                                <div class="input-group">
                                                                    
                                                                    <input type="text" class="form-control"
                                                                        name="lesson_code[]"
                                                                        value="{{ $module->module_code }}"
                                                                        placeholder="Module code">

                                                                    <button type="button"
                                                                        class="btn btn-outline-danger btn-sm"
                                                                        onclick="removeModule(this, {{ $module->id }})">
                                                                        <i class="fas fa-times"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                                @if (!$hasModules)
                                                    <div class="text-center py-4">
                                                        <i class="fas fa-inbox fa-2x text-muted mb-2"></i>
                                                        <p class="text-muted mb-0">No modules associated with this subject
                                                        </p>
                                                    </div>
                                                @endif
                                            @else
                                                <div class="text-center py-4">
                                                    <i class="fas fa-inbox fa-2x text-muted mb-2"></i>
                                                    <p class="text-muted mb-0">No modules available</p>
                                                </div>
                                            @endif


                                            <!-- Add Module Button -->
                                            <div class="mt-3">
                                                <button type="button" class="btn btn-outline-primary btn-sm"
                                                    onclick="addModule()">
                                                    <i class="fas fa-plus me-1"></i>Add Module
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Hidden inputs for modules to delete -->
                                        <div id="modules-to-delete"></div>
                                    </div>



                                    <!-- Action Buttons -->
                                    <div class="d-flex gap-3 justify-content-end">
                                        <a href="{{ route('admin.subject.index') }}"
                                            class="btn btn-outline-secondary px-4 py-2 rounded-3">
                                            <i class="fas fa-times me-2"></i>Cancel
                                        </a>
                                        <button type="submit" class="btn btn-primary px-4 py-2 rounded-3 shadow-sm">
                                            <i class="fas fa-save me-2"></i>Update Subject
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

    <script>
        function removeModule(button, moduleId) {
            // Add module ID to deletion list
            const deleteContainer = document.getElementById('modules-to-delete');
            const deleteInput = document.createElement('input');
            deleteInput.type = 'hidden';
            deleteInput.name = 'delete_modules[]';
            deleteInput.value = moduleId;
            deleteContainer.appendChild(deleteInput);

            // Remove the module from display
            button.closest('.col-md-6').remove();
        }

        function addModule() {
            const container = document.getElementById('modules-container');
            const newModule = document.createElement('div');
            newModule.className = 'col-md-6';
            newModule.innerHTML = `
                <div class="input-group">
                     <input type="text"
                            class="form-control"
                            id="lesson_name" name="lesson_code[]"
                            placeholder="module code">
                    <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeNewModule(this)">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;
            container.appendChild(newModule);
        }

        function removeNewModule(button) {
            button.closest('.col-md-6').remove();
        }
    </script>
@endsection


{{-- <input type="text" class="form-control" name="lesson_code" placeholder="Module name"> --}}
