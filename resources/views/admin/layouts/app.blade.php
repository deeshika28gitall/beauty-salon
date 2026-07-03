<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin') | Kharbanda Makeup Studio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { background:#f7f3f4; color:#241b1e; }
        .admin-shell { min-height:100vh; display:flex; }
        .sidebar { width:280px; background:#1d1517; color:#fff; position:sticky; top:0; height:100vh; padding:24px; }
        .sidebar a { color:rgba(255,255,255,.72); text-decoration:none; display:flex; gap:10px; padding:11px 12px; border-radius:12px; margin-bottom:4px; font-weight:600; }
        .sidebar a:hover, .sidebar a.active { color:#fff; background:linear-gradient(135deg,#e84b79,#c99a64); }
        .brand { font-weight:800; margin-bottom:28px; }
        .main { flex:1; min-width:0; }
        .topbar { height:72px; background:#fff; border-bottom:1px solid rgba(0,0,0,.08); display:flex; align-items:center; justify-content:space-between; padding:0 28px; position:sticky; top:0; z-index:5; }
        .content { padding:28px; }
        .admin-card { background:#fff; border:1px solid rgba(0,0,0,.06); border-radius:18px; box-shadow:0 18px 50px rgba(36,27,30,.08); }
        .stat { padding:22px; }
        .stat strong { display:block; font-size:32px; }
        .btn-rose { color:#fff; background:linear-gradient(135deg,#e84b79,#c99a64); border:0; }
        .table img, .preview-img { width:74px; height:58px; object-fit:cover; border-radius:12px; }
        @media (max-width: 991px) {
            .admin-shell { display:block; }
            .sidebar { width:100%; height:auto; position:relative; }
            .sidebar nav { display:grid; grid-template-columns:repeat(2,1fr); gap:4px; }
            .topbar { position:relative; padding:0 16px; }
            .content { padding:18px; }
        }
    </style>
</head>
<body>
    <div class="admin-shell">
        <aside class="sidebar">
            <div class="brand"><i class="bi bi-stars text-warning"></i> Kharbanda Admin</div>
            <nav>
                <a href="{{ route('admin.dashboard') }}" @class(['active' => request()->routeIs('admin.dashboard')])><i class="bi bi-speedometer2"></i> Dashboard</a>
                <a href="{{ route('admin.users.index') }}" @class(['active' => request()->routeIs('admin.users.*')])><i class="bi bi-people"></i> Users</a>
                <a href="{{ route('admin.services.index') }}" @class(['active' => request()->routeIs('admin.services.*')])><i class="bi bi-gem"></i> Services</a>
                <a href="{{ route('admin.bridal-packages.index') }}" @class(['active' => request()->routeIs('admin.bridal-packages.*')])><i class="bi bi-heart"></i> Packages</a>
                <a href="{{ route('admin.gallery-images.index') }}" @class(['active' => request()->routeIs('admin.gallery-images.*')])><i class="bi bi-images"></i> Gallery</a>
                <a href="{{ route('admin.nav-menu-items.index') }}" @class(['active' => request()->routeIs('admin.nav-menu-items.*')])><i class="bi bi-menu-button-wide"></i> Navigation</a>
                <a href="{{ route('admin.testimonials.index') }}" @class(['active' => request()->routeIs('admin.testimonials.*')])><i class="bi bi-chat-quote"></i> Testimonials</a>
                <a href="{{ route('admin.hero-slides.index') }}" @class(['active' => request()->routeIs('admin.hero-slides.*')])><i class="bi bi-sliders"></i> Hero Slides</a>
                <a href="{{ route('admin.bookings.index') }}" @class(['active' => request()->routeIs('admin.bookings.*')])><i class="bi bi-journal-check"></i> Bookings</a>
                <a href="{{ route('admin.appointments.index') }}" @class(['active' => request()->routeIs('admin.appointments.*')])><i class="bi bi-calendar2-heart"></i> Appointments</a>
                <a href="{{ route('admin.contact-settings.edit') }}" @class(['active' => request()->routeIs('admin.contact-settings.*')])><i class="bi bi-gear"></i> Contact Settings</a>
            </nav>
        </aside>
        <div class="main">
            <header class="topbar">
                <div>
                    <h1 class="h4 mb-0">@yield('heading', 'Admin Panel')</h1>
                    <small class="text-muted">Manage public website content</small>
                </div>
                <div class="d-flex align-items-center gap-3">
                    @yield('action')
                    <div class="dropdown">
                        <button class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" type="button">
                            {{ auth()->user()->name ?? 'Admin' }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('admin.profile') }}">Profile</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.profile') }}">Change Password</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="{{ route('admin.logout') }}">
                                    @csrf
                                    <button class="dropdown-item" type="submit">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </header>
            <main class="content">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if($errors->any())
                    <div class="alert alert-danger">Please fix the highlighted fields.</div>
                @endif
                @yield('content')
            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.transition = 'opacity 0.5s ease, padding 0.5s ease, margin 0.5s ease, height 0.5s ease';
                    alert.style.overflow = 'hidden';
                    
                    const height = alert.offsetHeight;
                    alert.style.height = height + 'px';
                    
                    alert.offsetHeight; // Force reflow
                    
                    alert.style.opacity = '0';
                    alert.style.paddingTop = '0';
                    alert.style.paddingBottom = '0';
                    alert.style.marginTop = '0';
                    alert.style.marginBottom = '0';
                    alert.style.height = '0';
                    alert.style.borderTopWidth = '0';
                    alert.style.borderBottomWidth = '0';
                    
                    setTimeout(() => {
                        alert.remove();
                    }, 500);
                }, 3000);
            });
        });
    </script>
    @stack('scripts')
</body>
</html>
