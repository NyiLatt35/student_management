@extends('main')
@section('title', 'Student_List')
@section('content')

    <section class="mb-4">
        <div class="container">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3 mb-4">
                <!-- Title Section -->
                <div class="d-flex align-items-center">
                    <div class="bg-primary bg-opacity-10 p-3 rounded-circle me-3">
                        <i class="fas fa-users fa-2x text-primary"></i>
                    </div>
                    <h1 class="h3 mb-0">Student List</h1>
                </div>

                <!-- Search Bar -->
                <div class="search-bar flex-grow-1 mx-md-4" style="max-width: 200px;">
                    <form action="" method="GET">
                        <div class="input-group">
                            <input type="text" name="query" class="form-control search-input"
                                placeholder="Search students..." value="{{ request('query') }}">
                            <button type="submit" class="btn btn-search btn-info">
                                <i class="fas fa-search text-white"></i>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Add Button -->
                <div>
                    <a href="{{ route('student.create') }}" class="btn btn-primary btn-add px-4">
                        <i class="fas fa-plus me-2"></i>
                        <span class="d-none d-sm-inline">Add Student</span>
                        <span class="d-inline d-sm-none">Add</span>
                    </a>
                </div>

            </div>

            @if (isset($students) && $students->isEmpty())
                <!-- No Students Found -->
                <div class="card shadow-lg border-0 p-5"
                    style="background: linear-gradient(to right bottom, #ffffff, #f8f9fa);">
                    <div class="text-center">
                        <div class="mb-4">
                            <div class="d-inline-block p-3 rounded-circle mb-2"
                                style="background: linear-gradient(45deg, #e9ecef, #f8f9fa);">
                                <i class="fas fa-users-slash fa-3x"
                                    style="background: linear-gradient(45deg, #6610f2, #0d6efd);
                                  -webkit-background-clip: text;
                                  -webkit-text-fill-color: transparent;"></i>
                            </div>
                        </div>
                        <h5 class="fw-bold text-dark mb-3">No Students Found</h5>
                        <p class="text-muted mb-4">There are no students in the system yet.</p>
                        @if (!request('query'))
                            <a href="{{ route('student.create') }}"
                                class="btn btn-primary btn-lg px-4 rounded-pill shadow-sm hover-lift">
                                <i class="fas fa-plus-circle me-2"></i>
                                Add New Student
                            </a>
                        @endif
                    </div>
                </div>
            @else

            <!-- Desktop Table View (hidden on mobile) -->
            <div class="d-none d-lg-block">
                <div class="table-responsive">
                    <table class="table table-hover table-striped align-middle mb-0 border">
                        <thead class="table-primary">
                            <tr class="">
                                <th scope="col" class="fw-semibold py-3 px-4">#ID</th>
                                <th scope="col" class="fw-semibold py-3 px-4">Name</th>
                                <th scope="col" class="fw-semibold py-3 px-4">Grade</th>
                                <th scope="col" class="fw-semibold py-3 px-4">Phone</th>
                                <th scope="col" class="fw-semibold py-3 px-4">Address</th>
                                <th scope="col" class="fw-semibold py-3 px-4 text-center">Actions</th>
                            </tr>
                        </thead>

                        <tbody class="bg-white">
                            @foreach ($students as $student)
                                <tr class="border-bottom">
                                    <td class="py-3 px-4">
                                        <span class="fw-semibold text-primary">{{ $student->studentId }}</span>
                                    </td>
                                    <td class="py-3 px-4">{{ $student->studentName }}</td>
                                    <td class="py-3 px-4">
                                        <span class="badge bg-info bg-opacity-10 text-info px-2 py-1">
                                            Grade-{{ $student->gradeId }}
                                        </span>
                                    </td>
                                    {{-- <td class="py-3 px-4">{{ $student->email }}</td> --}}
                                    <td class="py-3 px-4">{{ $student->phone }}</td>
                                    <td class="py-3 px-4">{{ $student->address }}</td>
                                    <td class="py-3 px-4">
                                        <div class="d-flex justify-content-center gap-2">
                                            {{-- Edit Action for Student --}}
                                            <a href="{{ route('student.edit', $student->studentId) }}"
                                                class="btn btn-sm btn-light-primary" data-bs-toggle="tooltip"
                                                title="Edit Student">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            {{-- View Student Information Details --}}
                                            <a href="{{ route('student.show', $student->studentId) }}"
                                                class="btn btn-sm btn-info d-flex align-items-center"
                                                data-bs-toggle="tooltip" title="View Details">
                                                <i class="fas fa-eye text-white"></i>
                                            </a>
                                            {{-- Delete action --}}
                                            <button type="button" class="btn btn-sm btn-light-danger"
                                                onclick="confirmDelete('{{ $student->studentId }}')"
                                                data-bs-toggle="tooltip" title="Delete Student">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                        {{-- Delete form --}}
                                        <form id="deleteForm{{ $student->studentId }}"
                                            action="{{ route('student.destroy', $student->studentId) }}"
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

            <!-- Mobile List View (visible only on mobile) -->
            <div class="d-lg-none">

                @forelse($students ?? [] as $student)
                    <div class="card border-0 shadow mb-3">
                        <div class="card-body p-0">
                            <!-- Header -->
                            <div class="p-4 bg-primary bg-opacity-10">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="icon-wrapper">
                                        <i class="fas fa-id-card px-2"></i>
                                        <small class="text-muted">Student ID</small>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-bold">{{ $student->studentId }}</h6>
                                    </div>
                                </div>
                            </div>

                            <!-- Info Rows -->
                            <div class="p-4">
                                <div class="info-row">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="icon-wrapper my-1">
                                            <i class="fas fa-user px-2"></i>
                                            <small class="text-muted">Name</small>
                                        </div>
                                        <div>
                                            <div class="fw-semibold">{{ $student->studentName }}</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="info-row">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="icon-wrapper my-1">
                                            <i class="fas fa-graduation-cap px-2"></i>
                                            <small class="text-muted">Grade</small>
                                        </div>
                                        <div>
                                            <div class="fw-semibold">Grade-{{ $student->gradeId }}</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="info-row">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="icon-wrapper my-1">
                                            <i class="fas fa-phone px-2"></i>
                                            <small class="text-muted">Phone</small>
                                        </div>
                                        <div>
                                            <div class="fw-semibold">{{ $student->phone }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="d-flex justify-content-end gap-2 p-4 border-top">
                                <a href="{{ route('student.edit', $student->studentId) }}"
                                    class="btn btn-sm btn-primary d-flex align-items-center">
                                    <i class="fas fa-edit me-1"></i> Edit
                                </a>
                                <a href="{{ route('student.show', $student->studentId) }}"
                                    class="btn btn-sm btn-info text-white d-flex align-items-center">
                                    <i class="fas fa-eye me-1"></i>
                                    Details
                                </a>
                                <button type="button" class="btn btn-sm btn-danger"
                                    onclick="confirmDelete('{{ $student->studentId }}')">
                                    <i class="fas fa-trash me-1"></i> Delete
                                </button>
                            </div>
                        </div>
                    </div>

                @empty
                    <div class="alert alert-info text-center">No students found</div>
                @endforelse
            </div>
            @endif
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
    </section>


@endsection
