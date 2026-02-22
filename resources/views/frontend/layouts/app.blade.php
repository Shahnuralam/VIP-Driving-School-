<!DOCTYPE html>
<html lang="en">
<head>
    @php
        $siteName = $siteSettings['site_name'] ?? config('app.name', 'VIP Driving School Hobart');
        $siteTagline = $siteSettings['site_tagline'] ?? 'Professional Driving Lessons';
        $siteDescriptionDefault = $siteName . ' offers professional driving lessons, P1 assessments, and driving packages in Tasmania.';
        $contactPhone = $siteSettings['contact_phone'] ?? ($siteSettings['phone'] ?? '0400 000 000');
        $contactEmail = $siteSettings['contact_email'] ?? ($siteSettings['email'] ?? 'info@vipdrivingschool.com.au');
        $contactAddress = $siteSettings['business_address'] ?? ($siteSettings['address'] ?? 'Hobart, Tasmania');
        $brandParts = explode(' ', trim($siteName), 2);
    @endphp
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', $siteName) - {{ $siteTagline }}</title>
    <meta name="description" content="@yield('meta_description', $siteDescriptionDefault)">
    
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
            --primary-color: #f59e0b; /* Orange-500 from Tailwind/Reference */
            --secondary-color: #0f172a; /* Slate-900 (Deep Navy) */
            --slate-800: #1e293b;
            --slate-700: #334155;
            --slate-600: #475569;
            --slate-500: #64748b;
            --slate-400: #94a3b8;
            --slate-200: #e2e8f0;
            --slate-100: #f1f5f9;
            --slate-50: #f8fafc;
            
            --text-main: #0f172a;
            --text-muted: #64748b;
            --white: #ffffff;
            --light-bg: #f8fafc;
        }

        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap');
        
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: var(--text-main);
            background-color: var(--white);
            line-height: 1.6;
        }
        
        /* Navbar */
        .navbar {
            background: rgba(15, 23, 42, 0.95) !important;
            backdrop-filter: blur(10px);
            padding: 1.25rem 0;
            transition: all 0.4s ease;
        }
        
        .bg-slate-50 { background-color: var(--slate-50) !important; }
        .bg-slate-100 { background-color: var(--slate-100) !important; }
        .text-slate-300 { color: var(--slate-300) !important; }
        .text-slate-400 { color: var(--slate-400) !important; }
        .text-slate-500 { color: var(--slate-500) !important; }
        .text-slate-600 { color: var(--slate-600) !important; }
        .text-slate-700 { color: var(--slate-700) !important; }
        
        .fw-800 { font-weight: 800 !important; }
        .fw-700 { font-weight: 700 !important; }
        .fw-600 { font-weight: 600 !important; }

        .btn-outline-slate {
            border: 1px solid var(--slate-200);
            color: var(--secondary-color);
            background: white;
            transition: all 0.3s ease;
        }

        .btn-outline-slate:hover {
            background: var(--slate-50);
            border-color: var(--slate-300);
            color: var(--secondary-color);
        }

        .btn-check:checked + label.btn-outline-slate {
            border-color: var(--primary-color) !important;
            background-color: rgba(245, 158, 11, 0.05) !important;
            box-shadow: 0 4px 12px rgba(245, 158, 11, 0.1) !important;
        }

        .navbar.scrolled {
            padding: 0.8rem 0;
            background: var(--secondary-color) !important;
        }
        
        .navbar-brand {
            font-weight: 800;
            font-size: 1.5rem;
            color: white !important;
            letter-spacing: -0.5px;
            text-transform: uppercase;
        }

        .navbar-brand span {
            color: var(--primary-color);
        }
        
        .nav-link {
            color: rgba(255,255,255,0.8) !important;
            font-weight: 600;
            font-size: 0.9rem;
            padding: 0.5rem 1.25rem !important;
            transition: all 0.3s ease;
        }
        
        .nav-link:hover, .nav-link.active {
            color: var(--primary-color) !important;
        }
        
        .btn-book {
            background: var(--primary-color);
            color: var(--secondary-color) !important;
            border: none;
            padding: 0.8rem 1.75rem;
            border-radius: 8px;
            font-weight: 700;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .btn-book:hover {
            background: #ffa726;
            color: var(--secondary-color) !important;
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(245, 158, 11, 0.3);
        }

        .btn-outline-light {
            border: 2px solid rgba(255, 255, 255, 0.2);
            color: white;
            font-weight: 600;
            padding: 0.8rem 1.75rem;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(5px);
            transition: all 0.3s ease;
        }

        .btn-outline-light:hover {
            background: white;
            color: var(--secondary-color);
            border-color: white;
        }
        
        /* Hero Section */
        .hero-section {
            background-color: var(--secondary-color);
            background-image: linear-gradient(rgba(15, 23, 42, 0.7), rgba(15, 23, 42, 0.85)), url('https://images.unsplash.com/photo-1449965408869-eaa3f722e40d?q=80&w=2070&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 180px 0 120px;
            position: relative;
            text-align: center;
        }
        
        .hero-title {
            font-size: clamp(2.5rem, 8vw, 4.5rem);
            font-weight: 800;
            margin-bottom: 1.5rem;
            line-height: 1.1;
            letter-spacing: -2px;
        }

        .hero-title span {
            color: var(--primary-color);
        }
        
        .hero-subtitle {
            font-size: 1.25rem;
            color: var(--slate-300);
            max-width: 700px;
            margin: 0 auto 3rem;
            line-height: 1.6;
        }
        
        /* Section Styles */
        .section-padding {
            padding: 100px 0;
        }

        .bg-light {
            background-color: var(--slate-50) !important;
        }
        
        .section-tag {
            color: var(--primary-color);
            text-transform: uppercase;
            font-weight: 800;
            letter-spacing: 2px;
            font-size: 0.85rem;
            margin-bottom: 1rem;
            display: block;
        }

        .section-title {
            font-size: clamp(2rem, 5vw, 3rem);
            font-weight: 800;
            color: var(--secondary-color);
            margin-bottom: 1.5rem;
            letter-spacing: -1px;
        }
        
        .section-subtitle {
            color: var(--slate-500);
            font-size: 1.15rem;
            max-width: 600px;
            margin: 0 auto 4rem;
        }
        
        /* Cards */
        .service-card, .package-card, .location-card {
            background: white;
            border-radius: 12px;
            border: 1px solid var(--slate-200);
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
            height: 100%;
        }
        
        .service-card:hover, .package-card:hover, .location-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1);
            border-color: var(--primary-color);
        }

        .service-card.dark {
            background: var(--secondary-color);
            color: white;
            border-color: var(--slate-800);
        }

        .service-card.dark .text-muted {
            color: var(--slate-400) !important;
        }
        
        .package-card.featured {
            border: 2px solid var(--primary-color);
            position: relative;
        }
        
        .featured-badge {
            position: absolute;
            top: 20px;
            right: 20px;
            background: var(--primary-color);
            color: var(--secondary-color);
            padding: 4px 12px;
            border-radius: 6px;
            font-size: 0.7rem;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            z-index: 2;
        }
        
        .card-price {
            font-size: 2.25rem;
            font-weight: 800;
            color: var(--secondary-color);
        }

        .service-card.dark .card-price {
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
            border-radius: 12px;
            padding: 2.5rem;
            text-align: center;
            border: 1px solid var(--slate-100);
            box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1);
            transition: all 0.3s ease;
        }
        
        .info-card:hover {
            box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1);
        }
        
        .info-card i {
            font-size: 2.5rem;
            color: var(--primary-color);
            margin-bottom: 1.5rem;
            display: inline-block;
            background: var(--slate-50);
            padding: 20px;
            border-radius: 12px;
        }
        
        /* Testimonials */
        .testimonial-card {
            background: white;
            border-radius: 16px;
            padding: 2.5rem;
            border: 1px solid var(--slate-200);
            height: 100%;
        }
        
        .testimonial-card .stars {
            color: #fbbf24;
            margin-bottom: 1.25rem;
            display: flex;
            gap: 4px;
        }
        
        /* Footer */
        footer {
            background: var(--secondary-color);
            color: white;
            padding: 100px 0 40px;
            border-top: 1px solid var(--slate-800);
        }
        
        footer h5 {
            font-weight: 800;
            margin-bottom: 2rem;
            color: white;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 0.95rem;
        }
        
        footer a {
            color: var(--slate-400);
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        footer a:hover {
            color: var(--primary-color);
        }
        
        .footer-logo {
            font-weight: 800;
            font-size: 1.5rem;
            color: white;
            margin-bottom: 1.5rem;
            display: block;
        }

        .footer-logo span {
            color: var(--primary-color);
        }

        .social-icons {
            display: flex;
            gap: 12px;
            margin-top: 1.5rem;
        }

        .social-icons a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 44px;
            height: 44px;
            border-radius: 10px;
            background: var(--slate-800);
            color: white;
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }
        
        .social-icons a:hover {
            background: var(--primary-color);
            transform: translateY(-3px);
            color: var(--secondary-color);
        }
        
        /* Buttons */
        .btn-primary {
            background: var(--primary-color);
            border-color: var(--primary-color);
            color: var(--secondary-color);
            font-weight: 700;
        }
        
        .btn-primary:hover {
            background: #ffa726;
            border-color: #ffa726;
            color: var(--secondary-color);
        }
        
        .btn-outline-primary {
            border: 2px solid var(--primary-color);
            color: var(--secondary-color);
            font-weight: 700;
        }

        .btn-outline-primary:hover {
            background: var(--primary-color);
            color: var(--secondary-color);
            border-color: var(--primary-color);
        }
        
        /* Page Header */
        .page-header {
            background: var(--secondary-color);
            background-image: linear-gradient(rgba(15, 23, 42, 0.8), rgba(15, 23, 42, 0.9)), url('https://images.unsplash.com/photo-1449965408869-eaa3f722e40d?q=80&w=2070&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 160px 0 80px;
            text-align: center;
        }
        
        .page-header h1 {
            font-size: 3rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            letter-spacing: -1px;
        }
        
        .page-header .breadcrumb {
            background: transparent;
            margin-bottom: 0;
            justify-content: center;
        }
        
        .page-header .breadcrumb-item a {
            color: var(--slate-400);
            text-decoration: none;
            font-weight: 600;
        }
        
        .page-header .breadcrumb-item a:hover {
            color: var(--primary-color);
        }
        
        .page-header .breadcrumb-item.active {
            color: white;
            font-weight: 600;
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
                {{ $brandParts[0] }} <span>{{ $brandParts[1] ?? '' }}</span>
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
                <div class="col-lg-4 mb-5 mb-lg-0">
                    <a href="{{ route('frontend.home') }}" class="footer-logo">
                        {{ $brandParts[0] }} <span>{{ $brandParts[1] ?? '' }}</span>
                    </a>
                    <p class="text-slate-400 mb-4" style="color: var(--slate-400);">Professional driving lessons and P1 assessments in Hobart and surrounding areas. Learn to drive with confidence and master the road experts.</p>
                    <div class="social-icons">
                        @if(!empty($siteSettings['facebook_url'] ?? '#'))
                        <a href="{{ $siteSettings['facebook_url'] }}" target="_blank"><i class="fab fa-facebook-f"></i></a>
                        @endif
                        @if(!empty($siteSettings['instagram_url'] ?? '#'))
                        <a href="{{ $siteSettings['instagram_url'] }}" target="_blank"><i class="fab fa-instagram"></i></a>
                        @endif
                        @if(!empty($siteSettings['google_url'] ?? '#'))
                        <a href="{{ $siteSettings['google_url'] }}" target="_blank"><i class="fab fa-google-plus-g"></i></a>
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
                        <li class="mb-2"><i class="fas fa-phone me-2"></i>{{ $contactPhone }}</li>
                        <li class="mb-2"><i class="fas fa-envelope me-2"></i>{{ $contactEmail }}</li>
                        <li class="mb-2"><i class="fas fa-map-marker-alt me-2"></i>{{ $contactAddress }}</li>
                    </ul>
                </div>
            </div>
            <hr class="my-4 opacity-25">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start">
                    <p class="mb-0 opacity-75">&copy; {{ date('Y') }} {{ $siteName }}. All rights reserved.</p>
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
                navbar.classList.add('scrolled');
                navbar.style.boxShadow = '0 10px 15px -3px rgba(0,0,0,0.1)';
            } else {
                navbar.classList.remove('scrolled');
                navbar.style.boxShadow = 'none';
            }
        });
    </script>
    
    @yield('scripts')
</body>
</html>
