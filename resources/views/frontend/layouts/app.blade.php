<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'VIP Driving School Hobart') - Professional Driving Lessons</title>
    <meta name="description" content="@yield('meta_description', 'VIP Driving School Hobart offers professional driving lessons, P1 assessments, and driving packages in Tasmania.')">
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- AOS Animation -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css">
    <!-- FullCalendar CSS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #1e3a5f;
            --secondary-color: #ff6b35;
            --accent-color: #ffc107;
            --text-color: #333;
            --light-bg: #f8f9fa;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            color: var(--text-color);
        }
        
        /* Navbar */
        .navbar {
            background: var(--primary-color) !important;
            padding: 1rem 0;
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: white !important;
        }
        
        .nav-link {
            color: rgba(255,255,255,0.9) !important;
            font-weight: 500;
            padding: 0.5rem 1rem !important;
            transition: all 0.3s ease;
        }
        
        .nav-link:hover, .nav-link.active {
            color: var(--accent-color) !important;
        }
        
        .btn-book {
            background: var(--secondary-color);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-book:hover {
            background: #e55a2b;
            color: white;
            transform: translateY(-2px);
        }
        
        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, var(--primary-color) 0%, #2d5a8c 100%);
            color: white;
            padding: 120px 0 80px;
            position: relative;
            overflow: hidden;
        }
        
        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 50%;
            height: 100%;
            background: url('/images/hero-car.png') no-repeat center right;
            background-size: contain;
            opacity: 0.1;
        }
        
        .hero-title {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
        }
        
        .hero-subtitle {
            font-size: 1.25rem;
            opacity: 0.9;
            margin-bottom: 2rem;
        }
        
        /* Section Styles */
        .section-padding {
            padding: 80px 0;
        }
        
        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 1rem;
        }
        
        .section-subtitle {
            color: #666;
            font-size: 1.1rem;
            margin-bottom: 3rem;
        }
        
        /* Cards */
        .service-card, .package-card, .location-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 30px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            overflow: hidden;
            height: 100%;
        }
        
        .service-card:hover, .package-card:hover, .location-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.15);
        }
        
        .package-card.featured {
            border: 3px solid var(--secondary-color);
            position: relative;
        }
        
        .package-card.featured::before {
            content: 'Most Popular';
            position: absolute;
            top: 15px;
            right: -35px;
            background: var(--secondary-color);
            color: white;
            padding: 5px 40px;
            font-size: 0.75rem;
            font-weight: 600;
            transform: rotate(45deg);
            z-index: 1;
        }
        
        .card-price {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--primary-color);
        }
        
        .card-price small {
            font-size: 1rem;
            font-weight: 400;
            color: #666;
        }
        
        /* Info Cards */
        .info-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            text-align: center;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
            transition: all 0.3s ease;
        }
        
        .info-card:hover {
            transform: translateY(-5px);
        }
        
        .info-card i {
            font-size: 3rem;
            color: var(--secondary-color);
            margin-bottom: 1rem;
        }
        
        /* Testimonials */
        .testimonial-card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        }
        
        .testimonial-card .stars {
            color: var(--accent-color);
            margin-bottom: 1rem;
        }
        
        /* Footer */
        footer {
            background: var(--primary-color);
            color: white;
            padding: 60px 0 30px;
        }
        
        footer h5 {
            font-weight: 600;
            margin-bottom: 1.5rem;
        }
        
        footer a {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        footer a:hover {
            color: var(--accent-color);
        }
        
        .social-icons a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255,255,255,0.1);
            margin-right: 10px;
            transition: all 0.3s ease;
        }
        
        .social-icons a:hover {
            background: var(--secondary-color);
        }
        
        /* Buttons */
        .btn-primary {
            background: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background: #2d5a8c;
            border-color: #2d5a8c;
        }
        
        .btn-secondary {
            background: var(--secondary-color);
            border-color: var(--secondary-color);
        }
        
        .btn-secondary:hover {
            background: #e55a2b;
            border-color: #e55a2b;
        }
        
        /* Page Header */
        .page-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, #2d5a8c 100%);
            color: white;
            padding: 120px 0 60px;
            text-align: center;
        }
        
        .page-header h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }
        
        .page-header .breadcrumb {
            background: transparent;
            margin-bottom: 0;
        }
        
        .page-header .breadcrumb-item a {
            color: rgba(255,255,255,0.8);
            text-decoration: none;
        }
        
        .page-header .breadcrumb-item a:hover {
            color: var(--accent-color);
        }
        
        .page-header .breadcrumb-item.active {
            color: rgba(255,255,255,0.6);
        }
        
        .page-header .breadcrumb-item + .breadcrumb-item::before {
            color: rgba(255,255,255,0.6);
        }
        
        /* Dark color variable */
        :root {
            --dark-color: #212529;
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2rem;
            }
            
            .section-title {
                font-size: 1.75rem;
            }
            
            .section-padding {
                padding: 50px 0;
            }
            
            .page-header {
                padding: 100px 0 40px;
            }
            
            .page-header h1 {
                font-size: 1.75rem;
            }
        }
    </style>
    
    @yield('styles')
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('frontend.home') }}">
                <i class="fas fa-car-side me-2"></i>VIP Driving School
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('frontend.home') ? 'active' : '' }}" href="{{ route('frontend.home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('lesson-packages') ? 'active' : '' }}" href="{{ route('lesson-packages') }}">Lesson Packages</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('p1-assessments') ? 'active' : '' }}" href="{{ route('p1-assessments') }}">P1 Assessments</a>
                    </li>
                    @if(isset($navbarPages) && $navbarPages->count() > 0)
                        @foreach($navbarPages as $navPage)
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is($navPage->slug) ? 'active' : '' }}" href="{{ route('page.show', $navPage->slug) }}">{{ $navPage->title }}</a>
                        </li>
                        @endforeach
                    @endif
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">Contact</a>
                    </li>
                    @auth('customer')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('customer.*') ? 'active' : '' }}" href="{{ route('customer.dashboard') }}">My Account</a>
                    </li>
                    @else
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('customer.login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('customer.register') }}">Register</a>
                    </li>
                    @endauth
                    <li class="nav-item ms-lg-3">
                        <a class="btn btn-book" href="{{ route('book-online') }}">
                            <i class="fas fa-calendar-check me-2"></i>Book Online
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <h5><i class="fas fa-car-side me-2"></i>VIP Driving School</h5>
                    <p class="opacity-75">Professional driving lessons and P1 assessments in Hobart and surrounding areas. Learn to drive with confidence.</p>
                    <div class="social-icons">
                        @if(!empty($siteSettings['facebook_url'] ?? ''))
                        <a href="{{ $siteSettings['facebook_url'] }}" target="_blank"><i class="fab fa-facebook-f"></i></a>
                        @endif
                        @if(!empty($siteSettings['instagram_url'] ?? ''))
                        <a href="{{ $siteSettings['instagram_url'] }}" target="_blank"><i class="fab fa-instagram"></i></a>
                        @endif
                        @if(!empty($siteSettings['google_url'] ?? ''))
                        <a href="{{ $siteSettings['google_url'] }}" target="_blank"><i class="fab fa-google"></i></a>
                        @endif
                        @if(empty($siteSettings['facebook_url'] ?? '') && empty($siteSettings['instagram_url'] ?? '') && empty($siteSettings['google_url'] ?? ''))
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-google"></i></a>
                        @endif
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 mb-4">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="{{ route('frontend.home') }}">Home</a></li>
                        <li class="mb-2"><a href="{{ route('lesson-packages') }}">Lesson Packages</a></li>
                        <li class="mb-2"><a href="{{ route('p1-assessments') }}">P1 Assessments</a></li>
                        <li class="mb-2"><a href="{{ route('book-online') }}">Book Online</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-4 mb-4">
                    <h5>Information</h5>
                    <ul class="list-unstyled">
                        @if(isset($footerPages) && $footerPages->count() > 0)
                            @foreach($footerPages as $page)
                            <li class="mb-2"><a href="{{ route('page.show', $page->slug) }}">{{ $page->title }}</a></li>
                            @endforeach
                        @else
                        <li class="mb-2"><a href="{{ route('contact') }}">Contact Us</a></li>
                        @endif
                    </ul>
                </div>
                <div class="col-lg-3 col-md-4 mb-4">
                    <h5>Contact Us</h5>
                    <ul class="list-unstyled">
                        <li class="mb-2"><i class="fas fa-phone me-2"></i>{{ $siteSettings['phone'] ?? '0400 000 000' }}</li>
                        <li class="mb-2"><i class="fas fa-envelope me-2"></i>{{ $siteSettings['email'] ?? 'info@vipdrivingschool.com.au' }}</li>
                        <li class="mb-2"><i class="fas fa-map-marker-alt me-2"></i>{{ $siteSettings['address'] ?? 'Hobart, Tasmania' }}</li>
                    </ul>
                </div>
            </div>
            <hr class="my-4 opacity-25">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0 opacity-75">&copy; {{ date('Y') }} VIP Driving School Hobart. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    @if(isset($footerPages))
                        @foreach($footerPages->take(3) as $page)
                        <a href="{{ route('page.show', $page->slug) }}" class="opacity-75 me-3">{{ $page->title }}</a>
                        @endforeach
                    @else
                    <a href="#" class="opacity-75 me-3">Privacy Policy</a>
                    <a href="#" class="opacity-75">Terms & Conditions</a>
                    @endif
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AOS Animation -->
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    <!-- FullCalendar JS -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    
    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true
        });
        
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.style.boxShadow = '0 2px 20px rgba(0,0,0,0.1)';
            } else {
                navbar.style.boxShadow = 'none';
            }
        });
    </script>
    
    @yield('scripts')
</body>
</html>
