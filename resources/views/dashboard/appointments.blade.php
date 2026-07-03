@extends('layouts.auth')
@section('title', 'My Appointments')
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
                <span class="eyebrow">Appointments</span>
                <h1>My bookings</h1>
                <p>Review your salon and bridal appointments, status updates and booking history.</p>
            </div>
        </div>

        <div class="dashboard-card mb-4">
            <div class="dashboard-filters">
                @php($tabs = ['all' => 'All', 'upcoming' => 'Upcoming', 'past' => 'Past', 'pending' => 'Pending', 'confirmed' => 'Confirmed'])
                @foreach($tabs as $key => $label)
                    <a href="{{ route('dashboard.appointments', array_filter(['tab' => $key])) }}" @class(['active' => $activeTab === $key])>{{ $label }}</a>
                @endforeach
            </div>
        </div>

        <div class="dashboard-card">
            @forelse($appointments as $appointment)
                <article class="appointment-row">
                    <div>
                        <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                            <strong>{{ $appointment->service_type ?: 'Studio enquiry' }}</strong>
                            <span class="dashboard-status status-{{ $appointment->status }}">{{ ucfirst($appointment->status ?? 'pending') }}</span>
                        </div>
                        <p class="mb-1">{{ $appointment->message ?: 'No additional notes were provided.' }}</p>
                        <small class="text-muted d-block">
                            {{ optional($appointment->preferred_date)->format('d M Y') }}
                            @if($appointment->preferred_time)
                                · {{ \Illuminate\Support\Carbon::parse($appointment->preferred_time)->format('h:i A') }}
                            @endif
                        </small>
                    </div>
                    <div class="text-lg-end mt-3 mt-lg-0">
                        <small class="text-muted d-block mb-2">#{{ $appointment->id }}</small>
                        <a href="{{ route('dashboard.appointments.show', $appointment) }}" class="btn btn-sm btn-outline-dark">View details</a>
                    </div>
                </article>
            @empty
                <p class="text-muted mb-0">No appointments found yet. Your bookings will appear here once they are created.</p>
            @endforelse

            <div class="dashboard-pagination">
                {{ $appointments->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </section>
</div>
@endsection
