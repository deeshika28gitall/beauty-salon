<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceProduct extends Model
{
    protected $fillable = [
        'service_id',
        'product_name',
        'sort_order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
            'is_active' => 'boolean',
        ];
    }
}
