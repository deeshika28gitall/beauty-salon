@extends('layouts.auth')
@section('title', 'Account Settings')
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
                <span class="eyebrow">Settings</span>
                <h1>Profile settings</h1>
                <p>Update your profile information and change your password securely.</p>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('success_password'))
            <div class="alert alert-success">{{ session('success_password') }}</div>
        @endif

        <div class="row g-4">
            <div class="col-lg-6">
                <div class="dashboard-card h-100">
                    <h2 class="h5 mb-3">Update profile</h2>
                    <form method="POST" action="{{ route('dashboard.settings.update') }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control @error('name') is-invalid @enderror">
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control @error('email') is-invalid @enderror">
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <button class="btn btn-rose">Save changes</button>
                    </form>
                </div>
            </div>
            <div class="col-lg-6" id="password">
                <div class="dashboard-card h-100">
                    <h2 class="h5 mb-3">Change password</h2>
                    <form method="POST" action="{{ route('dashboard.settings.password') }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label class="form-label">Current password</label>
                            <input type="password" name="current_password" class="form-control @error('current_password') is-invalid @enderror">
                            @error('current_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">New password</label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror">
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Confirm new password</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>
                        <button class="btn btn-rose">Update password</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
