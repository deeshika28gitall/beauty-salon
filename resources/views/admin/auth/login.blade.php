@extends('admin.auth.layout')
@section('title', 'Admin Login')
@section('content')
        @if($errors->any())
            <div class="alert alert-danger">{{ $errors->first() }}</div>
        @endif
        <form method="POST" action="{{ route('admin.login.store') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus>
                @error('email')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <div class="input-group">
                    <input id="adminPassword" type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                    <button class="btn btn-outline-secondary" type="button" id="togglePassword"><i class="bi bi-eye"></i></button>
                </div>
                @error('password')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
            </div>
            <div class="form-check mb-4">
                <input class="form-check-input" type="checkbox" name="remember" id="remember" value="1" @checked(old('remember'))>
                <label class="form-check-label" for="remember">Remember me</label>
            </div>
            <button class="btn btn-rose w-100" type="submit">Login</button>
            <div class="text-center mt-3"><a class="auth-link" href="{{ route('admin.register') }}">Create admin account</a></div>
        </form>
@endsection

@push('scripts')
<script>
document.getElementById('togglePassword')?.addEventListener('click', function () {
    const input = document.getElementById('adminPassword');
    const icon = this.querySelector('i');
    const isPassword = input.type === 'password';
    input.type = isPassword ? 'text' : 'password';
    icon.className = isPassword ? 'bi bi-eye-slash' : 'bi bi-eye';
});
</script>
@endpush
