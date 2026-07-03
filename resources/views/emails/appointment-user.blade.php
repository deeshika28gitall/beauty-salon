@extends('emails.layout')

@section('content')
    @php($headline = 'Appointment Request Received')
    <div style="font-size:16px;line-height:1.7;color:#241b1e;">
        <p style="margin:0 0 14px;">Hi {{ $appointment->name }}, your appointment request has been received successfully.</p>
        <div style="margin:22px 0;padding:18px 20px;background:#fff7f8;border:1px solid rgba(232,75,121,.14);border-radius:18px;">
            <div style="font-size:13px;letter-spacing:.12em;text-transform:uppercase;color:#e84b79;font-weight:700;margin-bottom:8px;">Booking Details</div>
            <div style="font-size:15px;line-height:1.8;">
                <div><strong>Name:</strong> {{ $appointment->name }}</div>
                <div><strong>Service/Package:</strong> {{ $appointment->service_type ?: 'Studio enquiry' }}</div>
                <div><strong>Date:</strong> {{ $appointment->preferred_date?->format('d M Y') ?: 'Not selected' }}</div>
                <div><strong>Time:</strong> {{ $appointment->preferred_time?->format('H:i') ?: 'Not selected' }}</div>
                <div><strong>Reference ID:</strong> #{{ $appointment->id }}</div>
                <div><strong>Contact:</strong> {{ $appointment->phone }}@if($appointment->email) | {{ $appointment->email }}@endif</div>
            </div>
        </div>
        <p style="margin:0;">Our team will contact you shortly if any further details are needed.</p>
    </div>
@endsection
