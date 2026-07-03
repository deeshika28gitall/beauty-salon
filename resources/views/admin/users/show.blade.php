@extends('admin.layouts.app')
@section('title', 'User Details')
@section('heading', 'User Details')
@section('content')
<div class="row g-4">
    <div class="col-lg-4">
        <div class="admin-card p-4">
            <h2 class="h5 mb-3">{{ $user->name }}</h2>
            <p class="mb-2"><strong>Email:</strong> {{ $user->email }}</p>
            <p class="mb-2"><strong>Role:</strong> {{ $user->is_admin ? 'Admin' : 'User' }}</p>
            <p class="mb-2"><strong>Registered:</strong> {{ $user->created_at?->format('d M Y, h:i A') }}</p>
            <p class="mb-0"><strong>Status:</strong> {{ $user->email_verified_at ? 'Verified' : 'Pending' }}</p>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="admin-card p-3 table-responsive">
            <h3 class="h5 px-2 pt-2">Linked Bookings</h3>
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Booking ID</th>
                        <th>Service / Package</th>
                        <th>Preferred Date</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($appointments as $appointment)
                        <tr>
                            <td>#{{ $appointment->id }}</td>
                            <td>{{ $appointment->service_type ?: '-' }}</td>
                            <td>{{ $appointment->preferred_date?->format('d M Y') ?: '-' }}</td>
                            <td><span class="badge text-bg-secondary">{{ ucfirst($appointment->status) }}</span></td>
                            <td class="text-end"><a href="{{ route('admin.appointments.show', $appointment) }}" class="btn btn-sm btn-outline-dark">View</a></td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-muted py-4">No bookings linked to this user.</td></tr>
                    @endforelse
                </tbody>
            </table>
            {{ $appointments->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection
