<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'service_type',
        'preferred_date',
        'preferred_time',
        'event_location',
        'message',
        'status',
        'responded_at',
        'confirmation_email_sent_at',
    ];

    protected function casts(): array
    {
        return [
            'preferred_date' => 'date',
            'preferred_time' => 'datetime:H:i',
            'responded_at' => 'datetime',
            'confirmation_email_sent_at' => 'datetime',
        ];
    }
}
