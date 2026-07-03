@extends('admin.auth.layout')
@section('title', 'Admin Register')
@section('subtitle', 'Create an admin account')
@section('content')
    @if($errors->any())
        <div class="alert alert-danger">{{ $errors->first() }}</div>
    @endif
    <form method="POST" action="{{ route('admin.register.store') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
            @error('name')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
            @error('email')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
            @error('password')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
        </div>
        <div class="mb-3">
            <label class="form-label">Confirm Password</label>
            <input type="password" name="password_confirmation" class="form-control" required>
        </div>
        <button class="btn btn-rose w-100" type="submit">Register</button>
        <div class="text-center mt-3"><a class="auth-link" href="{{ route('admin.login') }}">Already have an account? Login</a></div>
    </form>
@endsection
