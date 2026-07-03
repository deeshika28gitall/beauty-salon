@extends('layouts.auth')
@section('title', 'User Dashboard')
@section('content')
<div class="dashboard-shell">
    <aside class="dashboard-sidebar">
        <a class="dashboard-brand" href="{{ url('/') }}" aria-label="Go to homepage">
            <span><i class="bi bi-stars"></i></span>
            <div>
                <strong>Kharbanda</strong>
                <small>Client Portal</small>
            </div>
        </a>
        <nav class="dashboard-nav">
            <a @class(['active' => request()->routeIs('dashboard')]) href="{{ route('dashboard') }}"><i class="bi bi-speedometer2"></i> Overview</a>
            <a @class(['active' => request()->routeIs('dashboard.appointments*')]) href="{{ route('dashboard.appointments') }}"><i class="bi bi-calendar2-heart"></i> Appointments</a>
            <a @class(['active' => request()->routeIs('dashboard.settings')]) href="{{ route('dashboard.settings') }}"><i class="bi bi-gear"></i> Settings</a>
            <form method="POST" action="{{ route('auth.logout') }}">
                @csrf
                <button class="btn btn-link p-0 text-start text-decoration-none"><i class="bi bi-box-arrow-right"></i> Logout</button>
            </form>
        </nav>
    </aside>
    <section class="dashboard-main">
        <div class="dashboard-top">
            <div>
                <span class="eyebrow">Welcome back</span>
                <h1>{{ $user->name }}</h1>
                <p>Manage your bridal and salon appointments in one elegant dashboard.</p>
            </div>
        </div>

        <div class="row g-4 mb-4" id="overview">
            <div class="col-md-4">
                <div class="dashboard-card stat-card">
                    <span>Appointments</span>
                    <strong>{{ $totalAppointments }}</strong>
                    <small>All enquiries linked to your email</small>
                </div>
            </div>
            <div class="col-md-4">
                <div class="dashboard-card stat-card">
                    <span>Upcoming</span>
                    <strong>{{ $upcomingAppointments }}</strong>
                    <small>Bookings scheduled for future dates</small>
                </div>
            </div>
            <div class="col-md-4">
                <div class="dashboard-card stat-card">
                    <span>Profile complete</span>
                    <strong>{{ $profileCompletion }}%</strong>
                    <small>Keep details updated for smoother support</small>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-7" id="appointments">
                <div class="dashboard-card h-100">
                    <div class="card-head">
                        <h2 class="h5 mb-0">Appointment History</h2>
                        <span class="badge rounded-pill text-bg-light">{{ $appointments->count() }} recent</span>
                    </div>
                    <div class="timeline">
                        @forelse($appointments as $appointment)
                            <article>
                                <div>
                                    <strong>{{ $appointment->service_type ?: 'Studio enquiry' }}</strong>
                                    <p class="mb-1">{{ \Illuminate\Support\Str::limit($appointment->message ?: 'No message provided.', 95) }}</p>
                                </div>
                                <small>{{ $appointment->created_at->format('d M Y') }}</small>
                            </article>
                        @empty
                            <p class="text-muted mb-0">No appointments found yet. Your history will appear here after the first booking.</p>
                        @endforelse
                    </div>
                </div>
            </div>
            <div class="col-lg-5" id="settings">
                <div class="dashboard-card h-100">
                    <div class="card-head">
                        <h2 class="h6 mb-0">Quick Actions</h2>
                    </div>
                    <div class="quick-grid">
                        <a href="{{ url('/#appointment') }}"><i class="bi bi-calendar-plus"></i><span>Book again</span></a>
                        <a href="{{ url('/#contact') }}"><i class="bi bi-telephone"></i><span>Contact studio</span></a>
                        <a href="{{ route('dashboard.settings') }}#password"><i class="bi bi-shield-lock"></i><span>Reset password</span></a>
                        <a href="{{ route('gallery') }}"><i class="bi bi-images"></i><span>View portfolio</span></a>
                    </div>
                    <div class="profile-panel mt-2">
                        <h3 class="h6">Profile Summary</h3>
                        <p class="mb-1"><strong>Name:</strong> {{ $user->name }}</p>
                        <p class="mb-1"><strong>Email:</strong> {{ $user->email }}</p>
                        <p class="mb-0"><strong>Status:</strong> Active client account</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
