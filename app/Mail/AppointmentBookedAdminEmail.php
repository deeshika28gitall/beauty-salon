<?php

namespace App\Mail;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AppointmentBookedAdminEmail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Appointment $appointment)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Appointment Booking - Kharbanda Makeup Studio',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.appointment-admin',
            with: [
                'headline' => 'New Appointment Booking',
            ],
        );
    }
}
