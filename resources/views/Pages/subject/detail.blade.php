@extends('main')
@section('title', 'Subject Details')
@section('content')

<div class="container-fluid px-4">
    <div class="row">
        <div class="col-12">
            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0">Subject Details</h1>
                    <p class="text-muted">{{ $subject->sub_name }}</p>
                </div>
                <div>
                    <a href="{{ route('subject.edit', $subject->id) }}" class="btn btn-primary me-2">
                        <i class="fas fa-edit me-1"></i>Edit
                    </a>
                    <a href="{{ route('subject.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i>Back
                    </a>
                </div>
            </div>

            <!-- Subject Info Card -->
            <div class="card shadow-sm rounded-4 border-0 mb-4">
                <div class="card-body p-4">
                    <h5 class="card-title">Subject Information</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Subject Name:</strong> {{ $subject->sub_name }}</p>
                            <p><strong>Created:</strong> {{ $subject->created_at->format('M d, Y') }}</p>
                            <p><strong>Last Updated:</strong> {{ $subject->updated_at->format('M d, Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modules Card -->
            <div class="card shadow-sm rounded-4 border-0">
                <div class="card-body p-4">
                    <h5 class="card-title">Associated Modules</h5>
                    @if($subject->modules && $subject->modules->count() > 0)
                        <div class="row">
                            @foreach($subject->modules as $module)
                                <div class="col-md-4 mb-3">
                                    <div class="card border-primary">
                                        <div class="card-body">
                                            <h6 class="card-title">{{ $module->module_code }}</h6>
                                            @if(isset($module->module_name))
                                                <p class="card-text text-muted">{{ $module->module_name }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No modules associated with this subject</p>
                            <a href="{{ route('subject.edit', $subject->id) }}" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i>Add Modules
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
