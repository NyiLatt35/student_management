@extends('main')
@section('content')
<div>

    <!-- Hero Section -->
    <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">
        <div class="carousel-inner">
            @foreach ([
                ['img' => 'https://images.unsplash.com/photo-1523240795612-9a054b0db644?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D', 'title' => 'Welcome to SMS Education', 'desc' => 'A place where knowledge meets inspiration.'],
                ['img' => 'https://images.unsplash.com/photo-1522202176988-66273c2fd55f?q=80&w=2071&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D', 'title' => 'Innovative Learning Spaces', 'desc' => 'Shaping future leaders through modern education.'],
                ['img' => 'https://images.unsplash.com/photo-1541339907198-e08756dedf3f?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D', 'title' => 'Dedicated Educators', 'desc' => 'Guiding every student on their path to success.']
            ] as $i => $slide)
            <div class="carousel-item {{ $i === 0 ? 'active' : '' }}" style="height: 90vh; background-image: url('{{ $slide['img'] }}'); background-size: cover; background-position: center;">
                <div class="carousel-caption d-flex flex-column justify-content-center align-items-center h-100">
                    <div class="bg-dark bg-opacity-50 p-4 rounded">
                        <h1 class="display-4 fw-bold text-white animate__animated animate__fadeInDown">{{ $slide['title'] }}</h1>
                        <p class="lead text-light animate__animated animate__fadeInUp">{{ $slide['desc'] }}</p>
                        <a href="#about" class="btn btn-primary btn-lg mt-3 animate__animated animate__pulse">Learn More</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <!-- About Section -->
    <section class="container my-5 py-5" id="about">
        <div class="text-center mb-5">
            <h2 class="fw-bold text-primary">About SMS Education</h2>
            <p class="text-muted lead">Empowering students for a brighter future.</p>
        </div>
        <div class="row g-4 text-center">
            @foreach ([
                ['icon' => 'fas fa-book-open', 'title' => 'Comprehensive Curriculum', 'desc' => 'A well-rounded curriculum designed to foster critical thinking and creativity.'],
                ['icon' => 'fas fa-shield-alt', 'title' => 'Safe & Secure Campus', 'desc' => 'A nurturing and secure environment where students can thrive.'],
                ['icon' => 'fas fa-users', 'title' => 'Expert Educators', 'desc' => 'A team of passionate and experienced educators dedicated to student success.']
            ] as $item)
            <div class="col-md-4">
                <div class="card border-0 h-100 p-4">
                    <i class="{{ $item['icon'] }} fa-3x text-primary mb-3"></i>
                    <h5 class="fw-bold">{{ $item['title'] }}</h5>
                    <p class="text-muted">{{ $item['desc'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <!-- Mission & Vision Section -->
    <section class="py-5 bg-light" id="mission">
        <div class="container">
            <div class="row align-items-center g-4">
                <div class="col-md-6">
                    <img src="https://images.unsplash.com/photo-1524178232363-1fb2b075b655?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" class="img-fluid rounded shadow-sm" alt="Our Mission">
                </div>
                <div class="col-md-6">
                    <h2 class="fw-bold text-primary">Our Mission & Vision</h2>
                    <div class="mt-4">
                        <h5 class="fw-bold"><i class="fas fa-bullseye me-2 text-primary"></i>Our Mission</h5>
                        <p class="text-muted">To inspire, educate, and empower students to excel academically and socially, preparing them for the challenges of a globalized world.</p>
                    </div>
                    <div class="mt-4">
                        <h5 class="fw-bold"><i class="far fa-eye me-2 text-primary"></i>Our Vision</h5>
                        <p class="text-muted">To be a leading educational institution that nurtures the leaders of tomorrow through quality education, innovation, and strong moral values.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Upcoming Events Section -->
    <section class="container my-5 py-5" id="events">
        <div class="text-center mb-5">
            <h2 class="fw-bold text-primary">Upcoming Events</h2>
            <p class="text-muted lead">Join us for our exciting events and activities.</p>
        </div>
        <div class="row g-4">
            @foreach ([
                ['date' => '15', 'month' => 'Aug', 'title' => 'Annual Sports Day', 'desc' => 'A day of fun, sportsmanship, and teamwork.'],
                ['date' => '10', 'month' => 'Sep', 'title' => 'Science & Tech Fair', 'desc' => 'Witness the innovative projects of our bright students.'],
                ['date' => '05', 'month' => 'Oct', 'title' => 'Parent-Teacher Conference', 'desc' => 'A collaborative meeting to discuss student progress.']
            ] as $event)
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100 text-center">
                    <div class="card-body p-4">
                        <div class="bg-primary text-white rounded-circle mx-auto d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                            <div>
                                <h3 class="fw-bold mb-0">{{ $event['date'] }}</h3>
                                <p class="mb-0">{{ $event['month'] }}</p>
                            </div>
                        </div>
                        <h5 class="fw-bold mt-4">{{ $event['title'] }}</h5>
                        <p class="text-muted">{{ $event['desc'] }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white pt-5 pb-4">
        <div class="container text-center text-md-start">
            <div class="row text-center text-md-start">
                <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3">
                    <h5 class="text-uppercase mb-4 fw-bold text-primary">SMS Education</h5>
                    <p>Providing quality education and fostering a love for learning since 2025.</p>
                </div>

                <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mt-3">
                    <h5 class="text-uppercase mb-4 fw-bold text-primary">Quick Links</h5>
                    <p><a href="#about" class="text-white text-decoration-none">About Us</a></p>
                    <p><a href="#events" class="text-white text-decoration-none">Events</a></p>
                    <p><a href="#" class="text-white text-decoration-none">Admissions</a></p>
                    <p><a href="#" class="text-white text-decoration-none">Contact</a></p>
                </div>

                <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mt-3">
                    <h5 class="text-uppercase mb-4 fw-bold text-primary">Contact</h5>
                    <p><i class="fas fa-home me-3"></i> 123 Education Lane, Knowledge City</p>
                    <p><i class="fas fa-envelope me-3"></i> info@smseducation.com</p>
                    <p><i class="fas fa-phone me-3"></i> + 01 234 567 88</p>
                </div>
            </div>

            <hr class="my-4">

            <div class="text-center">
                <p>© 2025 SMS Education. All Rights Reserved.</p>
                <div>
                    <a href="#" class="text-white me-4"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="text-white me-4"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-white me-4"><i class="fab fa-instagram"></i></a>
                </div>
            </div>
        </div>
    </footer>

</div>
@endsection