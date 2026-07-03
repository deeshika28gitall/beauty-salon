@extends('admin.layouts.app')
@section('title', 'Bookings')
@section('heading', 'All Bookings')
@section('content')
<div class="admin-card p-3 table-responsive">
    <table class="table align-middle">
        <thead>
            <tr>
                <th>Booking ID</th>
                <th>Customer</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Service / Package</th>
                <th>Preferred</th>
                <th>Status</th>
                <th>Created</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse($bookings as $booking)
                <tr>
                    <td>#{{ $booking->id }}</td>
                    <td>{{ $booking->name }}</td>
                    <td>{{ $booking->email ?: '-' }}</td>
                    <td>{{ $booking->phone }}</td>
                    <td>{{ $booking->service_type ?: '-' }}</td>
                    <td>{{ $booking->preferred_date?->format('d M Y') }} {{ $booking->preferred_time ? $booking->preferred_time->format('H:i') : '' }}</td>
                    <td><span class="badge text-bg-secondary">{{ ucfirst($booking->status) }}</span></td>
                    <td>{{ $booking->created_at?->format('d M Y') }}</td>
                    <td class="text-end"><a href="{{ route('admin.bookings.show', $booking) }}" class="btn btn-sm btn-outline-dark">View</a></td>
                </tr>
            @empty
                <tr><td colspan="9" class="text-center text-muted py-4">No bookings found.</td></tr>
            @endforelse
        </tbody>
    </table>
    {{ $bookings->links('pagination::bootstrap-5') }}
</div>
@endsection
