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
    @if (Auth::check() && empty(Auth::user()->role))
        <div class="container-fluid p-0">
            @yield('content')
        </div>
    @else
        <!--Main Navigation-->
        <header>
            @if (Auth::check() && (Auth::user()->role == 'admin' || Auth::user()->role == 'teacher'))
                <!-- Sidebar -->
                <nav id="sidebarMenu" class="d-lg-block sidebar collapse mt-3 bg-white">
                    <div class="position-sticky">
                        <div class="list-group list-group-flush mx-3 mt-4">
                            <a href="{{ route('dashboard') }}"
                                class="list-group-item m-2 list-group-item-action py-2 rounded {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                                <i class="fas fa-tachometer-alt fa-fw me-3"></i><span>Dashboard</span>
                            </a>
                            @if (Auth::user()->role == 'admin')
                                <a href="{{ route('subject.index') }}"
                                    class="list-group-item m-2 list-group-item-action py-2 rounded {{ request()->routeIs('subject.*') ? 'active' : '' }}">
                                    <i class="fas fa-book fa-fw me-3"></i><span>Subjects</span>
                                </a>
                                <a href="{{ route('lesson.index') }}"
                                    class="list-group-item m-2 list-group-item-action py-2 rounded {{ request()->routeIs('lesson.*') ? 'active' : '' }}">
                                    <i class="fas fa-cube fa-fw me-3"></i><span>Modules</span>
                                </a>
                                <a href="{{ route('teacher.index') }}"
                                    class="list-group-item m-2 list-group-item-action py-2 rounded {{ request()->routeIs('teacher.*') ? 'active' : '' }}">
                                    <i class="fas fa-chalkboard-teacher fa-fw me-3"></i><span>Teachers</span>
                                </a>
                                <a href="{{ route('student.index') }}"
                                    class="list-group-item m-2 list-group-item-action py-2 rounded {{ request()->routeIs('student.*') ? 'active' : '' }}">
                                    <i class="fas fa-user-graduate fa-fw me-3"></i><span>Students</span>
                                </a>
                            @endif
                            <a href="{{ route('exam.index') }}"
                                class="list-group-item m-2 list-group-item-action py-2 rounded {{ request()->routeIs('exam.index') ? 'active' : '' }}">
                                <i class="fas fa-file-alt fa-fw me-3"></i><span>Exam</span>
                            </a>
                            <a href="{{ route('rollcall.index') }}"
                                class="list-group-item m-2 list-group-item-action py-2 rounded {{ request()->routeIs('rollcall.index') ? 'active' : '' }}">
                                <i class="fas fa-clipboard-list fa-fw me-3"></i><span>Attendance</span>
                            </a>
                            <a href="{{ route('rollcall.studentAttendanceReport') }}"
                                class="list-group-item m-2 list-group-item-action py-2 rounded {{ request()->routeIs('rollcall.studentAttendanceReport') ? 'active' : '' }}">
                                <i class="fas fa-chart-pie fa-fw me-3"></i><span>Report</span>
                            </a>
                            <a href="{{ route('exam.result') }}"
                                class="list-group-item m-2 list-group-item-action py-2 rounded {{ request()->routeIs('exam.result') ? 'active' : '' }}">
                                <i class="fas fa-file-alt fa-fw me-3"></i><span>Result</span>
                            </a>
                            <a href="#" class="list-group-item m-2 list-group-item-action py-2 rounded">
                                <i class="fas fa-cog fa-fw me-3"></i><span>Settings</span>
                            </a>
                        </div>
                    </div>
                </nav>
            @endif
            <!-- Navbar -->
            <nav id="main-navbar" class="navbar navbar-expand-lg bg-white shadow-sm fixed-top">
                <!-- Container wrapper -->
                <div class="container-fluid">
                    <!-- Toggle button -->
                    @if (Auth::check() && (Auth::user()->role == 'admin' || Auth::user()->role == 'teacher'))
                        <button data-mdb-button-init class="navbar-toggler me-2" type="button" data-mdb-collapse-init
                            data-mdb-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false"
                            aria-label="Toggle navigation">
                            <i class="fas fa-bars"></i>
                        </button>
                    @endif

                    <!-- Brand -->
                    <a class="navbar-brand text-decoration-none" href="#">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary rounded-circle p-2 me-3">
                                <i class="fas fa-graduation-cap text-white fs-4"></i>
                            </div>
                            <div class="d-none d-lg-block">
                                <h4 class="mb-0 fw-bold text-primary">SMS Education</h4>
                            </div>
                        </div>
                    </a>

                    <!-- Right links -->
                    <ul class="navbar-nav ms-auto d-flex flex-row">
                        <!-- Avatar -->
                        @if (Auth::check())
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle d-flex align-items-center" href="#"
                                    id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class="fas fa-user-circle fa-2x text-primary me-2"></i>
                                    <span class="ms-2 d-none d-md-inline">{{ Auth::user()->name }}</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
                                    @if (Auth::user()->role == 'user')
                                        <li>
                                            <a class="dropdown-item" href="{{ route('user.dashboard') }}">My
                                                Dashboard</a>
                                        </li>
                                    @endif
                                    {{-- <li>
                                        <a class="dropdown-item" href="#">My profile</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="#">Settings</a>
                                    </li> --}}
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <button type="submit" class="dropdown-item">Logout</button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">Login</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">Register</a>
                            </li>
                        @endif
                    </ul>
                </div>

            </nav>

        </header>
        {{-- <!--Main Navigation-->
        @if (Auth::check() && (Auth::user()->role == 'admin' || Auth::user()->role == 'teacher')) --}}

        <!--Main layout-->
        @hasSection('title')
            @if (Auth::check() && (Auth::user()->role == 'admin' || Auth::user()->role == 'teacher'))
                <main class="main-content">
                    <div class="container-fluid">
                        <!-- Breadcrumb -->
                        @if (Auth::check() && (Auth::user()->role == 'admin' || Auth::user()->role == 'teacher'))
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">@yield('title')</li>
                                </ol>
                            </nav>
                        @else
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item active" aria-current="page">@yield('title')</li>
                                </ol>
                            </nav>
                        @endif

                        <div class="content-wrapper">
                            @yield('content')
                        </div>
                    </div>
                </main>
            @else
                <main class="main-content p-0 mx-0 mb-0">
                    <div class="container-fluid">
                        <div class="content-wrapper">
                            @yield('content')
                        </div>
                    </div>
                </main>
            @endif
        @else
            <main class="main-content p-0 mx-0 mb-0">
                <div class="container-fluid">
                    <div class="content-wrapper">
                        @yield('content')
                    </div>
                </div>
            </main>
        @endif

    @endif

    {{-- Toast Container --}}
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        @if (session('success'))
            <div class="toast show align-items-center text-bg-success border-0" role="alert" aria-live="assertive"
                aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                        </div>
                    </div>
                </div>
            </div>
        @elseif (session('error'))
            <div class="toast show align-items-center text-bg-danger border-0" role="alert" aria-live="assertive"
                aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            {{ session('error') }}
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

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
            if (window.innerWidth < !event.target.closest('.sidebar') && !event.target.closest(
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
    <script type="module" src="{{ asset('assets/js/script.js') }}"></script>
</body>

</html>
