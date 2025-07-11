<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Student Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }} ">
    <link rel="stylesheet" href="{{ asset('assets/css/pagination.css') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" rel="stylesheet">
</head>

<body>
    @if (Auth::check())
        <!-- Navbar -->
        <header class="">
            <nav class="navbar navbar-expand-lg navbar-light bg-white fixed-top shadow-sm ">
                <div class="container-fluid">
                    <button class="navbar-toggler border-0" type="button" data-bs-toggle="offcanvas"
                        href="#offcanvasExample" role="button" aria-controls="offcanvasExample">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <a class="navbar-brand fw-bold" href="#">
                        <i class="fas fa-graduation-cap text-primary me-2"></i>
                        SMS Dashboard
                    </a>

                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                                {{-- <img src="https://via.placeholder.com/32" class="rounded-circle me-1" width="32"> --}}
                                <span class="d-none d-lg-inline">
                                    @if (session('status'))
                                        <div class="alert alert-success" role="alert">
                                            {{ session('status') }}
                                        </div>
                                    @endif
                                    {{ Auth::user()->name }}
                                    {{-- @if (Auth::check())
                                    {{ Auth::user()->name }}
                                @endif --}}
                                </span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i>Profile</a>
                                </li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i>Settings</a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-sign-out-alt me-2"></i>
                                            Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>

        </header>
        <!-- Sidebar -->
        <div class="mt-2">
            <nav id="sidebarMenu" class="sidebar">
                <div class="position-sticky">
                    <div class="list-group list-group-flush mt-4">
                        <a href="{{ route('admin.home') }}"
                            class="nav-link {{ request()->routeIs('admin.home') ? 'active' : '' }}">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Dashboard</span>
                        </a>
                        <a href="{{ route('admin.student.index') }}"
                            class="nav-link {{ request()->routeIs('admin.student.index') ? 'active' : '' }}">
                            <i class="fas fa-user-graduate"></i>
                            <span>Student</span>
                        </a>
                        {{-- <ul class="nav-item list-unstyled m-0">
                            <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#studentMenu" role="button"
                                aria-expanded="{{ request()->routeIs('admin.student.index') || request()->routeIs('admin.student.create') ? 'true' : 'false' }}"
                                aria-controls="studentMenu">
                                <div class="">
                                    <i class="fas fa-user-graduate me-2"></i>
                                    <span>Student</span>
                                </div>
                                <i class="fas fa-chevron-down text-muted small"></i>
                            </a>

                            <div class="collapse ps-4 ms-2 border-start border-2 {{ request()->routeIs('admin.student.index') || request()->routeIs('admin.student.create') ? 'show' : '' }}"
                                id="studentMenu">
                                <ul class="nav flex-column mt-2">
                                    <li class="nav-item">
                                        <a href="{{ route('admin.student.index') }}"
                                            class="nav-link {{ request()->routeIs('admin.student.index') ? 'active' : '' }}">
                                            <i class="fas fa-list"></i>
                                            <span>Student List</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ route('admin.student.create') }}"
                                            class="nav-link {{ request()->routeIs('admin.student.create') ? 'active' : '' }}">
                                            <i class="fas fa-user-plus me-2 text-secondary"></i>
                                            Add Student
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </ul> --}}

                        <a href="{{ route('admin.teacher.index') }}" class="nav-link {{ request()->routeIs('admin.teacher.index') ? 'active' : '' }}">
                            <i class="fas fa-chalkboard-teacher"></i>
                            <span>Teachers</span>
                        </a>
                        <a href="{{ route('admin.subject.index') }}" class="nav-link {{ request()->routeIs('admin.subject.index') || request()->routeIs('admin.subject.edit') ? 'active' : '' }}">
                            <i class="fas fa-book"></i>
                            <span>Subjects</span>
                        </a>
                        <a href="{{ route('admin.lesson.index') }}" class="nav-link {{ request()->routeIs('admin.lesson.index') ? 'active' : '' }}">
                            <i class="fas fa-cube"></i>
                            <span>Module</span>
                        </a>
                        <a href="#" class="nav-link">
                            <i class="fas fa-chart-line"></i>
                            <span>Reports</span>
                        </a>
                        <a class="nav-link d-flex justify-content-between align-items-center" data-bs-toggle="collapse" href="#attendanceMenu" role="button"
                            aria-expanded="{{ request()->routeIs('admin.rollcall.index') || request()->routeIs('admin.rollcall.studentAttendanceReport') ? 'true' : 'false' }}"
                            aria-controls="attendanceMenu">
                            <div class="">
                                <i class="fas fa-clipboard-list me-2"></i>
                                <span>Attendance</span>
                            </div>
                            <i class="fas fa-chevron-down text-muted small"></i>
                        </a>

                        <div class="collapse ps-4 ms-2 border-start border-2 {{ request()->routeIs('admin.rollcall.index') || request()->routeIs('admin.rollcall.studentAttendanceReport') ? 'show' : '' }}"
                            id="attendanceMenu">
                            <ul class="nav flex-column mt-2">
                                <li class="nav-item">
                                    <a href="{{ route('admin.rollcall.index') }}"
                                        class="nav-link {{ request()->routeIs('admin.rollcall.index') ? 'active' : '' }}">
                                        <i class="fas fa-list"></i>
                                        <span>Attendance Records</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('admin.rollcall.studentAttendanceReport') }}"
                                        class="nav-link {{ request()->routeIs('admin.rollcall.studentAttendanceReport') ? 'active' : '' }}">
                                        <i class="fas fa-list-alt"></i>
                                        <span>Attendance Report</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <a href="#" class="nav-link">
                            <i class="fas fa-cog"></i>
                            <span>Settings</span>
                        </a>
                    </div>
                </div>
            </nav>

        </div>
        <div class="sidebar-overlay"></div>
        <!-- Main content -->
        <main class="main-content">
            <!-- Breadcrumb -->
            <div class="m-2">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item  font-bold"><a href="{{ route('admin.home') }}"
                                class="text-decoration-none">Home</a></li>
                        <li class="breadcrumb-item active">
                            @if (request()->routeIs('admin.student.create') || request()->routeIs('admin.student.edit'))
                                <a href="{{ route('admin.student.index') }}"
                                    class="text-decoration-none">Students_List</a> /
                            @endif
                            {{ request()->routeIs('admin.home') ? 'Dashboard' : View::yieldContent('title') }}
                        </li>

                    </ol>
                </nav>
            </div>

            <!-- Page content -->
            <div class="container-fluid p-0">
                @yield('content')
            </div>
        </main>
    @else
        <main class="container d-flex align-items-center justify-content-center vh-100">
            <div class="container-fluid p-0">
                @yield('content')
            </div>
        </main>
    @endif


    {{-- Toast Container --}}
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        @if (session('success') || session('error'))
            <div class="toast show align-items-center {{ session('success') ? 'text-bg-success' : 'text-bg-danger' }} border-0" role="alert" aria-live="assertive"
                aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <div class="d-flex align-items-center">
                            @if (session('success'))
                                <i class="fas fa-check-circle me-2"></i>
                                @else
                                <i class="fas fa-cancel me-2"></i>
                            @endif
                            {{ session('success') ? session('success') : session('error') }}
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <style>

    </style>
    <!-- jQuery first, then Bootstrap JS -->
   <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    @stack('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Toggle sidebar on mobile
        document.querySelector('.navbar-toggler').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('show');
        });

        // Hide sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            if (window.innerWidth <!event.target.closest('.sidebar') && !event.target.closest(
                    '.navbar-toggler')) {
                document.querySelector('.sidebar').classList.remove('show');
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Add JavaScript for confirmation -->
    <script src="{{ asset('assets/js/delete.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="{{ asset('assets/js/toast.js') }}"></script>
</body>

</html>
