<?php

namespace Database\Seeders;

use App\Models\HeroSlide;
use Illuminate\Database\Seeder;

class HeroSlideSeeder extends Seeder
{
    public function run(): void
    {
        if (HeroSlide::query()->exists()) {
            return;
        }

        HeroSlide::create([
            'badge_text' => 'PREMIUM BEAUTY STUDIO',
            'main_heading' => 'Where Beauty Meets Perfection',
            'description' => 'Kharbanda Makeup Studio creates luminous bridal looks, occasion glam and elevated beauty experiences with polished artistry and personal care.',
            'background_image_path' => 'https://images.unsplash.com/photo-1516975080664-ed2fc6a32937?auto=format&fit=crop&w=1800&q=85',
            'primary_button_text' => 'Book Appointment',
            'primary_button_link' => '#booking',
            'secondary_button_text' => 'Explore Services',
            'secondary_button_link' => '#services',
            'stat_1_value' => '3+',
            'stat_1_label' => 'Signature services',
            'stat_2_value' => '5★',
            'stat_2_label' => 'Client loved',
            'stat_3_value' => '100%',
            'stat_3_label' => 'Bridal focus',
            'is_active' => true,
            'sort_order' => 1,
        ]);
    }
}
