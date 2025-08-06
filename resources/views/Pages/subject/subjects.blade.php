@extends('main')
@section('title', 'Subjects')
@section('content')
    <div class="container-fluid px-4">
        <div class="row">
            <div class="col-12">
                <!-- Search and Filter Section -->
                <div class="card shadow rounded-4 border-0 mb-4">
                    <div class="card-body p-4">
                        <form action="{{ route('subject.index') }}" method="GET" class="row g-3 align-items-end">

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
                                <a href="{{ route('subject.index') }}"
                                    class="btn btn-outline-secondary px-3 py-2 rounded-3 shadow-sm">
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
                                <form id="subjectForm" action="{{ route('subject.store') }}" method="POST"
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
    @if (isset($subjects) && $subjects->count() > 0)
        <!-- Desktop Design -->
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

                                @foreach ($subjects as $subject)

                                    <tr class="border-0 hover-shadow transition-all">

                                        <td class="py-3 px-4 border-0">
                                            <span class="text-primary fw-semibold fs-6">{{ $subject->sub_name }}</span>
                                        </td>
                                        <td class="py-3 px-4 border-0">
                                            @if ($subject->modules->count() > 0)
                                                @if ($subject->modules->count() <= 4)
                                                    @foreach ($subject->modules as $module)
                                                        <span
                                                            class="badge bg-gradient-success text-white px-3 py-2 rounded-pill me-1">
                                                            {{ $module->module_code }}
                                                        </span>
                                                    @endforeach
                                                @else
                                                    @foreach ($subject->modules->take(4) as $module)
                                                        <span
                                                            class="badge bg-gradient-success text-white px-3 py-2 rounded-pill me-1">
                                                            {{ $module->module_code }}
                                                        </span>
                                                    @endforeach
                                                    <a href="{{ route('subject.show', $subject->id) }}"
                                                        class="btn btn-sm btn-outline-info px-2 py-1 rounded-pill">
                                                        <i
                                                            class="fas fa-plus me-1"></i>{{ $subject->modules->count() - 4 }}
                                                        more
                                                    </a>
                                                @endif
                                            @else
                                                <span class="badge bg-gradient-warning text-dark px-3 py-2 rounded-pill">
                                                    <i class="fas fa-exclamation-triangle me-1"></i>
                                                    No Assigned
                                                </span>
                                            @endif
                                        </td>
                                        <td class="py-3 px-4 border-0">
                                            <div class="d-flex justify-content-center gap-2">
                                                <a href="{{ route('subject.edit', $subject->id) }}"
                                                    class="btn btn-sm btn-outline-primary px-3 hover-lift"
                                                    data-bs-toggle="tooltip" title="Edit subject">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="{{ route('subject.show', $subject->id) }}"
                                                    class="btn btn-sm btn-outline-info px-3 hover-lift"
                                                    data-bs-toggle="tooltip" title="View Details">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <button type="button"
                                                    class="btn btn-sm btn-outline-danger px-3 hover-lift"
                                                    onclick="confirmDelete('{{ $subject->id }}')"
                                                    data-bs-toggle="tooltip" title="Delete subject">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                            <form id="deleteForm{{ $subject->id }}"
                                                action="{{ route('subject.destroy', $subject->id) }}"
                                                method="POST" class="d-none">
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


                @if (isset($subjects) && $subjects->hasPages())
                    <div class="d-flex flex-column align-items-end gap-3 my-4">
                        <div class="text-muted small">
                            Showing {{ $subjects->firstItem() }} to {{ $subjects->lastItem() }} of
                            {{ $subjects->total() }} entries
                        </div>
                        <nav aria-label="Page navigation">
                            <ul class="pagination pagination-sm m-0">
                                <li class="page-item {{ $subjects->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link rounded-start-2" href="{{ $subjects->previousPageUrl() }}"
                                        aria-label="Previous">
                                        <i class="fas fa-chevron-left"></i>
                                    </a>
                                </li>
                                @foreach ($subjects->getUrlRange(1, $subjects->lastPage()) as $page => $url)
                                    <li class="page-item {{ $page == $subjects->currentPage() ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endforeach
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

        <!-- Mobile and Tablet Design -->
        <div class="d-lg-none">
            <div class="row g-3">
                @foreach ($subjects as $subject)
                    <div class="col-12">
                        <div class="card border-0 shadow-sm rounded-3 h-100 position-relative overflow-hidden">
                            <div class="position-absolute top-0 start-0 w-100 bg-primary" style="height: 3px;"></div>
                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div class="flex-grow-1">
                                        <div class="d-flex align-items-center mb-2">
                                            <h3 class="mb-0 text-dark fw-semibold">{{ $subject->sub_name }}</h3>
                                        </div>
                                        <div class="d-flex align-items-center text-muted">
                                            <i class="fas fa-layer-group me-2 text-info"></i>
                                            <span class="small">{{ $subject->modules->count() }} modules assigned</span>
                                        </div>
                                    </div>
                                </div>

                                @if ($subject->modules->count() > 0)
                                    <div class="bg-light rounded-2 p-3">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fas fa-cubes text-success me-2"></i>
                                            <small class="text-muted fw-semibold text-uppercase">Associated Modules</small>
                                        </div>
                                        <div class="d-flex flex-wrap gap-2">
                                            @if ($subject->modules->count() <= 4)
                                                @foreach ($subject->modules as $module)
                                                    <span
                                                        class="badge bg-success text-white px-2 py-1 rounded-2 fw-normal shadow-sm">
                                                        {{ $module->module_code }}
                                                    </span>
                                                @endforeach
                                            @else
                                                @foreach ($subject->modules->take(4) as $module)
                                                    <span
                                                        class="badge bg-success text-white px-2 py-1 rounded-2 fw-normal shadow-sm">
                                                        {{ $module->module_code }}
                                                    </span>
                                                @endforeach
                                                <a href="{{ route('subject.show', $subject->id) }}"
                                                    class="badge bg-secondary text-white px-2 py-1 rounded-2 text-decoration-none fw-normal shadow-sm">
                                                    +{{ $subject->modules->count() - 4 }} more
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                @else
                                    <div class="text-center py-3 bg-light rounded-2">
                                        <div class="text-muted mb-2">
                                            <i class="fas fa-inbox fs-3 opacity-50"></i>
                                        </div>
                                        <small class="text-muted">No modules available</small>
                                        <div class="mt-2">
                                            <a href="{{ route('subject.show', $subject->id) }}"
                                                class="btn btn-outline-success btn-sm rounded-2">
                                                <i class="fas fa-plus me-1"></i>Add Modules
                                            </a>
                                        </div>
                                    </div>
                                @endif

                                <div class="d-flex justify-content-end gap-2 mt-3">
                                    <a href="{{ route('subject.edit', $subject->id) }}"
                                        class="btn btn-sm btn-outline-primary px-3 hover-lift" data-bs-toggle="tooltip"
                                        title="Edit subject">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="{{ route('subject.show', $subject->id) }}"
                                        class="btn btn-sm btn-outline-info px-3 hover-lift" data-bs-toggle="tooltip"
                                        title="View Details">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-outline-danger px-3 hover-lift"
                                        onclick="confirmDelete('{{ $subject->id }}')" data-bs-toggle="tooltip"
                                        title="Delete subject">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>

                                <form id="deleteForm{{ $subject->id }}"
                                    action="{{ route('subject.destroy', $subject->id) }}" method="POST"
                                    class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Mobile Pagination -->
            @if (isset($subjects) && $subjects->hasPages())
                <div class="mt-4">
                    <div class="card border-0 shadow-sm rounded-3">
                        <div class="card-body p-3">
                            <div class="row align-items-center">
                                <div class="col-7">
                                    <div class="text-muted small d-flex align-items-center">
                                        <i class="fas fa-info-circle me-2 text-secondary"></i>
                                        <span>{{ $subjects->firstItem() }}-{{ $subjects->lastItem() }} of
                                            {{ $subjects->total() }} results</span>
                                    </div>
                                </div>
                                <div class="col-5 text-end">
                                    <div class="btn-group shadow-sm">
                                        @if (!$subjects->onFirstPage())
                                            <a href="{{ $subjects->previousPageUrl() }}"
                                                class="btn btn-outline-primary btn-sm">
                                                <i class="fas fa-chevron-left"></i>
                                            </a>
                                        @endif
                                        <span class="btn btn-primary btn-sm disabled px-2">
                                            {{ $subjects->currentPage() }}/{{ $subjects->lastPage() }}
                                        </span>
                                        @if ($subjects->hasMorePages())
                                            <a href="{{ $subjects->nextPageUrl() }}"
                                                class="btn btn-outline-primary btn-sm">
                                                <i class="fas fa-chevron-right"></i>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    @else
        <div class="card shadow-sm rounded-4 border-0">
            <div class="card-body p-5 text-center">
                <div class="mb-4">
                    <i class="fas fa-book-open text-muted" style="font-size: 4rem; opacity: 0.3;"></i>
                </div>
                <h4 class="text-muted mb-3">No Subjects Found</h4>
                <p class="text-muted mb-4">
                    There are currently no subjects in the system. Start by adding your first subject.
                </p>
                <a href="#" class="btn btn-primary shadow-sm" data-bs-toggle="modal"
                    data-bs-target="#exampleModal">
                    <i class="fas fa-plus me-2"></i>Add First Subject
                </a>
            </div>
        </div>
    @endif


@endsection
