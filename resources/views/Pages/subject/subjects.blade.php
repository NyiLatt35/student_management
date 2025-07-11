@extends('main')
@section('title', 'Subjects')
@section('content')
    <div class="container-fluid px-4">
        <div class="row">
            <div class="col-12">
                <!-- Search and Filter Section -->
                <div class="card shadow rounded-4 border-0 mb-4">
                    <div class="card-body p-4">
                        <form action="#" method="GET" class="row g-3 align-items-end">

                            <div class="col-md-2">
                                <label for="subject_name" class="form-label fw-semibold small text-muted">Subject</label>
                                <input type="text" id="subject_name" name="subject_name"
                                    class="form-control rounded-3 shadow-sm" placeholder="Enter subject...">
                            </div>

                            <div class="col-md-2">
                                <label for="module_name" class="form-label fw-semibold small text-muted">Module</label>
                                <input type="text" id="module_name" name="module_name"
                                    class="form-control rounded-3 shadow-sm" placeholder="Enter module...">
                            </div>

                            <div class="col-md-3 d-flex gap-2">
                                <button type="submit" class="btn btn-primary px-4 py-2 rounded-3 shadow-sm flex-grow-1">
                                    <i class="fas fa-search me-2"></i>Search
                                </button>
                                <a href="#" class="btn btn-outline-secondary px-3 py-2 rounded-3 shadow-sm">
                                    <i class="fas fa-redo"></i>
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Page Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h1 class="h3 mb-0">Subjects Management</h1>

                    </div>

                    <a href="#" class="btn btn-primary shadow-sm" data-bs-toggle="modal"
                        data-bs-target="#exampleModal" data-bs-whatever="@mdo">
                        <i class="fas fa-plus me-2"></i>Add
                    </a>
                </div>

                {{-- Model --}}
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Add New Subject</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="subjectForm" action="{{ route('admin.subject.store') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="subject_name" class="col-form-label">Subject Name:</label>
                                        <input type="text" name="subject_name"
                                            class="form-control {{ $errors->has('subject_name') ? 'is-invalid' : '' }}"
                                            id="subject_name" value="{{ old('subject_name') }}" required>
                                        @if ($errors->has('subject_name'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('subject_name') }}
                                            </div>
                                        @endif
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="submit" form="subjectForm" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Subject List --}}
    <div class="d-none d-lg-block">
        <div class="card shadow-sm rounded-4 border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-primary text-white">
                            <tr>

                                <th scope="col" class="text-2xl fw-semibold py-4 px-4 border-0">
                                    Subject Name
                                </th>
                                <th scope="col" class="text-2xl fw-semibold py-4 px-4 border-0">
                                    Module
                                </th>
                                <th scope="col" class="text-2xl fw-semibold py-4 px-4 text-center border-0">
                                    Actions
                                </th>
                            </tr>
                        </thead>

                        <tbody class="bg-white">
                            {{-- {{ $subjects }} --}}
                            @foreach ($subjects as $subject)
                                {{-- {{ $subject }} --}}
                                <tr class="border-0 hover-shadow transition-all">

                                    <td class="py-3 px-4 border-0">
                                        <span class="text-primary fw-semibold fs-6">{{ $subject->sub_name }}</span>
                                    </td>
                                    <td class="py-3 px-4 border-0">
                                        {{-- Display assigned modules for the subject --}}
                                        @if ($subject->modules->count() > 0)
                                            @if ($subject->modules->count() <= 4)
                                                @foreach ($subject->modules as $module)
                                                    <span class="badge bg-gradient-success text-white px-3 py-2 rounded-pill me-1">
                                                        {{ $module->module_code }}
                                                    </span>
                                                @endforeach
                                            @else
                                                @foreach ($subject->modules->take(4) as $module)
                                                    <span class="badge bg-gradient-success text-white px-3 py-2 rounded-pill me-1">
                                                        {{ $module->module_code }}
                                                    </span>
                                                @endforeach
                                                <a href="{{ route('admin.subject.show', $subject->id) }}" class="btn btn-sm btn-outline-info px-2 py-1 rounded-pill">
                                                    <i class="fas fa-plus me-1"></i>{{ $subject->modules->count() - 4 }} more
                                                </a>
                                            @endif
                                        @else
                                            <span class="badge bg-gradient-warning text-dark px-3 py-2 rounded-pill">
                                                <i class="fas fa-exclamation-triangle me-1"></i>
                                                No Assigned
                                            </span>
                                        @endif

                                    </td>

                                    {{-- Action Buttons --}}
                                    <td class="py-3 px-4 border-0">
                                        <div class="d-flex justify-content-center gap-2">
                                            {{-- Edit Action for subject --}}
                                            <a href="{{ route('admin.subject.edit', $subject->id) }}"
                                                class="btn btn-sm btn-outline-primary px-3 hover-lift"
                                                data-bs-toggle="tooltip" title="Edit subject">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            {{-- View subject Information Details --}}
                                            <a href="{{ route('admin.subject.show', $subject->id) }}" class="btn btn-sm btn-outline-info px-3 hover-lift"
                                                data-bs-toggle="tooltip" title="View Details">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            {{-- Delete action --}}
                                            <button type="button" class="btn btn-sm btn-outline-danger px-3 hover-lift"
                                                onclick="confirmDelete('{{ $subject->id }}')" data-bs-toggle="tooltip"
                                                title="Delete subject">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                        {{-- Delete form --}}
                                        <form id="deleteForm{{ $subject->id }}"
                                            action="{{ route('admin.subject.destroy', $subject->id) }}" method="POST"
                                            class="d-none">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Pagination -->
            @if (isset($subjects) && $subjects->hasPages())
                <div class="d-flex flex-column align-items-end gap-3 my-4">
                    <!-- Page Info -->
                    <div class="text-muted small">
                        Showing {{ $subjects->firstItem() }} to {{ $subjects->lastItem() }}
                        of {{ $subjects->total() }} entries
                    </div>

                    <!-- Pagination -->
                    <nav aria-label="Page navigation">
                        <ul class="pagination pagination-sm m-0">
                            <!-- Previous Page -->
                            <li class="page-item {{ $subjects->onFirstPage() ? 'disabled' : '' }}">
                                <a class="page-link rounded-start-2" href="{{ $subjects->previousPageUrl() }}"
                                    aria-label="Previous">
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                            </li>

                            <!-- Page Numbers -->
                            @foreach ($subjects->getUrlRange(1, $subjects->lastPage()) as $page => $url)
                                <li class="page-item {{ $page == $subjects->currentPage() ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endforeach

                            <!-- Next Page -->
                            <li class="page-item {{ !$subjects->hasMorePages() ? 'disabled' : '' }}">
                                <a class="page-link rounded-end-2" href="{{ $subjects->nextPageUrl() }}"
                                    aria-label="Next">
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>

            @endif

        </div>
    </div>

@endsection
