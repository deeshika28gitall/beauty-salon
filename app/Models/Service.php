<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'short_description',
        'description',
        'starting_price',
        'duration_minutes',
        'hero_image_path',
        'image_path',
        'icon',
        'is_featured',
        'is_active',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'starting_price' => 'decimal:2',
            'duration_minutes' => 'integer',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    public function features()
    {
        return $this->hasMany(ServiceFeature::class)->orderBy('sort_order');
    }

    public function galleryImages()
    {
        return $this->hasMany(ServiceGalleryImage::class)->orderBy('sort_order');
    }

    public function products()
    {
        return $this->hasMany(ServiceProduct::class)->orderBy('sort_order');
    }

    public function steps()
    {
        return $this->hasMany(ServiceStep::class)->orderBy('sort_order');
    }

    public function faqs()
    {
        return $this->hasMany(ServiceFaq::class)->orderBy('sort_order');
    }
}
