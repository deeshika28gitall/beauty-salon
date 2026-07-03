@extends('emails.layout')

@section('content')
    @php($headline = 'New Appointment Booking')
    <div style="font-size:16px;line-height:1.7;color:#241b1e;">
        <p style="margin:0 0 14px;">A new appointment has been booked on the website.</p>
        <div style="margin:22px 0;padding:18px 20px;background:#fff7f8;border:1px solid rgba(232,75,121,.14);border-radius:18px;">
            <div style="font-size:13px;letter-spacing:.12em;text-transform:uppercase;color:#e84b79;font-weight:700;margin-bottom:8px;">Customer Details</div>
            <div style="font-size:15px;line-height:1.8;">
                <div><strong>Name:</strong> {{ $appointment->name }}</div>
                <div><strong>Email:</strong> {{ $appointment->email ?: 'Not provided' }}</div>
                <div><strong>Phone:</strong> {{ $appointment->phone }}</div>
                <div><strong>Service/Package:</strong> {{ $appointment->service_type ?: 'Studio enquiry' }}</div>
                <div><strong>Date:</strong> {{ $appointment->preferred_date?->format('d M Y') ?: 'Not selected' }}</div>
                <div><strong>Time:</strong> {{ $appointment->preferred_time?->format('H:i') ?: 'Not selected' }}</div>
                <div><strong>Reference ID:</strong> #{{ $appointment->id }}</div>
                <div><strong>Notes:</strong> {{ $appointment->message ?: 'No notes provided' }}</div>
            </div>
        </div>
    </div>
@endsection
