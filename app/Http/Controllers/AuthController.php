<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use App\Mail\WelcomeEmail;

class AuthController extends Controller
{
    public function login(): View
    {
        return view('auth.login');
    }

    public function authenticate(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => __('These credentials do not match our records.'),
            ]);
        }

        $request->session()->regenerate();

        return redirect()->intended('/');
    }

    public function register(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'regex:/^[a-zA-Z\s]+$/', 'min:2', 'max:100'],
            'email' => [
                'required',
                'email',
                'max:255',
                'unique:users,email',
                function ($attribute, $value, $fail) {
                    $domain = strtolower(substr(strrchr($value, "@"), 1));
                    $disposableDomains = [
                        'mailinator.com', 'yopmail.com', 'tempmail.com', 'guerrillamail.com',
                        '10minutemail.com', 'throwawaymail.com', 'dispostable.com',
                        'getairmail.com', 'maildrop.cc', 'sharklasers.com',
                        'guerrillamailblock.com', 'guerrillamail.net', 'guerrillamail.org',
                        'guerrillamail.biz', 'guerrillamail.de'
                    ];
                    if (in_array($domain, $disposableDomains)) {
                        $fail('Disposable email addresses are not allowed.');
                    }
                }
            ],
            'password' => [
                'required',
                'min:8',
                'max:64',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z\d\s]).+$/',
                'confirmed'
            ],
        ], [
            'name.required' => 'Full name is required.',
            'name.regex' => 'Name can only contain letters and spaces.',
            'name.min' => 'Name must be at least 2 characters.',
            'name.max' => 'Name cannot exceed 100 characters.',
            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email address is already registered.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.max' => 'Password cannot exceed 64 characters.',
            'password.regex' => 'Password must contain uppercase, lowercase, number and special character.',
            'password.confirmed' => 'Password confirmation does not match.',
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => strtolower($data['email']),
            'password' => Hash::make($data['password']),
        ]);

        try {
            Mail::to($user->email)->send(new WelcomeEmail($user));
        } catch (\Throwable $e) {
            Log::error('Welcome email failed to send.', [
                'user_id' => $user->id,
                'email' => $user->email,
                'error' => $e->getMessage(),
            ]);
        }

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->to('/');
    }

    public function forgotPassword(): View
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $status = Password::sendResetLink($request->only('email'));

        if ($status !== Password::RESET_LINK_SENT) {
            throw ValidationException::withMessages([
                'email' => __($status),
            ]);
        }

        return back()->with('status', __($status));
    }

    public function resetPassword(Request $request, string $token): View|RedirectResponse
    {
        if ($request->filled('email')) {
            return view('auth.reset-password', [
                'token' => $token,
                'email' => (string) $request->string('email'),
            ]);
        }

        return view('auth.reset-password', compact('token'));
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', PasswordRule::min(8)],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password): void {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status !== Password::PASSWORD_RESET) {
            throw ValidationException::withMessages([
                'email' => __($status),
            ]);
        }

        return redirect()->route('auth.login')->with('status', __($status));
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->to('/');
    }

    public function dashboard(): View
    {
        $user = auth()->user();
        $appointmentsQuery = Appointment::query()->where('email', $user->email);
        $appointments = (clone $appointmentsQuery)->latest()->limit(5)->get();

        return view('dashboard', $this->dashboardData($user, $appointments, $appointmentsQuery));
    }

    public function dashboardAppointments(Request $request): View
    {
        $user = auth()->user();
        $tab = $request->string('tab')->toString();
        $query = Appointment::query()->where('email', $user->email);

        $query = match ($tab) {
            'upcoming' => $query->whereDate('preferred_date', '>=', now()->toDateString()),
            'past' => $query->whereDate('preferred_date', '<', now()->toDateString()),
            'pending' => $query->where('status', 'pending'),
            'confirmed' => $query->where('status', 'confirmed'),
            default => $query,
        };

        $appointments = $query->orderByDesc('preferred_date')->orderByDesc('preferred_time')->paginate(5)->withQueryString();

        return view('dashboard.appointments', [
            'user' => $user,
            'appointments' => $appointments,
            'activeTab' => $tab ?: 'all',
        ]);
    }

    public function dashboardAppointmentShow(Appointment $appointment): View
    {
        $this->authorizeDashboardAppointment($appointment);

        return view('dashboard.appointment-show', [
            'user' => auth()->user(),
            'appointment' => $appointment,
        ]);
    }

    public function dashboardSettings(): View
    {
        return view('dashboard.settings', [
            'user' => auth()->user(),
            'profileCompletion' => 85,
        ]);
    }

    public function updateDashboardSettings(Request $request): RedirectResponse
    {
        $user = auth()->user();

        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
        ]);

        $user->fill([
            'name' => $data['name'],
            'email' => strtolower($data['email']),
        ])->save();

        return back()->with('success', 'Profile updated successfully.');
    }

    public function updateDashboardPassword(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', PasswordRule::min(8)],
        ]);

        $user = auth()->user();
        $user->forceFill([
            'password' => Hash::make($request->string('password')),
        ])->save();

        return back()->with('success_password', 'Password updated successfully.');
    }

    private function dashboardData(User $user, $appointments, $appointmentsQuery): array
    {
        return [
            'user' => $user,
            'appointments' => $appointments,
            'totalAppointments' => $appointmentsQuery->count(),
            'upcomingAppointments' => (clone $appointmentsQuery)
                ->whereDate('preferred_date', '>=', now()->toDateString())
                ->count(),
            'profileCompletion' => 85,
        ];
    }

    private function authorizeDashboardAppointment(Appointment $appointment): void
    {
        abort_unless($appointment->email === auth()->user()->email, 404);
    }
}
