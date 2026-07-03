<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\AppointmentConfirmedEmail;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class AppointmentController extends Controller
{
    public function index()
    {
        return view('admin.appointments.index', [
            'appointments' => Appointment::latest()->paginate(20),
        ]);
    }

    public function show(Appointment $appointment)
    {
        return view('admin.appointments.show', compact('appointment'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(['pending', 'confirmed', 'completed', 'cancelled'])],
        ]);

        $previousStatus = $appointment->status;
        $data['responded_at'] = $data['status'] === 'pending' ? null : now();
        $appointment->update($data);

        $shouldSendConfirmation = $previousStatus !== 'confirmed'
            && $data['status'] === 'confirmed'
            && $appointment->confirmation_email_sent_at === null
            && !empty($appointment->email);

        if ($shouldSendConfirmation) {
            try {
                Mail::to($appointment->email)->send(new AppointmentConfirmedEmail($appointment));
                $appointment->forceFill([
                    'confirmation_email_sent_at' => now(),
                ])->save();
            } catch (\Throwable $e) {
                Log::error('Appointment confirmation email failed to send.', [
                    'appointment_id' => $appointment->id,
                    'email' => $appointment->email,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        return back()->with('success', 'Appointment status updated.');
    }

    public function destroy(Appointment $appointment)
    {
        $appointment->delete();

        return redirect()->route('admin.appointments.index')->with('success', 'Appointment deleted.');
    }
}
