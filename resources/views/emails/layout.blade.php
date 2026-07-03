<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $subject ?? config('app.name') }}</title>
</head>
<body style="margin:0;padding:0;background:#fff7f9;font-family:Arial,Helvetica,sans-serif;color:#241b1e;">
    @php
        $brand = 'Kharbanda Makeup Studio';
        $accent = '#e84b79';
        $gold = '#c99a64';
    @endphp
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="background:linear-gradient(180deg,#fff7f9 0%,#fff 100%);padding:32px 16px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" border="0" style="max-width:640px;background:#fff;border:1px solid rgba(36,27,30,.08);border-radius:24px;overflow:hidden;box-shadow:0 20px 60px rgba(36,27,30,.08);">
                    <tr>
                        <td style="padding:28px 30px 18px;background:linear-gradient(135deg,{{ $accent }},{{ $gold }});color:#fff;">
                            <div style="font-size:12px;letter-spacing:.18em;text-transform:uppercase;font-weight:700;opacity:.9;">{{ $brand }}</div>
                            <div style="font-family:Georgia,'Times New Roman',serif;font-size:28px;line-height:1.2;margin-top:8px;font-weight:700;">{{ $headline ?? $brand }}</div>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:28px 30px 10px;">
                            @yield('content')
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:0 30px 30px;">
                            <div style="margin-top:20px;padding-top:16px;border-top:1px solid rgba(36,27,30,.08);font-size:12px;color:#74666a;line-height:1.6;">
                                This is an automated message from {{ $brand }}.
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
