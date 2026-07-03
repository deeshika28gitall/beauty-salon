@extends('admin.layouts.app')
@section('title', 'Appointment Details')
@section('heading', 'Appointment Details')
@section('content')
<div class="row g-4">
    <div class="col-lg-8">
        <div class="admin-card p-4">
            <dl class="row mb-0">
                <dt class="col-sm-3">Name</dt><dd class="col-sm-9">{{ $appointment->name }}</dd>
                <dt class="col-sm-3">Phone</dt><dd class="col-sm-9">{{ $appointment->phone }}</dd>
                <dt class="col-sm-3">Email</dt><dd class="col-sm-9">{{ $appointment->email ?: '-' }}</dd>
                <dt class="col-sm-3">Service</dt><dd class="col-sm-9">{{ $appointment->service_type ?: '-' }}</dd>
                <dt class="col-sm-3">Preferred Date</dt><dd class="col-sm-9">{{ $appointment->preferred_date?->format('d M Y') ?: '-' }}</dd>
                <dt class="col-sm-3">Preferred Time</dt><dd class="col-sm-9">{{ $appointment->preferred_time ? $appointment->preferred_time->format('H:i') : '-' }}</dd>
                <dt class="col-sm-3">Location</dt><dd class="col-sm-9">{{ $appointment->event_location ?: '-' }}</dd>
                <dt class="col-sm-3">Message</dt><dd class="col-sm-9">{{ $appointment->message ?: '-' }}</dd>
            </dl>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="admin-card p-4">
            <form method="POST" action="{{ route('admin.appointments.update', $appointment) }}">
                @csrf @method('PUT')
                <label class="form-label">Status</label>
                <select name="status" class="form-select mb-3">
                    @foreach(['pending','confirmed','completed','cancelled'] as $status)
                        <option value="{{ $status }}" @selected($appointment->status === $status)>{{ ucfirst($status) }}</option>
                    @endforeach
                </select>
                <button class="btn btn-rose w-100">Update Status</button>
            </form>
            <form method="POST" action="{{ route('admin.appointments.destroy', $appointment) }}" class="mt-3" onsubmit="return confirm('Delete this enquiry?')">
                @csrf @method('DELETE')
                <button class="btn btn-outline-danger w-100">Delete Enquiry</button>
            </form>
        </div>
    </div>
</div>
@endsection
