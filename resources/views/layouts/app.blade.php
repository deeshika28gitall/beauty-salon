<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Kharbanda Makeup Studio')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
    @php
        $navItems = $navItems ?? collect([
            (object) ['label' => 'Gallery', 'href' => route('gallery'), 'open_in_new_tab' => false],
            (object) ['label' => 'Testimonials', 'href' => '#testimonials', 'open_in_new_tab' => false],
            (object) ['label' => 'Contact', 'href' => '#contact', 'open_in_new_tab' => false],
        ]);
    @endphp
    <nav class="navbar navbar-expand-lg fixed-top site-navbar">
        <div class="container">
            <a class="navbar-brand brand-mark" href="{{ url('/') }}">
                <span class="brand-icon"><i class="bi bi-stars"></i></span>
                <span>Kharbanda <strong>Makeup Studio</strong></span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse navbar-collapse-site" id="mainNavbar">
                <ul class="navbar-nav site-nav-links align-items-lg-center justify-content-lg-center gap-lg-2">
                    @foreach($navItems as $item)
                        <li class="nav-item">
                            <a class="nav-link" href="{{ $item->href }}" @if($item->open_in_new_tab) target="_blank" rel="noopener noreferrer" @endif>{{ $item->label }}</a>
                        </li>
                    @endforeach
                    <li class="nav-item ms-lg-2 mt-2 mt-lg-0">
                        <a class="btn btn-rose btn-sm px-3 w-100 w-lg-auto" href="#appointment">
                            <i class="bi bi-calendar2-heart me-1"></i> Book Now
                        </a>
                    </li>
                    @guest
                        <li class="nav-item ms-lg-2 mt-3 mt-lg-0">
                            <a class="btn btn-outline-dark btn-sm px-3 w-100 w-lg-auto" href="{{ route('auth.login') }}">
                                Login
                            </a>
                        </li>
                        <li class="nav-item mt-2 mt-lg-0">
                            <a class="btn btn-rose btn-sm px-3 w-100 w-lg-auto" href="{{ route('auth.register') }}">
                                Register
                            </a>
                        </li>
                    @else
                        <li class="nav-item dropdown ms-lg-auto mt-3 mt-lg-0">
                            <a class="nav-link dropdown-toggle d-flex align-items-center gap-1" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle fs-5 text-rose"></i> {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="userDropdown">
                                <li>
                                    <a class="dropdown-item py-2" href="{{ route('dashboard') }}">
                                        <i class="bi bi-speedometer2 me-2 text-rose"></i> Dashboard
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item py-2" href="{{ route('dashboard') }}#settings">
                                        <i class="bi bi-person me-2 text-rose"></i> My Profile
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider" style="opacity: 0.08;"></li>
                                <li>
                                    <form method="POST" action="{{ route('auth.logout') }}" class="d-none" id="logout-form">
                                        @csrf
                                    </form>
                                    <a class="dropdown-item py-2 text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="site-footer">
        <div class="container">
            <div class="row g-4 align-items-start">
                <div class="col-lg-5">
                    <a class="footer-brand" href="{{ url('/') }}"><i class="bi bi-stars"></i> Kharbanda Makeup Studio</a>
                    <p class="mt-3 mb-0">Luxury bridal, party and occasion makeup crafted with modern technique, graceful detail and a premium studio experience.</p>
                </div>
                <div class="col-6 col-lg-2">
                    <h6>Explore</h6>
                    <a href="{{ route('gallery') }}">Gallery</a>
                </div>
                <div class="col-6 col-lg-2">
                    <h6>Studio</h6>
                    <a href="#testimonials">Testimonials</a>
                    <a href="#appointment">Appointment</a>
                    <a href="#contact">Contact</a>
                </div>
                <div class="col-lg-3">
                    <h6>Follow</h6>
                    <div class="social-links">
                        <a href="#" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                        <a href="#" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                        <a href="#contact" aria-label="Location"><i class="bi bi-geo-alt"></i></a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">© {{ date('Y') }} Kharbanda Makeup Studio. All rights reserved.</div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/main.js') }}"></script>
</body>
</html>
