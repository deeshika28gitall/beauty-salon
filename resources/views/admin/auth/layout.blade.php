<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Auth') | Kharbanda Makeup Studio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body { min-height:100vh; background:linear-gradient(135deg,#120d0f,#2b1d20 55%,#f0c08a); display:grid; place-items:center; padding:24px; }
        .auth-card { width:min(100%, 460px); background:rgba(255,255,255,.96); border-radius:28px; box-shadow:0 30px 90px rgba(0,0,0,.25); overflow:hidden; }
        .auth-head { padding:30px; background:linear-gradient(135deg,#e84b79,#c99a64); color:#fff; }
        .auth-body { padding:30px; }
        .btn-rose { color:#fff; background:linear-gradient(135deg,#e84b79,#c99a64); border:0; }
        .auth-link { color:#c73561; text-decoration:none; font-weight:600; }
    </style>
</head>
<body>
<div class="auth-card">
    <div class="auth-head">
        <div class="fw-bold fs-4">Kharbanda Admin</div>
        <div class="opacity-75">@yield('subtitle', 'Sign in to manage the website')</div>
    </div>
    <div class="auth-body">
        @yield('content')
    </div>
</div>
@stack('scripts')
</body>
</html>
