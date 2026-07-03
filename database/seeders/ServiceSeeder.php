<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'name' => 'Bridal Makeup',
                'slug' => 'bridal-makeup',
                'short_description' => 'Signature bridal makeup with skin prep, premium products, and a polished camera-ready finish.',
                'description' => 'Signature bridal makeup with skin prep, premium products, and a polished camera-ready finish.',
                'full_description' => 'A luxury bridal experience designed for weddings, engagement ceremonies, and reception events. The look focuses on skin preparation, long-lasting wear, and a photo-ready finish that stays beautiful through the entire celebration.',
                'starting_price' => 15000,
                'duration_minutes' => 180,
                'image_path' => 'services/bridal-makeup.jpg',
                'is_featured' => true,
                'sort_order' => 1,
            ],
            [
                'name' => 'Party Makeup',
                'slug' => 'party-makeup',
                'short_description' => 'Elegant makeup for receptions, engagements, birthdays, and special occasions.',
                'description' => 'Elegant makeup for receptions, engagements, birthdays, and special occasions.',
                'full_description' => 'A versatile service tailored for celebration-ready makeup with soft glam, bold glam, or polished party styling depending on the event and outfit.',
                'starting_price' => 4500,
                'duration_minutes' => 90,
                'image_path' => 'services/party-makeup.jpg',
                'sort_order' => 2,
            ],
            [
                'name' => 'Hair Styling',
                'slug' => 'hair-styling',
                'short_description' => 'Classic and modern hair styling for bridal and event looks.',
                'description' => 'Classic and modern hair styling for bridal and event looks.',
                'full_description' => 'From soft waves to structured buns and contemporary open-hair styling, this service covers event-ready hair styling for all occasions.',
                'starting_price' => 2500,
                'duration_minutes' => 60,
                'image_path' => 'services/hair-styling.jpg',
                'sort_order' => 3,
            ],
            [
                'name' => 'Engagement Makeup',
                'slug' => 'engagement-makeup',
                'short_description' => 'Soft glam engagement makeup for a polished, celebratory look.',
                'description' => 'Soft glam engagement makeup for a polished, celebratory look.',
                'full_description' => 'A refined engagement look with balanced skin finish, radiant glow, and styling that photographs beautifully for ring ceremony and pre-wedding events.',
                'starting_price' => 8000,
                'duration_minutes' => 120,
                'image_path' => 'services/engagement-makeup.jpg',
                'sort_order' => 4,
            ],
            [
                'name' => 'Reception Makeup',
                'slug' => 'reception-makeup',
                'short_description' => 'Polished reception makeup with elegant definition and glow.',
                'description' => 'Polished reception makeup with elegant definition and glow.',
                'full_description' => 'Designed for grand evening celebrations, this look combines lasting makeup techniques with modern styling for a polished reception-ready appearance.',
                'starting_price' => 10000,
                'duration_minutes' => 150,
                'image_path' => 'services/reception-makeup.jpg',
                'sort_order' => 5,
            ],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(['slug' => $service['slug']], $service);
        }
    }
}
