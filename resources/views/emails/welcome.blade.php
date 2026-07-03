@extends('emails.layout')

@section('content')
    @php($headline = 'Welcome, ' . $user->name . '!')
    <div style="font-size:16px;line-height:1.7;color:#241b1e;">
        <p style="margin:0 0 14px;">Welcome to <strong>Kharbanda Makeup Studio</strong>. We’re delighted to have you with us.</p>
        <p style="margin:0 0 14px;">Your account is ready, and you can now log in to manage your bookings and profile details.</p>
        <div style="margin:22px 0;padding:18px 20px;background:#fff7f8;border:1px solid rgba(232,75,121,.14);border-radius:18px;">
            <div style="font-size:13px;letter-spacing:.12em;text-transform:uppercase;color:#e84b79;font-weight:700;margin-bottom:8px;">Account Details</div>
            <div style="font-size:15px;line-height:1.8;">
                <div><strong>Name:</strong> {{ $user->name }}</div>
                <div><strong>Website:</strong> Kharbanda Makeup Studio</div>
            </div>
        </div>
        <p style="margin:0 0 22px;">We look forward to helping you look and feel your best.</p>
        <a href="{{ url('/login') }}" style="display:inline-block;padding:13px 22px;background:#e84b79;color:#fff;text-decoration:none;border-radius:999px;font-weight:700;">Log in</a>
    </div>
@endsection
