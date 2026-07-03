@extends('admin.layouts.app')
@section('title', 'Booking Details')
@section('heading', 'Booking Details')
@section('content')
<div class="row g-4">
    <div class="col-lg-8">
        <div class="admin-card p-4">
            <dl class="row mb-0">
                <dt class="col-sm-3">Booking ID</dt><dd class="col-sm-9">#{{ $booking->id }}</dd>
                <dt class="col-sm-3">Customer</dt><dd class="col-sm-9">{{ $booking->name }}</dd>
                <dt class="col-sm-3">Email</dt><dd class="col-sm-9">{{ $booking->email ?: '-' }}</dd>
                <dt class="col-sm-3">Phone</dt><dd class="col-sm-9">{{ $booking->phone }}</dd>
                <dt class="col-sm-3">Service / Package</dt><dd class="col-sm-9">{{ $booking->service_type ?: '-' }}</dd>
                <dt class="col-sm-3">Preferred Date</dt><dd class="col-sm-9">{{ $booking->preferred_date?->format('d M Y') ?: '-' }}</dd>
                <dt class="col-sm-3">Preferred Time</dt><dd class="col-sm-9">{{ $booking->preferred_time ? $booking->preferred_time->format('H:i') : '-' }}</dd>
                <dt class="col-sm-3">Status</dt><dd class="col-sm-9">{{ ucfirst($booking->status) }}</dd>
                <dt class="col-sm-3">Created</dt><dd class="col-sm-9">{{ $booking->created_at?->format('d M Y, h:i A') }}</dd>
                <dt class="col-sm-3">Message</dt><dd class="col-sm-9">{{ $booking->message ?: '-' }}</dd>
            </dl>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="admin-card p-4">
            <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-dark w-100">Back to Bookings</a>
            <a href="{{ route('admin.appointments.show', $booking) }}" class="btn btn-rose w-100 mt-3">Open Appointment Module</a>
        </div>
    </div>
</div>
@endsection
