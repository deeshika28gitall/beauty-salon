<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NavMenuItem extends Model
{
    protected $fillable = [
        'label',
        'href',
        'sort_order',
        'is_active',
        'open_in_new_tab',
    ];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
            'is_active' => 'boolean',
            'open_in_new_tab' => 'boolean',
        ];
    }
}
