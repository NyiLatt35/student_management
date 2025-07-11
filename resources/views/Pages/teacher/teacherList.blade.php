@extends('main')
@section('title', 'Teacher ')
@section('content')

    <div class="container mt-5">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-md-6">
                <h2 class="text-primary"><i class="fas fa-chalkboard-teacher me-2"></i>Teachers</h2>
            </div>
            <div class="col-md-6 text-end">
                <form action="" method="GET" class="d-inline-block me-2">
                    <div class="input-group">
                        <input type="text" name="query" class="form-control" placeholder="Search teachers..."
                            value="{{ request('query') }}">
                        <button class="btn btn-outline-secondary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
                <a href="{{ route('admin.teacher.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i>Add
                </a>
            </div>
        </div>

        <!-- Teachers List -->

        <div class="container mt-5">
            <div class="card">
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Name</th>
                                <th>Subject</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- @forelse($teachers as $teacher) --}}
                            <tr>
                                <td>ID</td>
                                <td>Name</td>
                                <td><span class="badge bg-primary">Subject</span></td>
                                <td>Email</td>
                                <td>phone</td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-outline-info me-1"><i class="fas fa-eye"></i></a>
                                    <a href="#" class="btn btn-sm btn-outline-primary me-1"><i class="fas fa-edit"></i></a>
                                    <a href="#" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                            {{-- @empty
                            <tr>
                                <td colspan="6" class="text-center">
                                    <img src="{{ asset('images/no-data.svg') }}" alt="No Data" class="img-fluid mb-3" style="max-width: 200px">
                                    <h4 class="text-muted">No teachers found</h4>
                                </td>
                            </tr>
                        @endforelse --}}
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- <div class="d-flex justify-content-center mt-3">
            {{ $teachers->links() }}
        </div> --}}
        </div>
    </div>
    @endsection
