@extends('layouts.auth')
@section('title', 'Appointment Details')
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
                <h1>Booking reference #{{ $appointment->id }}</h1>
                <p>Detailed summary of your appointment request.</p>
            </div>
            <a href="{{ route('dashboard.appointments') }}" class="btn btn-outline-dark btn-sm">Back</a>
        </div>

        <div class="dashboard-card">
            <div class="row g-4">
                <div class="col-lg-7">
                    <h2 class="h5 mb-3">{{ $appointment->service_type ?: 'Studio enquiry' }}</h2>
                    <div class="mb-3">
                        <span class="dashboard-status status-{{ $appointment->status }}">{{ ucfirst($appointment->status ?? 'pending') }}</span>
                    </div>
                    <p class="mb-2"><strong>Date:</strong> {{ optional($appointment->preferred_date)->format('d M Y') ?: 'Not set' }}</p>
                    <p class="mb-2"><strong>Time:</strong> {{ $appointment->preferred_time ? \Illuminate\Support\Carbon::parse($appointment->preferred_time)->format('h:i A') : 'Not set' }}</p>
                    <p class="mb-2"><strong>Message:</strong> {{ $appointment->message ?: 'No message provided.' }}</p>
                </div>
                <div class="col-lg-5">
                    <div class="profile-panel">
                        <h3 class="h6">Contact Details</h3>
                        <p class="mb-1"><strong>Name:</strong> {{ $appointment->name }}</p>
                        <p class="mb-1"><strong>Email:</strong> {{ $appointment->email }}</p>
                        <p class="mb-1"><strong>Phone:</strong> {{ $appointment->phone ?: 'Not provided' }}</p>
                        <p class="mb-0"><strong>Created:</strong> {{ $appointment->created_at->format('d M Y, h:i A') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
