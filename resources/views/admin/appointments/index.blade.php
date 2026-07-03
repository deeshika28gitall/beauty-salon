@extends('admin.layouts.app')
@section('title', 'Appointments')
@section('heading', 'Appointment Enquiries')
@section('content')
<div class="admin-card p-3 table-responsive">
    <table class="table align-middle">
        <thead><tr><th>Name</th><th>Phone</th><th>Service</th><th>Preferred</th><th>Status</th><th></th></tr></thead>
        <tbody>@foreach($appointments as $appointment)<tr>
            <td><strong>{{ $appointment->name }}</strong><br><small>{{ $appointment->email }}</small></td>
            <td>{{ $appointment->phone }}</td>
            <td>{{ $appointment->service_type ?: '-' }}</td>
            <td>{{ $appointment->preferred_date?->format('d M Y') }} {{ $appointment->preferred_time ? $appointment->preferred_time->format('H:i') : '' }}</td>
            <td><span class="badge text-bg-secondary">{{ ucfirst($appointment->status) }}</span></td>
            <td class="text-end"><a href="{{ route('admin.appointments.show', $appointment) }}" class="btn btn-sm btn-outline-dark">View</a></td>
        </tr>@endforeach</tbody>
    </table>
    {{ $appointments->links() }}
</div>
@endsection
