@php
    $authImages = [
        asset('images/auth/image.png'),
        asset('images/auth/hair-styling.jpg'),
        asset('images/auth/image1.png'),
    ];

    $slides = [
        $authImages[0],
        $authImages[1],
        $authImages[2],
    ];
@endphp
<div class="auth-page">
    <div class="auth-card">
        <div class="auth-visual">
            <div id="authCarousel" class="carousel slide carousel-fade h-100" data-bs-ride="carousel" data-bs-interval="4500">
                <div class="carousel-inner h-100">
                    @foreach($slides as $slide)
                        <div class="carousel-item h-100 @if($loop->first) active @endif">
                            <div class="auth-slide">
                                <img src="{{ $slide }}" alt="" aria-hidden="true">
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="auth-panel">
            <div class="auth-column">
                <div class="auth-header">
                    <a href="{{ url('/') }}" class="auth-brand"><span><i class="bi bi-stars"></i></span> Kharbanda Makeup Studio</a>
                </div>

                @if(session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">Please review the form and try again.</div>
                @endif

                @if($mode === 'login')
                    <form method="POST" action="{{ route('auth.authenticate') }}" class="auth-form">
                        @csrf
                        <h2>Welcome back</h2>
                        <p class="form-note">Sign in to manage bookings, profile details and appointment history.</p>
                        <div class="mb-3">
                            <label class="form-label" for="email">Email</label>
                            <input id="email" name="email" type="email" class="form-control" value="{{ old('email') }}" required autofocus>
                            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="password">Password</label>
                            <input id="password" name="password" type="password" class="form-control" required>
                            @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <div class="d-flex justify-content-between align-items-center gap-3 mb-3">
                            <label class="form-check-label d-flex align-items-center gap-2">
                                <input type="checkbox" name="remember" class="form-check-input mt-0"> Remember me
                            </label>
                            <a href="{{ route('auth.password.request') }}">Forgot password?</a>
                        </div>
                        <button class="btn btn-rose w-100" type="submit">Login</button>
                        <p class="switch-link">New here? <a href="{{ route('auth.register') }}">Create an account</a></p>
                    </form>
                @elseif($mode === 'register')
                    <form method="POST" action="{{ route('auth.store') }}" class="auth-form" id="registerForm" novalidate>
                        @csrf
                        <h2>Create account</h2>
                        <p class="form-note">Join the studio client portal to track your bookings and updates.</p>
                        <div class="mb-2">
                            <label class="form-label" for="name">Full name</label>
                            <input id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required autocomplete="name">
                            <div class="invalid-feedback d-block" id="name-error">@error('name') {{ $message }} @enderror</div>
                        </div>
                        <div class="mb-2">
                            <label class="form-label" for="email">Email</label>
                            <input id="email" name="email" type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autocomplete="email">
                            <div class="invalid-feedback d-block" id="email-error">@error('email') {{ $message }} @enderror</div>
                        </div>
                        <div class="mb-2">
                            <label class="form-label" for="password">Password</label>
                            <input id="password" name="password" type="password" class="form-control @error('password') is-invalid @enderror" required autocomplete="new-password">
                            <div class="invalid-feedback d-block" id="password-error">@error('password') {{ $message }} @enderror</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="password_confirmation">Confirm password</label>
                            <input id="password_confirmation" name="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" required autocomplete="new-password">
                            <div class="invalid-feedback d-block" id="password_confirmation-error">@error('password_confirmation') {{ $message }} @enderror</div>
                        </div>
                        <button class="btn btn-rose w-100" type="submit">Register</button>
                        <p class="switch-link">Already have an account? <a href="{{ route('auth.login') }}">Sign in</a></p>
                    </form>
                @elseif($mode === 'forgot')
                    <form method="POST" action="{{ route('auth.password.email') }}" class="auth-form">
                        @csrf
                        <h2>Reset password</h2>
                        <p class="form-note">We’ll send a secure reset link to your email address.</p>
                        <div class="mb-3">
                            <label class="form-label" for="email">Email</label>
                            <input id="email" name="email" type="email" class="form-control" value="{{ old('email') }}" required>
                        </div>
                        <button class="btn btn-rose w-100" type="submit">Send reset link</button>
                        <p class="switch-link">Remembered it? <a href="{{ route('auth.login') }}">Back to login</a></p>
                    </form>
                @elseif($mode === 'reset')
                    <form method="POST" action="{{ route('auth.password.update') }}" class="auth-form">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">
                        <h2>Set new password</h2>
                        <p class="form-note">Choose a strong password to secure your account.</p>
                        <div class="mb-2">
                            <label class="form-label" for="email">Email</label>
                            <input id="email" name="email" type="email" class="form-control" value="{{ $email }}" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label" for="password">New password</label>
                            <input id="password" name="password" type="password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="password_confirmation">Confirm new password</label>
                            <input id="password_confirmation" name="password_confirmation" type="password" class="form-control" required>
                        </div>
                        <button class="btn btn-rose w-100" type="submit">Update password</button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
