<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BridalPackage extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'includes',
        'features',
        'price',
        'discount_price',
        'old_price',
        'duration_hours',
        'duration_text',
        'badge',
        'image_path',
        'short_description',
        'full_description',
        'suitable_for',
        'important_notes',
        'is_featured',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'includes' => 'array',
            'features' => 'array',
            'price' => 'decimal:2',
            'discount_price' => 'decimal:2',
            'old_price' => 'decimal:2',
            'duration_hours' => 'integer',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }
}
