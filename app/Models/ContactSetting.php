<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactSetting extends Model
{
    protected $fillable = [
        'studio_name',
        'phone',
        'whatsapp',
        'email',
        'address',
        'city',
        'instagram_url',
        'facebook_url',
        'map_url',
        'map_embed_url',
        'business_hours',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'business_hours' => 'array',
            'is_active' => 'boolean',
        ];
    }
}
