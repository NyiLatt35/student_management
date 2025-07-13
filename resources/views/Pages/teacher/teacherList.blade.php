@extends('main')
@section('title', 'Teacher ')
@section('content')

    <div class="container mt-5">
        <div class="card shadow rounded-4 border-0 mb-4">
            <div class="card-body p-4">
                <form action="" method="GET" class="row g-3 align-items-end">
                    <div class="col-md-8">
                        <label for="query" class="form-label fw-semibold small text-muted">Search Teachers</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0">
                                <i class="fas fa-search text-muted"></i>
                            </span>
                            <input type="text" name="query" id="query" class="form-control border-start-0 ps-0"
                                placeholder="Search by name, email, or subject..." value="{{ request('query') }}">
                        </div>
                    </div>
                    <div class="col-md-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary px-4 py-2 rounded-3 shadow-sm">
                            <i class="fas fa-search me-2"></i>Search
                        </button>
                        <a href="{{ route('admin.teacher.index') }}"
                            class="btn btn-outline-secondary px-3 py-2 rounded-3 shadow-sm">
                            <i class="fas fa-redo"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Page Header -->
        <div
            class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
            <div>
                <h1 class="h3 mb-0">Teachers Management</h1>
                <p class="text-muted mb-0">Manage and organize your teaching staff</p>
            </div>
            <a href="{{ route('admin.teacher.create') }}" class="btn btn-primary shadow-sm">
                <i class="fas fa-plus me-2 d-none d-sm-inline"></i>
                <span class="d-none d-sm-inline">Add Teacher</span>
                <i class="fas fa-plus d-sm-none"></i>
            </a>
        </div>

        <!-- Teachers List -->
        <div class="container mt-3">
            <div class="card">
                <div class="card-body p-0">
                    <!-- Desktop/Tablet Table View -->
                    <div class="d-none d-md-block">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th class="ps-4">No.</th>
                                    <th>Name</th>
                                    <th>Subject</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th class="pe-4">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($teachers as $teacher)
                                    <tr>
                                        <td class="text-primary fw-semibold ps-4">{{ $teacher->teacher_id }}</td>
                                        <td class="fw-semibold">{{ $teacher->teacher_name }}</td>
                                        <td><span class="badge bg-primary">{{ $teacher->subject->sub_name }}</span></td>
                                        <td>{{ $teacher->teacher_email }}</td>
                                        <td>{{ $teacher->teacher_phone }}</td>
                                        <td class="pe-4">
                                            <div class="d-flex justify-content-center gap-2">
                                                {{-- Edit Action for teacher --}}
                                                <a href="{{ route('admin.teacher.edit', $teacher->id) }}"
                                                    class="btn btn-sm btn-light-primary" data-bs-toggle="tooltip"
                                                    title="Edit teacher">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                {{-- View teacher Information Details --}}
                                                <a href="{{ route('admin.teacher.show', $teacher->id) }}"
                                                    class="btn btn-sm btn-info d-flex align-items-center"
                                                    data-bs-toggle="tooltip" title="View Details">
                                                    <i class="fas fa-eye text-white"></i>
                                                </a>
                                                {{-- Delete action --}}
                                                <button type="button" class="btn btn-sm btn-light-danger"
                                                    onclick="confirmDelete('{{ $teacher->id }}')" data-bs-toggle="tooltip"
                                                    title="Delete teacher">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                            {{-- Delete form --}}
                                            <form id="deleteForm{{ $teacher->id }}"
                                                action="{{ route('admin.teacher.destroy', $teacher->id) }}" method="POST"
                                                class="d-none">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5">
                                            <i class="fas fa-users text-muted mb-3" style="font-size: 4rem;"></i>
                                            <h4 class="text-muted">No teachers found</h4>
                                            <p class="text-muted">Try adjusting your search criteria or add a new teacher.
                                            </p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Mobile Card View -->
                    <div class="d-md-none">
                        @forelse($teachers as $teacher)
                            <div class="border-bottom p-3">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <h6 class="mb-1 fw-semibold">{{ $teacher->teacher_name }}</h6>
                                        <small class="text-primary fw-semibold">ID: {{ $teacher->teacher_id }}</small>
                                    </div>
                                    <span class="badge bg-primary">{{ $teacher->subject->sub_name }}</span>
                                </div>

                                <div class="mb-2">
                                    <small class="text-muted d-block">
                                        <i class="fas fa-envelope me-1"></i>{{ $teacher->teacher_email }}
                                    </small>
                                    <small class="text-muted d-block">
                                        <i class="fas fa-phone me-1"></i>{{ $teacher->teacher_phone }}
                                    </small>
                                </div>

                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.teacher.edit', $teacher->id) }}"
                                        class="btn btn-sm btn-outline-primary flex-fill">
                                        <i class="fas fa-edit me-1"></i>Edit
                                    </a>
                                    <a href="{{ route('admin.teacher.show', $teacher->id) }}"
                                        class="btn btn-sm btn-outline-info flex-fill">
                                        <i class="fas fa-eye me-1"></i>View
                                    </a>
                                    <a href="{{ route('admin.teacher.destroy', $teacher->id) }}"
                                        class="btn btn-sm btn-outline-danger flex-fill">
                                        <i class="fas fa-trash me-1"></i>Delete
                                    </a>
                                </div>
                            </div>

                        @empty
                            <div class="text-center py-5">
                                <i class="fas fa-users text-muted mb-3" style="font-size: 3rem;"></i>
                                <h5 class="text-muted">No teachers found</h5>
                                <p class="text-muted small">Try adjusting your search criteria or add a new teacher.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            @if (isset($students) && $students->hasPages())
                <div class="d-flex flex-column align-items-end gap-3 my-4">
                    <!-- Page Info -->
                    <div class="text-muted small">
                        Showing {{ $students->firstItem() }} to {{ $students->lastItem() }}
                        of {{ $students->total() }} entries
                    </div>

                    <!-- Pagination -->
                    <nav aria-label="Page navigation">
                        <ul class="pagination pagination-sm m-0">
                            <!-- Previous Page -->
                            <li class="page-item {{ $students->onFirstPage() ? 'disabled' : '' }}">
                                <a class="page-link rounded-start-2" href="{{ $students->previousPageUrl() }}"
                                    aria-label="Previous">
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                            </li>

                            <!-- Page Numbers -->
                            @foreach ($students->getUrlRange(1, $students->lastPage()) as $page => $url)
                                <li class="page-item {{ $page == $students->currentPage() ? 'active' : '' }}">
                                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endforeach

                            <!-- Next Page -->
                            <li class="page-item {{ !$students->hasMorePages() ? 'disabled' : '' }}">
                                <a class="page-link rounded-end-2" href="{{ $students->nextPageUrl() }}"
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
