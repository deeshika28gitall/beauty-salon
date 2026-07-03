@extends('admin.layouts.app')
@section('title', 'Dashboard')
@section('heading', 'Dashboard')
@section('content')
<div class="row g-3 mb-4">
    @foreach([
        ['Services', $totalServices, 'bi-gem'],
        ['Packages', $totalPackages, 'bi-heart'],
        ['Gallery Images', $totalGalleryImages, 'bi-images'],
        ['Testimonials', $totalTestimonials, 'bi-chat-quote'],
        ['Appointments', $totalAppointments, 'bi-calendar2-heart'],
    ] as [$label, $value, $icon])
        <div class="col-sm-6 col-xl">
            <div class="admin-card stat">
                <i class="bi {{ $icon }} text-danger"></i>
                <strong>{{ $value }}</strong>
                <span class="text-muted">{{ $label }}</span>
            </div>
        </div>
    @endforeach
</div>
<div class="admin-card p-3">
    <h2 class="h5 mb-3">Recent Appointment Enquiries</h2>
    <div class="table-responsive">
        <table class="table align-middle">
            <thead><tr><th>Name</th><th>Phone</th><th>Service</th><th>Status</th><th>Date</th><th></th></tr></thead>
            <tbody>
                @forelse($recentAppointments as $appointment)
                    <tr>
                        <td>{{ $appointment->name }}</td>
                        <td>{{ $appointment->phone }}</td>
                        <td>{{ $appointment->service_type ?: 'Not selected' }}</td>
                        <td><span class="badge text-bg-secondary">{{ ucfirst($appointment->status) }}</span></td>
                        <td>{{ $appointment->created_at->format('d M Y') }}</td>
                        <td><a href="{{ route('admin.appointments.show', $appointment) }}" class="btn btn-sm btn-outline-dark">View</a></td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-muted">No appointment enquiries yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
