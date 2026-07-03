<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $testimonials = [
            [
                'client_name' => 'Aarushi Sharma',
                'service_name' => 'Bridal Makeup',
                'message' => 'The bridal look was exactly what I imagined. It stayed flawless through the entire ceremony.',
                'rating' => 5,
                'is_featured' => true,
                'sort_order' => 1,
            ],
            [
                'client_name' => 'Neha Kapoor',
                'service_name' => 'Engagement Package',
                'message' => 'Beautiful soft glam and very professional service from start to finish.',
                'rating' => 5,
                'sort_order' => 2,
            ],
            [
                'client_name' => 'Simran Kaur',
                'service_name' => 'Party Makeup',
                'message' => 'Loved the final look. It felt natural, elegant, and photographed beautifully.',
                'rating' => 5,
                'sort_order' => 3,
            ],
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::updateOrCreate(
                ['client_name' => $testimonial['client_name'], 'service_name' => $testimonial['service_name']],
                $testimonial
            );
        }
    }
}
