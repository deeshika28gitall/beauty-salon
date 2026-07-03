<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeroSlide extends Model
{
    protected $fillable = [
        'badge_text',
        'main_heading',
        'description',
        'background_image_path',
        'primary_button_text',
        'primary_button_link',
        'secondary_button_text',
        'secondary_button_link',
        'stat_1_value',
        'stat_1_label',
        'stat_2_value',
        'stat_2_label',
        'stat_3_value',
        'stat_3_label',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }
}
