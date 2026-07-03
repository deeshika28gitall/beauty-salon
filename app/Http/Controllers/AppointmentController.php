<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\BridalPackage;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use App\Mail\AppointmentBookedAdminEmail;
use App\Mail\AppointmentBookedUserEmail;

class AppointmentController extends Controller
{
    public function index()
    {
        return Appointment::query()
            ->latest()
            ->paginate(20);
    }

    public function create()
    {
        abort(404);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'service' => ['nullable', 'string', 'max:255'],
            'service_type' => ['nullable', 'string', 'max:255'],
            'preferred_date' => ['nullable', 'date'],
            'preferred_time' => ['nullable', 'date_format:H:i'],
            'event_location' => ['nullable', 'string', 'max:255'],
            'message' => ['nullable', 'string', 'max:2000'],
            'status' => ['sometimes', Rule::in(['pending', 'confirmed', 'completed', 'cancelled'])],
        ]);

        $validated['service_type'] = $validated['service_type'] ?? $validated['service'] ?? null;
        if (! empty($validated['service_type'])) {
            $package = BridalPackage::query()
                ->where('slug', $validated['service_type'])
                ->where('is_active', true)
                ->first();

            if ($package) {
                $validated['service_type'] = $package->name;
            } else {
                $service = Service::query()
                    ->where('slug', $validated['service_type'])
                    ->where('is_active', true)
                    ->first();

                if ($service) {
                    $validated['service_type'] = $service->name;
                }
            }
        }
        unset($validated['service']);

        $appointment = Appointment::create($validated);

        if (!empty($appointment->email)) {
            try {
                Mail::to($appointment->email)->send(new AppointmentBookedUserEmail($appointment));
            } catch (\Throwable $e) {
                Log::error('User appointment email failed to send.', [
                    'appointment_id' => $appointment->id,
                    'email' => $appointment->email,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        $adminEmail = config('mail.admin_address');
        if (!empty($adminEmail)) {
            try {
                Mail::to($adminEmail)->send(new AppointmentBookedAdminEmail($appointment));
            } catch (\Throwable $e) {
                Log::error('Admin appointment email failed to send.', [
                    'appointment_id' => $appointment->id,
                    'admin_email' => $adminEmail,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        if ($request->expectsJson()) {
            return response()->json($appointment, 201);
        }

        return back()->with('appointment_success', 'Your appointment request has been received. We will contact you shortly.');
    }

    public function show(Appointment $appointment)
    {
        return $appointment;
    }

    public function edit(Appointment $appointment)
    {
        abort(404);
    }

    public function update(Request $request, Appointment $appointment)
    {
        abort(404);
    }

    public function destroy(Appointment $appointment)
    {
        abort(404);
    }
}
