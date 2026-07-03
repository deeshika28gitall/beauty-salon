@extends('admin.layouts.app')
@section('title', 'Profile')
@section('heading', 'Change Password')
@section('content')
<form class="admin-card p-4" method="POST" action="{{ route('admin.password.update') }}">
    @csrf
    <div class="row g-3">
        <div class="col-md-4">
            <label class="form-label">Current Password</label>
            <input type="password" name="current_password" class="form-control" required>
            @error('current_password')<small class="text-danger">{{ $message }}</small>@enderror
        </div>
        <div class="col-md-4">
            <label class="form-label">New Password</label>
            <input type="password" name="password" class="form-control" required>
            @error('password')<small class="text-danger">{{ $message }}</small>@enderror
        </div>
        <div class="col-md-4">
            <label class="form-label">Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>
    </div>
    <div class="mt-4">
        <button class="btn btn-rose">Update Password</button>
    </div>
</form>
@endsection
